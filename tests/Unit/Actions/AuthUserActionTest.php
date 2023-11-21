<?php

namespace Tests\Unit\Actions;

use App\Actions\AuthUserAction;
use App\Exceptions\LoginException;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\PersonalAccessTokenResult;
use Laravel\Passport\Token;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthUserActionTest extends TestCase
{
    use RefreshDatabase;

    private AuthUserAction $authUserAction;

    /** @var \Mockery\MockInterface|UserRepositoryInterface */
    private $userRepositoryMock;

    public function setUp(): void
    {
        parent::setUp();

        // Create a mock for UserRepositoryInterface
        $this->userRepositoryMock = \Mockery::mock(UserRepositoryInterface::class);

        // Instantiate AuthUserAction with the mock UserRepository
        $this->authUserAction = new AuthUserAction($this->userRepositoryMock);
    }

    /** @test */
    public function it_can_authenticate_user_and_return_token()
    {
        // Arrange
        $userData = [
            'username' => 'testuser',
            'password' => 'testpassword',
        ];

        // Create a user in the database
        $user = User::factory()->create([
            'username' => $userData['username'],
            'password' => bcrypt($userData['password']),
            'is_active' => true,
        ]);

        // Expect UserRepository to be called with the provided username
        $this->userRepositoryMock
            ->shouldReceive('findByUsername')
            ->with($userData['username'])
            ->andReturn($user);

        // Expect UserRepository to be called to create a token for the user
        $this->userRepositoryMock
            ->shouldReceive('createToken')
            ->with($user)
            ->andReturn(new PersonalAccessTokenResult(
                'test_token',
                new Token()
            ));

        // Act
        $tokenResult = $this->authUserAction->handler($userData);

        // Assert
        $this->assertInstanceOf(PersonalAccessTokenResult::class, $tokenResult);
        $this->assertEquals('test_token', $tokenResult->accessToken);
    }

    /** @test */
    public function it_throws_login_exception_for_invalid_password()
    {
        // Arrange
        $userData = [
            'username' => 'testuser',
            'password' => 'invalid_password',
        ];

        // Create a user in the database
        $user = User::factory()->create([
            'username' => $userData['username'],
            'password' => bcrypt('correct_password'),
            'is_active' => true,
        ]);

        // Expect UserRepository to be called with the provided username
        $this->userRepositoryMock
            ->shouldReceive('findByUsername')
            ->with($userData['username'])
            ->andReturn($user);

        // Act
        // Assert
        $this->expectException(LoginException::class);
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);

        $this->authUserAction->handler($userData);
    }

    /** @test */
    public function it_throws_login_exception_for_inactive_user()
    {
        // Arrange
        $userData = [
            'username' => 'testuser',
            'password' => 'testpassword',
        ];

        // Create an inactive user in the database
        $user = User::factory()->create([
            'username' => $userData['username'],
            'password' => bcrypt($userData['password']),
            'is_active' => false,
        ]);

        // Expect UserRepository to be called with the provided username
        $this->userRepositoryMock
            ->shouldReceive('findByUsername')
            ->with($userData['username'])
            ->andReturn($user);

        // Act
        // Assert
        $this->expectException(LoginException::class);
        $this->expectExceptionCode(Response::HTTP_UNAUTHORIZED);

        $this->authUserAction->handler($userData);
    }
}
