<?php

namespace App\Services\Managers;

use App\Exceptions\CustomException;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class AuthManager
{

    private $user;
    private $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->user = FacadesAuth::user();
        $this->userRepo = $userRepo;
    }

    public function login(array $credentials)
    {
        try {
            $credentials['status'] = 'a';

            if (!FacadesAuth::attempt($credentials)) {
                throw new CustomException(__('Giriş bilgileri hatalı.'));
            }

            $this->user = FacadesAuth::user();
            $tokenResult = $this->user->createToken('Personal Access Token');

            $this->userRepo->update(['id' => $this->user->id], [
                'last_login_at' => Carbon::now('Europe/Istanbul')->toDateTimeString()
            ]);
        } catch (Exception $e) {

            $errorLogManager = new ErrorLogManager();
            $errorLogManager->storeLog('USER', 'CREDENTIALS_INVALID', $credentials, $e);
            throw new CustomException('CREDENTIALS_INVALID');
        }

        return $tokenResult->plainTextToken;
    }

    public function getAuthUser(){
        return $this->user;
    }

    public function logout()
    {
        $this->getAuthUser()->tokens()->delete();
    }
}
