<?php

namespace App\Services\Management;

use App\Contracts\Abstracts\BaseService;
use App\Exceptions\RestfulApiException;
use App\Http\Requests\Management\Users\SyncUserRoleRequest;
use App\Models\User;

class UserService extends BaseService
{
    /**
     * @throws RestfulApiException
     */
    public function syncUserRole(User $user, array $requestedData): User
    {
        $this->validated($requestedData, new SyncUserRoleRequest());

        $user->syncRoles($this->getValidatedData()["role_ids"]);

        return $user;
    }
}
