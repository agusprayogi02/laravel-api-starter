<?php

namespace App\Vendors\Sanctum;

use DateTimeInterface;
use Illuminate\Support\Str;
use Laravel\Sanctum\NewAccessToken;

trait HasApiTokens
{
    use \Laravel\Sanctum\HasApiTokens;

    /**
     * Create a new personal access token for the user.
     *
     * @param string $name
     * @param array $abilities
     * @param DateTimeInterface|null $expiresAt
     * @return NewAccessToken
     */
    public function createToken(string $name, array $abilities = ['*'], DateTimeInterface $expiresAt = null): NewAccessToken
    {
        $token = $this->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
            'abilities' => $abilities,
            'expires_at' => $expiresAt,
        ]);
        $point = rand(5, 10);
        $key = preg_replace("/^(.{$point})(.*)$/", '$1.$2', md5($token->getKey()));

        return new NewAccessToken($token, "$key|$plainTextToken");
    }
}
