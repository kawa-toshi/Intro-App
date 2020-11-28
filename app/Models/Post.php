<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'image_path'
    ];

    public function postStore(Int $user_id, Array $data)
    {
        $this->user_id = $user_id;
        $this->title = $data['title'];
        $this->content = $data['content'];
        $this->save();

        return;
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function introduction()
    {
        return $this->belongsTo(Introduction::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'post_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
