<?php

namespace App\Http\Controllers\Api\Review;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\CreateReviewRequest;
use App\Http\Requests\Review\UpdateReviewRequest;
use App\Services\Review\ReviewServiceInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Exception;

class ReviewController extends Controller
{
    public function __construct(protected ReviewServiceInterface $reviewService)
    {
    }

    /**
     * Display a listing of the reviews.
     */
    public function index(): Response|JsonResponse
    {
        return \response()->json([
            "reviews" => $this->reviewService->all()
        ]);
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(CreateReviewRequest $request): JsonResponse
    {
        try {
            $review = $this->reviewService->create($request->validated());
            return response()->json([
                'message' => __('messages.created-success'),
                'review' => $review
            ], 201);
        } catch (\Throwable $throw) {
            Log::error('Some thing went wrong!', [
                'message' => $throw->getMessage(),
                'file' => $throw->getFile(),
                'line' => $throw->getLine(),
                'trace' => $throw->getTraceAsString(),
            ]);

           if($throw instanceof ModelNotFoundException)
           {
               return response()->json([
                   'status' => false,
                   'message' => $throw->getMessage()
               ],404);
           }
           if($throw instanceof Exception){
               return response()->json([
                   'status' => false,
                   'message' => $throw->getMessage()
               ],401);
           }
           return response()->json([
               'status' => false,
               'message' => __('messages.error-internal-server'),
           ],500);
        }
    }

    /**
     * Display the specified review.
     */
    public function show(int|string $id): Response|JsonResponse
    {
        try {
            return response()->json([
                'status' => true,
                'review' => $this->reviewService->find($id)
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()],
                404);
        }
    }

    /**
     * Update the specified review in storage.
     */
    public function update(UpdateReviewRequest $request, string|int $id)
    {
        try {
            $review = $this->reviewService->update($id, $request->validated());
            return response()->json([
                'status' => true,
                'message' => __('messages.update-success'),
                'review' => $review
            ], 201);
        } catch (\Exception $e) {
            Log::error('Some thing went wrong!', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * Remove the specified review from storage.
     */
    public function destroy(int|string $id): JsonResponse
    {
        try {
            $this->reviewService->delete($id);
            return response()->json([
                'status' => true,
                'message' => __('messages.delete-success'),
            ]);
        } catch (\Throwable $throw) {
            if($throw instanceof ModelNotFoundException)
            {
                return response()->json([
                    'status' => false,
                    'message' => $throw->getMessage()
                ],404);
            }
            if($throw instanceof AuthorizationException){
                return response()->json([
                    'status' => false,
                    'message' => $throw->getMessage()
                ],401);
            }
            return response()->json([
                'status' => false,
                'message' => __('messages.error-internal-server'),
            ],500);
        }
    }
    public function forceDestroy(int|string $id): JsonResponse
    {
        try {
            $this->reviewService->forceDelete($id);
            return response()->json([
                'status' => true,
                'message' => __('messages.delete-success'),
            ]);
        } catch (\Throwable $throw) {
            if($throw instanceof ModelNotFoundException)
            {
                return response()->json([
                    'status' => false,
                    'message' => $throw->getMessage()
                ],404);
            }
            if($throw instanceof AuthorizationException){
                return response()->json([
                    'status' => false,
                    'message' => $throw->getMessage()
                ],401);
            }
            return response()->json([
                'status' => false,
                'message' => __('messages.error-internal-server'),
            ],500);
        }
    }

    public function restore(int|string $id): JsonResponse
    {
        try {
            $this->reviewService->restore($id);
            return response()->json([
                'status' => true,
                'message' => __('messages.restore-success'),
            ]);
        } catch (\Throwable $throw) {
            if($throw instanceof ModelNotFoundException)
            {
                return response()->json([
                    'status' => false,
                    'message' => $throw->getMessage()
                ],404);
            }
            if($throw instanceof AuthorizationException){
                return response()->json([
                    'status' => false,
                    'message' => $throw->getMessage()
                ],401);
            }
            return response()->json([
                'status' => false,
                'message' => __('messages.error-internal-server'),
            ],500);
        }
    }
    public function toggleLike(int $review_id): JsonResponse
    {
        try {
            $user_id = request()->user()->id; 
            $likesCount = $this->reviewService->toggleLike($review_id, $user_id);
            return response()->json([
                'status' => true,
                'message' => __('messages.created-success'),
                'likes_count' => $likesCount,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error in toggleLike: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function reviewsByProduct(int|string $id): Response|JsonResponse
    {
        try {
            $reviews = $this->reviewService->reviewsByProduct($id);
            return response()->json([
                'status' => true,
                'reviews' => $reviews
            ]);
        }catch (\Throwable $throw)
        {
            Log::error(
                message: __CLASS__.'@'.__FUNCTION__,context: [
                'line' => $throw->getLine(),
                'message' => $throw->getMessage()
            ]
            );
            if($throw instanceof ModelNotFoundException)
            {
                return response()->json([
                    'status' => false,
                    'message' => $throw->getMessage()
                ],404);
            }
            return response()->json([
                'status' => false,
                'message' => __('messages.error-internal-server'),
            ],500);
        }
    }

}
