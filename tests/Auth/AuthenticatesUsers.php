<?php

namespace Tests\Auth;

use Illuminate\Support\Facades\Http;

trait AuthenticatesUsers
{
    public function authenticate(string $userEmail, string $password): string
    {
        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->postJson('/api/v1/login', [
                'email' => $userEmail,
                'password' => $password,
            ]);

        return $response->json('access_token');
    }

}
