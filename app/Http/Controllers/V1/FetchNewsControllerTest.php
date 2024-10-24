<?php

use App\Models\News;
use Illuminate\Testing\Fluent\AssertableJson;

describe('Fetch News', function () {
    beforeEach(function () {
        $this->endpoint = '/api/v1/news';
    });

    it('should return an error response if perPage parameter is not a number', function () {
        $response = $this->getJson($this->endpoint . '/?perPage=xyz');

        $response->assertStatus(400);
        $response->assertInvalid(['perPage']);
    });

    it('should return a specific number of items per page', function () {
        News::factory()->count(15)->create();
        $perPage = 5;

        $response = $this->getJson("{$this->endpoint}/?perPage={$perPage}");

        $response->assertStatus(200);
        $response->assertJsonCount($perPage, 'data');
    });

    it('should be able to load more items', function () {
        News::factory()->count(15)->create();
        $perPage = 5;

        $response = $this->getJson("{$this->endpoint}/?perPage={$perPage}");
        $cursor = $response['meta']['next_cursor'];
        $newResponse = $this->getJson("{$this->endpoint}/?perPage={$perPage}&cursor={$cursor}");

        $newResponse->assertStatus(200);
        $newResponse->assertJson(
            fn(AssertableJson $json) =>
            $json->has('data', $perPage)
                ->has(
                    'data.0',
                    fn(AssertableJson $json) =>
                    $json->where('id', 6)
                        ->etc()
                )
                ->etc()
        );
    });
});
