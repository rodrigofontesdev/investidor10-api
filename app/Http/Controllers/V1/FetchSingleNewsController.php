<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\NewsResource;
use App\Models\News;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class FetchSingleNewsController extends Controller
{
    public function __invoke(Request $request, string $slug): JsonResource | JsonResponse
    {
        $request->merge(['slug' => $slug]);

        $validator = Validator::make($request->all(), [
            'slug' => ['string', 'exists:news,slug']
        ], [
            'slug.exists' => 'The news does not exists.'
        ]);

        if ($validator->fails()) {
            return Response::json([
                'type' => 'INVALID_REQUEST_ERROR',
                'code' => 400,
                'message' => 'The request was not accepted due to a missing required field or an error in the field format.',
                'path' => '/' . $request->path(),
                'timestamp' => now(),
                'errors' => $validator->errors(),
            ], 400);
        }

        try {
            $validated = $validator->safe();

            return new NewsResource(News::where('slug', $validated->slug)->firstOrFail());
        } catch (QueryException $error) {
            return Response::json([
                'type' => 'API_ERROR',
                'code' => 500,
                'message' => 'Something went wrong with our servers. Please, contact the system admin at ' . config('mail.from.address') . '.',
                'path' => '/' . $request->path(),
                'timestamp' => now(),
                'errors' => $error->getMessage(),
            ], 500);
        }
    }
}
