<?php

namespace App\Http\Controllers\Product;

use App\Exceptions\CustomException;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\DeleteRequest;
use App\Http\Requests\Product\IndexRequest;
use App\Http\Requests\Product\ShowRequest;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Resources\ProductResource;
use App\Services\Managers\ProductManager;
use App\Traits\HasPagination;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    use HasPagination;
    /**
     * Handle the incoming request.
     *
     * @param IndexRequest $request
     * @param ProductManager $productManager
     * @return JsonResponse
     * @throws CustomException
     */
    public function index(IndexRequest $request, ProductManager $productManager): JsonResponse
    {
        $result = $productManager->getModels(
            $request->all()
        );

        return ApiResponse::pagination(ProductResource::collection($result), $this->paginate($result));
    }

    /**
     * Handle the incoming request.
     *
     * @param ShowRequest $request
     * @param int $id
     * @param ProductManager $productManager
     * @return JsonResponse
     * @throws CustomException
     */
    public function show(ShowRequest $request, int $id, ProductManager $productManager): JsonResponse
    {
        $product = $productManager->getModel(
            $id
        );

        return ApiResponse::data(new ProductResource($product));

    }

    /**
     * Handle the incoming request.
     *
     * @param StoreRequest $request
     * @param ProductManager $productManager
     * @return JsonResponse
     */
    public function store(StoreRequest $request, ProductManager $productManager): JsonResponse
    {
        $result = $productManager->storeModel(
            $request->validated()
        );

        return ApiResponse::message(true, 'PRODUCT_CREATED', new ProductResource($result));

    }

    /**
     * Handle the incoming request.
     *
     * @param UpdateRequest $request
     * @param int $id
     * @param ProductManager $productManager
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $id, ProductManager $productManager): JsonResponse
    {
        $result=$productManager->updateModel(
            $id,
            $request->validated()
        );

        return ApiResponse::message($result > 0, $result > 0 ? 'PRODUCT_UPDATED' : 'PRODUCT_NOT_UPDATED');

    }

    /**
     * Handle the incoming request.
     *
     * @param DeleteRequest $request
     * @param int $id
     * @param ProductManager $productManager
     * @return JsonResponse
     */
    public function destroy(DeleteRequest $request, int $id, ProductManager $productManager): JsonResponse
    {
        $result = $productManager->deleteModelById(
            $id
        );

        return ApiResponse::message($result > 0, $result > 0 ? 'PRODUCT_DELETED' : 'PRODUCT_NOT_DELETED');

    }
}
