<?php

namespace App\Http\Controllers\User;

use App\Exceptions\CustomException;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\DeleteRequest;
use App\Http\Requests\User\IndexRequest;
use App\Http\Requests\User\ShowRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Services\Managers\UserManager;
use App\Traits\HasPagination;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    use HasPagination;
    /**
     * Handle the incoming request.
     *
     * @param IndexRequest $request
     * @param UserManager $userManager
     * @return JsonResponse
     * @throws CustomException
     */
    public function index(IndexRequest $request, UserManager $userManager): JsonResponse
    {
        $result = $userManager->getModels(
            $request->all()
        );

        return ApiResponse::pagination(UserResource::collection($result), $this->paginate($result));
    }

    /**
     * Handle the incoming request.
     *
     * @param ShowRequest $request
     * @param int $id
     * @param UserManager $userManager
     * @return JsonResponse
     * @throws CustomException
     */
    public function show(ShowRequest $request, int $id, UserManager $userManager): JsonResponse
    {
        $user = $userManager->getModel(
            $id
        );

        return ApiResponse::data(new UserResource($user));

    }

    /**
     * Handle the incoming request.
     *
     * @param UpdateRequest $request
     * @param int $id
     * @param UserManager $userManager
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $id, UserManager $userManager): JsonResponse
    {
        $result=$userManager->updateModel(
            $id,
            $request->validated()
        );

        return ApiResponse::message($result > 0, $result > 0 ? 'USER_UPDATED' : 'USER_NOT_UPDATED');

    }

    /**
     * Handle the incoming request.
     *
     * @param StoreRequest $request
     * @param UserManager $userManager
     * @return JsonResponse
     */
    public function store(StoreRequest $request, UserManager $userManager): JsonResponse
    {
        $result = $userManager->storeModel(
            $request->validated()
        );

        return ApiResponse::message(true, 'USER_CREATED', new UserResource($result));

    }

    /**
     * Handle the incoming request.
     *
     * @param DeleteRequest $request
     * @param int $id
     * @param UserManager $userManager
     * @return JsonResponse
     */
    public function destroy(DeleteRequest $request, int $id, UserManager $userManager): JsonResponse
    {
        $result = $userManager->deleteModelById(
            $id
        );

        return ApiResponse::message($result > 0, $result > 0 ? 'USER_DELETED' : 'USER_NOT_DELETED');

    }
}
