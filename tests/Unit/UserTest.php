<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function it_can_create_a_user()
    {
        $data = [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
      
        $userRepo = new UserRepository(new User);
        $user = $userRepo->createUser($data);
      
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($data['title'], $user->title);
        $this->assertEquals($data['link'], $user->link);
        $this->assertEquals($data['image_src'], $user->src);
    }

    public function it_can_update_the_user()
    {
        $user = factory(User::class)->create();
        
        $data = [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
        
        $userRepo = new UserRepository($user);
        $update = $userRepo->updateUser($data);
        
        $this->assertTrue($update);
        $this->assertEquals($data['name'], $user->name);
        $this->assertEquals($data['email'], $user->email);
        $this->assertEquals($data['password'], $user->password);
    }

    public function it_can_show_user()
    {
        $user = factory(User::class)->create();
        $userRepo = new UserRepository(new User);
        $found = $userRepo->findUser($user->id);
        
        $this->assertInstanceOf(User::class, $found);
        $this->assertEquals($found->name, $user->name);
        $this->assertEquals($found->email, $user->email);
        $this->assertEquals($found->password, $user->password);
    }

    public function it_can_delete_the_user()
    {
        $user = factory(User::class)->create();
      
        $userRepo = new UserRepository($user);
        $delete = $userRepo->deleteUser();
        
        $this->assertTrue($delete);
    }
}
