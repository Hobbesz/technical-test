<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate');
        $this->artisan('db:seed');
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown(): void
    {
        $this->artisan('migrate:reset');
    }

    /**
     * Retrieve a user to act as.
     * 
     * @return App\Models\User
     */
    protected function retrieveUser()
    {
        $user = User::first();
        $this->actingAs($user, 'sanctum');
        return $user;
    }

    /**
     * Apply default headers for a GET request.
     *
     * @param  string  $uri
     * @param  array  $headers
     * @return \Illuminate\Testing\TestResponse
     */
    public function get($uri, array $headers = ['Accept' => 'application/json'])
    {
        return parent::get($uri, $headers);
    }

    /**
     * Apply default headers for a POST request.
     *
     * @param  string  $uri
     * @param  array  $data
     * @param  array  $headers
     * @return \Illuminate\Testing\TestResponse
     */
    public function post($uri, array $data = [], array $headers = ['Accept' => 'application/json'])
    {
        return parent::post($uri, $data, $headers);
    }

    /**
     * Apply default headers for a PATCH request.
     *
     * @param  string  $uri
     * @param  array  $data
     * @param  array  $headers
     * @return \Illuminate\Testing\TestResponse
     */
    public function patch($uri, array $data = [], array $headers = ['Accept' => 'application/json'])
    {
        return parent::patch($uri, $data, $headers);
    }

    /**
     * Apply default headers for a DELETE request.
     *
     * @param  string  $uri
     * @param  array  $data
     * @param  array  $headers
     * @return \Illuminate\Testing\TestResponse
     */
    public function delete($uri, array $data = [], array $headers = ['Accept' => 'application/json'])
    {
        return parent::delete($uri, $data, $headers);
    }
}
