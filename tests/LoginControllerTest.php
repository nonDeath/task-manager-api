<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class LoginControllerTest extends TestCase
{
    /**
     * @test
     */
    public function can_get_a_json_token()
    {
        $this->json(
            'POST',
            '/auth/login',
            [
                'email' => 'test@test.com',
                'password' => 'secret'
            ]
        )->assertJson('{"token": "*"}');
    }
}
