<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class DatabaseTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function testDatabase()
    {
        $this->assertTrue(
            Schema::hasColumns('posts', [
                'id','title'
            ]),
            1
        );
    }

    public function testDatabase2()
    {
      $user = new User();
      $user->id = 1;
      $user->name = 'test';
      $user->email = 'test@com';
      $user->password = 'pokemonn';
      $saveUser = $user->save();

      $this->assertTrue($saveUser);
    }
}
