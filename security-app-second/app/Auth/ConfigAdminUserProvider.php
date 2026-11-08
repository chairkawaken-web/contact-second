<?php

namespace App\Auth;

use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class ConfigAdminUserProvider implements UserProvider
{
    public function retrieveById($identifier)
    {
        $email = config('admin.email');

        if (! $email || $identifier !== 'admin') {
            return null;
        }

        return new GenericUser([
            'id' => 'admin',
            'name' => 'Administrator',
            'email' => $email,
        ]);
    }

    public function retrieveByToken($identifier, $token)
    {
        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // No remember token for config-based admin users.
    }

    public function retrieveByCredentials(array $credentials)
    {
        $email = $credentials['email'] ?? null;

        if (! $email || ! hash_equals((string) config('admin.email'), (string) $email)) {
            return null;
        }

        return new GenericUser([
            'id' => 'admin',
            'name' => 'Administrator',
            'email' => $email,
        ]);
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        $expectedEmail = config('admin.email');
        $expectedPassword = config('admin.password');

        return hash_equals((string) $expectedEmail, (string) ($credentials['email'] ?? ''))
            && hash_equals((string) $expectedPassword, (string) ($credentials['password'] ?? ''));
    }
}
