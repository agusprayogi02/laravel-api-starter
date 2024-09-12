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

        if (!Auth::guard("web")->attempt($this->getValidatedData())) {
            throw new RestfulApiException(ResponseCode::ERR_FORBIDDEN_ACCESS, "Invalid credentials");
        }

        return [
            "user" => $user = Auth::user(),
            "token" => $user->createToken("personal_access_token")
        ];
    }
}
