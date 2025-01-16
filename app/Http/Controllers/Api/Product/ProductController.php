<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Services\Product\ProductServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{


    public function __construct(protected ProductServiceInterface $productService) {}
    /**
     * Display a listing of the resource.
     */
    public function index(): Response|JsonResponse

    {
        return response()->json(
            $this->productService->all()
        );
    }
    public function allWithQueries(): Response|JsonResponse

    {
        return response()->json(
            $this->productService->allProductWithQueries()
        );
    }

    public function store(CreateProductRequest $request)
    {

        try {
            $data = $request->all();
            $images = $request->images ?: [];
            $categories = $request->categories ?: [];
            $variants = $request->variations ?: [];
         
            $create = $this->productService->create($data, [
                'images' => $images,
                'categories' => $categories,
                'variants' => $variants
            ]);
            return response()->json([
                'message' => __('messages.created-success'),
                'status' => true,
                'product' => $create
            ], 201);
        } catch (\Throwable $throwable) {
            Log::error(
                message: __CLASS__ . '@' . __FUNCTION__,
                context: [
                    'line' => $throwable->getLine(),
                    'message' => $throwable->getMessage()
                ]
            );
            if($throwable instanceof Exception){
                return response()->json([
                   'status' => false,
                   'message' => $throwable->getMessage()
                ], 500);
            }
            if($throwable instanceof \InvalidArgumentException){
                return \response()->json([
                    'status' => false,
                    'message' => $throwable->getMessage()
                ], 400);
            }
            return response()->json([
                'message' => __('messages.error-internal-server'),
                'status' => false,
            ], 500);
        }
    }


    public function updateVariations(int|string $id,Request $request){
        try {
            $variants = $request->variations ? $request->variations: [];
           
            $update = $this->productService->updateVariations($id,$variants);
            return response()->json([
                'message' => __('messages.update-success'),
                'status' => true,
                'product' => $update
            ], 201);
        } catch (\Throwable $throwable) {
            Log::error(
                message: __CLASS__ . '@' . __FUNCTION__,
                context: [
                    'line' => $throwable->getLine(),
                    'message' => $throwable->getMessage()
                ]
            );
            if($throwable instanceof Exception){
                return response()->json([
                   'status' => false,
                   'message' => $throwable->getMessage()
                ], 500);
            }
            if($throwable instanceof \InvalidArgumentException){
                return \response()->json([
                    'status' => false,
                    'message' => $throwable->getMessage()
                ], 400);
            }
            return response()->json([
                'message' => __('messages.error-internal-server'),
                'status' => false,
            ], 500);
        }
    }

    public function createAttributeValues(Request $request): Response|JsonResponse
    {
        try {
            if (empty($request->attribute)) {
                return \response()->json([
                    'status' => false,
                    'error' => __('messages.error-required'),
                ], 400);
            }
            if (empty($request->values)) {
                return \response()->json([
                    'status' => false,
                    'error' => __('messages.error-required'),
                ], 400);
            } elseif (!is_array($request->values)) {
                return \response()->json([
                    'status' => false,
                    'error' => __('messages.error-value'),
                ], 400);
            }
            $attribute = $request->attribute;
            $values = $request->values;
            $data = $this->productService->createAttributeValues( $attribute, $values);
            return \response()->json(
                [
                    ...$data,
                   'status' => true,
                ],
                201
            );
        } catch (\Throwable $throw) {
            Log::error(
                message: __CLASS__ . '@' . __FUNCTION__,
                context: [
                    'line' => $throw->getLine(),
                    'message' => $throw->getMessage()
                ]
            );
            if ($throw instanceof ModelNotFoundException) {
                return \response()->json([
                    'status' => false,
                    'error' => $throw->getMessage()
                ], 404);
            }
            return \response()->json([
                'status' => false,
                'error' => $throw->getMessage()
            ], 500);
        }
    }
    public function getAttributeValues(int|string $id)
    {
        try {
            return response()->json($this->productService->productAttribute($id));
        } catch (\Throwable $throw) {
            Log::error(
                message: __CLASS__ . '@' . __FUNCTION__,
                context: [
                    'line' => $throw->getLine(),
                    'message' => $throw->getMessage()
                ]
            );
            return response()->json([
                'error' => $throw->getMessage(),
                'status' => false
            ], 404);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string|int $id): Response|JsonResponse
    {
        try {
            return response()->json($this->productService->findById($id));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'status' => false
            ], 404);
        }
    }
    public function productDetail(string|int $id)
    {
        try {
            return response()->json($this->productService->productDetail($id));
        } catch (\Throwable $throw) {
            Log::error(
                message: __CLASS__ . '@' . __FUNCTION__,
                context: [
                    'line' => $throw->getLine(),
                    'message' => $throw->getMessage()
                ]
            );
            return response()->json([
                'error' => $throw->getMessage(),
                'status' => false
            ], 404);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string|int $id)
    {
        try {
            $data = $request->all();
            $images = $request->images ?: [];
            $categories = $request->categories ?: [];
            $variants = $request->variations ?: [];
            $update = $this->productService->update($id, $data, [
                'images' => $images,
                'categories' => $categories,
                'variants' => $variants,
            ]);
            return response()->json([
                'message' => __('messages.update-success'),
                'status' => true,
                ...$update
            ], 201);
        } catch (\Throwable $throwable) {
            Log::error(
                message: __CLASS__ . '@' . __FUNCTION__,
                context: [
                    'line' => $throwable->getLine(),
                    'message' => $throwable->getMessage()
                ]
            );
            if($throwable instanceof Exception){
                return response()->json([
                   'status' => false,
                   'message' => $throwable->getMessage()
                ], 500);
            }
            if($throwable instanceof \InvalidArgumentException){
                return \response()->json([
                    'status' => false,
                    'message' => $throwable->getMessage()
                ], 400);
            }
            if($throwable instanceof ModelNotFoundException){
                return \response()->json([
                    'status' => false,
                    'message' => $throwable->getMessage()
                ], 404);
            }
            return response()->json([
                'message' => __('messages.error-internal-server'),
                'status' => false,
            ], 500);
        }
    }
    public function productsByCategory(int|string $categoryId)
    {
        return response()->json([
            'status' => true,
            'products' => $this->productService->productByCategory($categoryId),
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int|string $id)
    {
        try {
            $this->productService->destroy($id);
            return \response()->json([
                'status' => true,
                'message' => __('messages.delete-success'),
            ]);
        } catch (\Throwable $throw) {
            Log::error(
                message: __CLASS__ . '@' . __FUNCTION__,
                context: [
                    'line' => $throw->getLine(),
                    'message' => $throw->getMessage()
                ]
            );
            if ($throw instanceof ModelNotFoundException) {
                return \response()->json([
                    'status' => false,
                    'error' => $throw->getMessage()
                ], 404);
            }
            return \response()->json([
                'status' => false,
                'error' => __('messages.error-internal-server'),
            ], 500);
        }
    }

    public function productWithTrashed()
    {
        return \response()->json([
            'status' => true,
            'products' => $this->productService->productWithTrashed()
        ], 200);
    }
    public function productTrashed()
    {
        return \response()->json([
            'status' => true,
            'products' => $this->productService->productTrashed()
        ], 200);
    }
    public function getOneTrashed(int|string $id)
    {
        try {
            return response()->json($this->productService->findProductTrashed($id));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'status' => false
            ], 404);
        }
    }
    public function restore(int|string $id)
    {
        try {
            $product = $this->productService->restore($id);
            return \response()->json([
                'status' => true,
                'product' => $product,
                'message' => __('messages.restore-success'),
            ], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'status' => false
            ], 404);
        }
    }
    public function forceDestroy(int|string $id)
    {
        try {
            $sucess = $this->productService->forceDestroy($id);
            return \response()->json([
                'status' => $sucess,
                'message' => __('messages.delete-success'),

            ]);
        } catch (\Throwable $throwable) {
            Log::error(
                message: __CLASS__ . '@' . __FUNCTION__,
                context: [
                    'line' => $throwable->getLine(),
                    'message' => $throwable->getMessage()
                ]
            );
            if ($throwable instanceof ModelNotFoundException) {
                return \response()->json([
                    'status' => false,
                    'error' => $throwable->getMessage()
                ], 404);
            }
            return response()->json([
                'status' => false,
                'error' => __('messages.error-internal-server'),
            ], 500);
        }
    }

    public function filterProduct()
    {
        return \response()->json([
            'status' => true,
            'products' => $this->productService->filterProduct()
        ]);
    }

    public function allSummary()
    {
        return \response()->json([
            'status' => true,
            'products' => $this->productService->allSummary()
        ]);
    }
}
