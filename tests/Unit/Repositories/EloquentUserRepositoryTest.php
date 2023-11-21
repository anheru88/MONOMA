<?php

namespace Tests\Unit\Repositories;

use App\Models\User;
use App\Repositories\EloquentUserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\PersonalAccessTokenResult;
use Tests\TestCase;

class EloquentUserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private EloquentUserRepository $userRepository;

    public function setUp(): void
    {
        parent::setUp();

        // Use the 'users' table for testing
        $this->userRepository = new EloquentUserRepository(new User());

        $this->artisan('passport:install')
            ->assertExitCode(0);
    }

    /** @test */
    public function it_can_find_user_by_username()
    {
        // Arrange
        $user = User::factory()->create(['username' => 'testuser']);

        // Act
        $foundUser = $this->userRepository->findByUsername('testuser');

        // Assert
        $this->assertEquals($user->id, $foundUser->id);
        $this->assertEquals($user->username, $foundUser->username);
    }

    /** @test */
    public function it_throws_model_not_found_exception_if_username_not_found()
    {
        // Assert
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        // Act
        $this->userRepository->findByUsername('nonexistentuser');
    }

    /** @test */
    public function it_can_create_personal_access_token_for_user()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $tokenResult = $this->userRepository->createToken($user);

        // Assert
        $this->assertInstanceOf(PersonalAccessTokenResult::class, $tokenResult);
        $this->assertNotEmpty($tokenResult->accessToken);
        $this->assertEquals('MY TOKEN', $tokenResult->token->name);
    }
}
