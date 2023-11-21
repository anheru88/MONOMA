<?php

namespace Tests\Feature\Controllers\Api;

use App\Actions\Contracts\AuthUserActionInterface;
use App\Exceptions\LoginException;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @var \Mockery\MockInterface|AuthUserActionInterface */
    private $authUserActionMock;

    public function setUp(): void
    {
        parent::setUp();

        // Create a mock for AuthUserActionInterface
        $this->authUserActionMock = \Mockery::mock(AuthUserActionInterface::class);

        $this->artisan('passport:install')
            ->assertExitCode(0);
    }

    /** @test */
    public function it_returns_token_on_successful_authentication()
    {

        // Arrange
        $requestData = [
            'username' => 'testuser',
            'password' => 'testpassword',
        ];

        User::factory()->create([
            'username' => $requestData['username'],
            'password' => bcrypt($requestData['password']),
            'is_active' => true,
        ]);

        // Act
        $response = $this->postJson(route('api.auth'), $requestData);

        // Assert
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'meta' => [
                    'success',
                    'errors',
                    'data' => [
                        'token',
                        'minutes_to_expire',
                    ],
                ],
            ]);
    }

    /** @test */
    public function it_handles_login_exception_and_returns_error_response()
    {
        // Arrange
        $requestData = [
            'username' => 'invaliduser',
            'password' => 'invalidpassword',
        ];

        User::factory()->create([
            'username' => $requestData['username'],
            'password' => bcrypt($requestData['username']),
            'is_active' => true,
        ]);

        // Expect AuthUserActionInterface to throw a LoginException
        $this->authUserActionMock
            ->shouldReceive('handler')
            ->with($requestData)
            ->andThrow(new LoginException('Invalid credentials', Response::HTTP_UNAUTHORIZED));

        // Act
        $response = $this->postJson(route('api.auth'), $requestData);

        // Assert
        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson([
                'meta' => [
                    'success' => false,
                    'errors' => [
                        'Password incorrect for: invaliduser',
                    ],
                ],
            ]);
    }

    /** @test */
    public function it_handles_login_exception_and_returns_error_response_when_user_is_inactive()
    {
        // Arrange
        $requestData = [
            'username' => 'testuser',
            'password' => 'testpassword',
        ];

        User::factory()->create([
            'username' => $requestData['username'],
            'password' => bcrypt($requestData['password']),
            'is_active' => false,
        ]);

        // Expect AuthUserActionInterface to throw a LoginException
        $this->authUserActionMock
            ->shouldReceive('handler')
            ->with($requestData)
            ->andThrow(new LoginException('Invalid credentials', Response::HTTP_UNAUTHORIZED));

        // Act
        $response = $this->postJson(route('api.auth'), $requestData);

        // Assert
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson([
                'meta' => [
                    'success' => false,
                    'errors' => [
                        'User is inactive',
                    ],
                ],
            ]);
    }
}
