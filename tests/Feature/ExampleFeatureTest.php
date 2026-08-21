<?php

namespace Tests\Feature;

use App\Models\User;
use Lucent\Facades\App;
use Lucent\Http\Message\ServerRequest;
use Lucent\Http\Message\Uri;
use Tests\TestCase;

/**
 * Example feature test.
 *
 * Dispatches real HTTP requests through the application (routes/api.php)
 * against a throwaway sqlite database, exercising the example
 * UserController end-to-end — including route model binding.
 */
class ExampleFeatureTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase([User::class]);
    }

    public function test_create_user(): void
    {
        $request = ServerRequest::create('POST', Uri::fromString('/user/create'), body: [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);

        $response = App::handleHttpRequest($request);

        $this->assertSame(201, $response->getStatusCode());

        $decoded = json_decode((string) $response->getBody(), true);

        $this->assertSame('User created', $decoded['message']);
        $this->assertArrayHasKey('id', $decoded);

        // The record should now exist in the database.
        $this->assertNotNull(User::where('email', 'jane@example.com')->getFirst());
    }

    public function test_show_user_via_route_model_binding(): void
    {
        $user = new User('John Doe', 'john@example.com');
        $this->assertTrue($user->create());

        $request = ServerRequest::create('GET', Uri::fromString('/user/' . $user->getId()));

        $response = App::handleHttpRequest($request);

        $this->assertSame(200, $response->getStatusCode());

        $decoded = json_decode((string) $response->getBody(), true);

        $this->assertSame('John Doe', $decoded['user']['name']);
        $this->assertSame('john@example.com', $decoded['user']['email']);

        // The RequestLogger middleware should have added this header.
        $this->assertSame('RequestLogger', $response->getHeaderLine('X-Lucent-Middleware'));
    }

    public function test_show_user_returns_404_when_not_found(): void
    {
        $request = ServerRequest::create('GET', Uri::fromString('/user/99999'));

        $response = App::handleHttpRequest($request);

        $this->assertSame(404, $response->getStatusCode());
    }
}
