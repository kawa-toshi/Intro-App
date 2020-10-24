<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    public $timestamps = false;


    // いいねしているかどうかの判定処理
    public function isFavorite(Int $user_id, Int $post_id)
    {
        // True or Falseで、FavoritesテーブルからユーザーIDとポストIDの両方を持った物を探し出し有無を判定
        return (boolean) $this->where('user_id', $user_id)->where('post_id', $post_id)->first();
    }

    public function storeFavorite(Int $user_id, Int $post_id)
    {
        $this->user_id = $user_id;
        $this->post_id = $post_id;
        $this->save();

        return;
    }

    public function destroyFavorite(Int $favorite_id)
    {
        return $this->where('id', $favorite_id)->delete();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->belongsTo(Comment::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
