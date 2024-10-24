<?php

use App\Models\Category;
use App\Models\News;
use Illuminate\Testing\Fluent\AssertableJson;

describe('Fetch News By Category', function () {
    beforeEach(function () {
        $this->endpoint = '/api/v1/categories';
    });

    it('should return an error response if perPage parameter is not a number', function () {
        $category = Category::factory()->create();

        $response = $this->getJson("{$this->endpoint}/{$category->slug}/?perPage=xyz");

        $response->assertStatus(400);
        $response->assertInvalid(['perPage']);
    });

    it('should return an error response if the category does not exists', function () {
        $response = $this->getJson($this->endpoint . '/abacate');

        $response->assertStatus(400);
        $response->assertInvalid(['category']);
    });

    it('should return a specific number of items per page', function () {
        $category = Category::factory()->create();
        News::factory()->count(15)->create(['category' => $category->id]);
        $perPage = 5;

        $response = $this->getJson("{$this->endpoint}/{$category->slug}/?perPage={$perPage}");

        $response->assertStatus(200);
        $response->assertJson(
            fn(AssertableJson $json) =>
            $json->has(
                'data',
                $perPage,
                fn(AssertableJson $json) =>
                $json->where('category.id', $category->id)->etc()
            )->etc()
        );
    });

    it('should be able to load more items', function () {
        $category = Category::factory()->create();
        News::factory()->count(15)->create(['category' => $category->id]);
        $perPage = 5;

        $response = $this->getJson("{$this->endpoint}/{$category->slug}/?perPage={$perPage}");
        $nextCursor = $response['meta']['next_cursor'];
        $newResponse = $this->getJson("{$this->endpoint}/{$category->slug}/?perPage={$perPage}&cursor={$nextCursor}");

        $newResponse->assertStatus(200);
        $newResponse->assertJson(
            fn(AssertableJson $json) =>
            $json->has('data', $perPage)
                ->has(
                    'data.0',
                    fn(AssertableJson $json) =>
                    $json->where('id', 6)->etc()
                )->etc()
        );
    });
});
