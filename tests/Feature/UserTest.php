<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function userLogin()
    {
      // use DatabaseTransactions;
      // テスト後に自動的にダミーデータを削除してくれる

      // ログイン後に投稿一覧ページに遷移するか
      $response = $this
      ->actingAs(User::find(1))
      ->get('/posts');

      $response->assertStatus(200)
      ->assertViewIs('posts.index')
      ->assertSee('投稿一覧');
    }

    public function noUserLogin()
    {
        $response = $this
        ->get('posts');

        // リダイレクトを示すのは302 302だとテスト成功
        $response->assertStatus(302)
        ->assertViewIs('toppage')
        ->assertSee('ログイン');
    }
}
