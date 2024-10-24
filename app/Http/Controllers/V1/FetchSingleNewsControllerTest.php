<?php

use App\Models\Category;
use App\Models\News;
use Illuminate\Testing\Fluent\AssertableJson;

describe('Fetch Single News', function () {
    beforeEach(function () {
        $this->endpoint = '/api/v1/news';
    });

    it('should return an error response if the news does not exists', function () {
        $response = $this->getJson($this->endpoint . '/some-slug');

        $response->assertStatus(400);
        $response->assertInvalid(['slug']);
    });

    it('should return the news data', function () {
        $category = Category::factory()->create();
        $news = News::factory()->create(['category' => $category->id]);

        $response = $this->getJson($this->endpoint . '/' . $news->slug);

        $response->assertStatus(200);
        $response->assertJson(
            fn(AssertableJson $json) =>
            $json->where('data.slug', $news->slug)
                ->etc()
        );
    });
});
