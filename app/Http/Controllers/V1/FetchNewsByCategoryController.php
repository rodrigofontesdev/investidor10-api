<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\NewsCollection;
use App\Models\Category;
use App\Models\News;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class FetchNewsByCategoryController extends Controller
{
    public function __invoke(Request $request, string $category): JsonResource|JsonResponse
    {
        $request->merge(['category' => $category]);

        $validator = Validator::make($request->all(), [
            'perPage' => ['numeric'],
            'cursor' => ['string'],
            'category' => ['string', 'exists:categories,slug'],
            'featured' => ['in:true,false'],
            'orderBy' => ['in:asc,desc'],
        ]);

        if ($validator->fails()) {
            return Response::json([
                'type' => 'INVALID_REQUEST_ERROR',
                'code' => 400,
                'message' => 'The request was not accepted due to a missing required field or an error in the field format.',
                'path' => '/'.$request->path(),
                'timestamp' => now(),
                'errors' => $validator->errors(),
            ], 400);
        }

        try {
            $validated = $validator->safe();
            $featured = (bool) $validated->featured;
            $orderBy = $validated->orderBy;

            $categoryResource = Category::where('slug', $validated->category)
                ->select('id')
                ->firstOrFail();

            $news = News::where('category', $categoryResource->id)
                ->when(
                    $featured,
                    function (Builder $query, bool $featured) {
                        $query->where('featured', $featured);
                    }
                )->when(
                    $orderBy,
                    function (Builder $query, string $orderBy) {
                        $query->orderBy('id', $orderBy);
                    }
                )->cursorPaginate($validated->perPage);

            return new NewsCollection($news);
        } catch (QueryException $error) {
            return Response::json([
                'type' => 'API_ERROR',
                'code' => 500,
                'message' => 'Something went wrong with our servers. Please, contact the system admin at '.config('mail.from.address').'.',
                'path' => '/'.$request->path(),
                'timestamp' => now(),
                'errors' => $error->getMessage(),
            ], 500);
        }
    }
}
