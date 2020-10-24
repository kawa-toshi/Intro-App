<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Post;

class FavoritesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Favorite $favorite)
    {
        $user = auth()->user();         // ユーザー情報格納
        $post_id = $request->post_id;   // 送られてきたリクエストの中のpost_idを取得
        $is_favorite = $favorite->isFavorite($user->id, $post_id);  // FavoriteモデルのisFavoriteメソッドの使用

        // もしFavoriteテーブルの中になかったら(falseなら)お気に入りにしたことを保存
        if(!$is_favorite) {
            $favorite->storeFavorite($user->id, $post_id);
            return back();
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();
        $user_id = $user ->id;
        $favorite = Favorite::where('post_id', $id)->where('user_id', $user_id)->first();

        $favorite->delete();

        return back();
    }
}
