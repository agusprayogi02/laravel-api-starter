<?php

namespace App\Services\Auth;

use App\Contracts\Abstracts\BaseService;
use App\Enums\ResponseCode;
use App\Exceptions\RestfulApiException;
use App\Http\Requests\Auth\AuthenticateRequest;
use Illuminate\Support\Facades\Auth;

class AuthService extends BaseService
{
    /**
     * @throws RestfulApiException
     */
    public function authenticate(array $requestedData): array
    {
        $this->validated($requestedData, new AuthenticateRequest());

        $data = $this->getValidatedData();
        if (filter_var($data['username'], FILTER_VALIDATE_EMAIL)) {
            $data['email'] = $data['username'];
            unset($data['username']);
        }

        if (!Auth::guard("web")->attempt($data)) {
            throw new RestfulApiException(ResponseCode::ERR_FORBIDDEN_ACCESS, "Invalid credentials");
        }

        $user = auth()->user();
        $user->load('roles');

        return [
            "user" => $user,
            "token" => $user->createToken("personal_access_token", expiresAt: now()->addWeek())
        ];
    }

    public function logout(): void
    {
        auth()->user()->currentAccessToken()->delete();
    }
}
