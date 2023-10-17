<?php

namespace App\Http\Controllers\Order;

use App\Exceptions\CustomException;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\DeleteRequest;
use App\Http\Requests\Order\DiscountRequest;
use App\Http\Requests\Order\IndexRequest;
use App\Http\Requests\Order\ShowRequest;
use App\Http\Requests\Order\StoreRequest;
use App\Http\Requests\Order\UpdateRequest;
use App\Http\Resources\OrderResource;
use App\Services\Managers\OrderManager;
use App\Traits\HasPagination;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{

    use HasPagination;
    /**
     * Handle the incoming request.
     *
     * @param IndexRequest $request
     * @param OrderManager $orderManager
     * @return JsonResponse
     * @throws CustomException
     */
    public function index(IndexRequest $request, OrderManager $orderManager): JsonResponse
    {
        $result = $orderManager->getModels(
            $request->all()
        );

        return ApiResponse::pagination(OrderResource::collection($result), $this->paginate($result));
    }
    /**
     * Handle the incoming request.
     *
     * @param UpdateRequest $request
     * @param int $id
     * @param OrderManager $orderManager
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $id, OrderManager $orderManager): JsonResponse
    {
        $result=$orderManager->updateModel(
            $id,
            $request->validated()
        );

        return ApiResponse::message($result > 0, $result > 0 ? 'ORDER_UPDATED' : 'ORDER_NOT_UPDATED');

    }

    /**
     * Handle the incoming request.
     *
     * @param StoreRequest $request
     * @param OrderManager $orderManager
     * @return JsonResponse
     */
    public function store(StoreRequest $request, OrderManager $orderManager): JsonResponse
    {
        $result = $orderManager->storeModel(
            $request->validated()
        );

        return ApiResponse::message(true, 'ORDER_CREATED', new OrderResource($result));

    }

    /**
     * Handle the incoming request.
     *
     * @param ShowRequest $request
     * @param int $id
     * @param OrderManager $orderManager
     * @return JsonResponse
     * @throws CustomException
     */
    public function show(ShowRequest $request, int $id, OrderManager $orderManager): JsonResponse
    {
        $order = $orderManager->getModel(
            $id
        );

        return ApiResponse::data(new OrderResource($order));

    }

    /**
     * Handle the incoming request.
     *
     * @param DeleteRequest $request
     * @param int $id
     * @param OrderManager $orderManager
     * @return JsonResponse
     */
    public function destroy(DeleteRequest $request, int $id, OrderManager $orderManager): JsonResponse
    {
        $result = $orderManager->deleteModelById(
            $id
        );

        return ApiResponse::message($result > 0, $result > 0 ? 'ORDER_DELETED' : 'ORDER_NOT_DELETED');

    }

    /**
     * Handle the incoming request.
     *
     * @param DiscountRequest $request
     * @param int $id
     * @param OrderManager $orderManager
     * @return JsonResponse
     * @throws CustomException
     */
    public function discounts(DiscountRequest $request, int $id, OrderManager $orderManager): JsonResponse
    {
        $result = $orderManager->calculateDiscounts(
            $id
        );

        return ApiResponse::data($result);

    }
}
