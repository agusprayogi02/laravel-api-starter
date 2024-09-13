<?php

namespace App\Services\Auth;

use App\Contracts\Abstracts\BaseService;
use App\Exceptions\RestfulApiException;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterService extends BaseService
{
    /**
     * @throws RestfulApiException
     */
    public function registration(array $requestedData): User
    {
        $validatedData = $this->validated($requestedData, new RegistrationRequest());

        DB::beginTransaction();

        // Create User
        /* @var User $user */
        $user = User::query()
            ->create([
                'name' => $validatedData['name'],
                'username' => $validatedData['username'],
                'phone' => $validatedData['phone'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password']
            ]);

        // Assign Role
        $role = Role::query()
            ->where('name', 'guru')
            ->first();

        $user->assignRole($role);

        DB::commit();

        return $user;
    }
}
