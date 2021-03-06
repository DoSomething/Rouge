<?php

namespace Tests;

use DoSomething\Gateway\Testing\WithOAuthTokens;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Arr;
use PHPUnit\Framework\Assert;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication,
        RefreshDatabase,
        WithMocks,
        WithAuthentication,
        WithOAuthTokens;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->configureMocks();
    }

    /**
     * Assert that the JSON response has the given field.
     *
     * @param  Response  $response
     * @param  string|array  $key - The JSON path, in "dot notation".
     * @param  mixed $expected - Optionally, the expected value to assert.
     * @return $this
     */
    public function seeJsonField($response, $key, $expected = null)
    {
        $data = $response->decodeResponseJson();

        if (!Arr::has($data, $key)) {
            Assert::fail('Expected to find JSON response at ' . $key);
        }

        $actual = Arr::get($data, $key);

        if ($expected !== null && $actual !== $expected) {
            Assert::fail(
                'Expected to find "' .
                    $expected .
                    '" in response at ' .
                    $key .
                    ', found: ' .
                    $actual,
            );
        }

        return $this;
    }
}
