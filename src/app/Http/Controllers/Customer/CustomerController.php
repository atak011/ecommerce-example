<?php

namespace App\Http\Controllers\Customer;

use App\Exceptions\CustomException;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\DeleteRequest;
use App\Http\Requests\Customer\IndexRequest;
use App\Http\Requests\Customer\ShowRequest;
use App\Http\Requests\Customer\StoreRequest;
use App\Http\Requests\Customer\UpdateRequest;
use App\Http\Resources\CustomerResource;
use App\Services\Managers\CustomerManager;
use App\Traits\HasPagination;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{

    use HasPagination;
    /**
     * Handle the incoming request.
     *
     * @param IndexRequest $request
     * @param CustomerManager $customerManager
     * @return JsonResponse
     * @throws CustomException
     */
    public function index(IndexRequest $request, CustomerManager $customerManager): JsonResponse
    {
        $result = $customerManager->getModels($request->all());

        return ApiResponse::pagination(CustomerResource::collection($result), $this->paginate($result));
    }

    /**
     * Handle the incoming request.
     *
     * @param UpdateRequest $request
     * @param int $id
     * @param CustomerManager $customerManager
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $id, CustomerManager $customerManager): JsonResponse
    {
        $result=$customerManager->updateModel($id, $request->validated());

        return ApiResponse::message($result > 0, $result > 0 ? 'CUSTOMER_UPDATED' : 'CUSTOMER_NOT_UPDATED');

    }

    /**
     * Handle the incoming request.
     *
     * @param DeleteRequest $request
     * @param int $id
     * @param CustomerManager $customerManager
     * @return JsonResponse
     */
    public function destroy(DeleteRequest $request, int $id, CustomerManager $customerManager): JsonResponse
    {
        $result = $customerManager->deleteModelById($id);

        return ApiResponse::message($result > 0, $result > 0 ? 'CUSTOMER_DELETED' : 'CUSTOMER_NOT_DELETED');
    }

    /**
     * Handle the incoming request.
     *
     * @param ShowRequest $request
     * @param int $id
     * @param CustomerManager $customerManager
     * @return JsonResponse
     * @throws CustomException
     */
    public function show(int $id, CustomerManager $customerManager): JsonResponse
    {
        $customer = $customerManager->getModel($id);

        return ApiResponse::data(new CustomerResource($customer));
    }

    /**
     * Handle the incoming request.
     *
     * @param StoreRequest $request
     * @param CustomerManager $customerManager
     * @return JsonResponse
     */
    public function store(StoreRequest $request, CustomerManager $customerManager): JsonResponse
    {
        $result = $customerManager->storeModel($request->validated());

        return ApiResponse::message(true, 'CUSTOMER_CREATED', new CustomerResource($result));
    }
}
