<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Favorite;



class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
        $user = auth()->user();
        $posts = Post::all();
        $data = [];
        $favorite_model = new Favorite;
        $data = [
            'posts' => $posts,
            'like_model'=>$favorite_model,
        ];
        
        return view('posts.index', [
            'user'      => $user,
            'posts'     => $posts
        ], $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        return view('posts.create', [
            'user' => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post)
    {
        $user = auth()->user();
        $data = $request->all();
        $rules =  [
            'title' => ['required'],
            'content' => ['required']
        ];
        $this->validate($request, $rules);

        $post->postStore($user->id, $data);
        return redirect('/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = auth()->user();
        $post = Post::find($id);
        // $comments = $comment->getComments($post->id);

        return view('posts.show', [
            'user'     => $user,
            'post' => $post,
            // 'comments' => $comments
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Post $post)
    {
        $user = auth()->user();
        $post = Post::find($id);

        return view('posts.edit', ['post' => $post,'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $user = auth()->user();
        $data = $request->all();
        $post = Post::find($data['id']);
        $rules =  [
            'title' => ['required'],
            'content' => ['required']
        ];
        $this->validate($request, $rules);
        $post->fill([
        'title' => $data['title'],
        'content' => $data['content']
        ]);
        $post->save();

        return redirect(route('post'));
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


        try{
            // ブログを削除
            Post::destroy($id);
        } catch(\Throwable $e){
            abort(500);
        }

        return redirect('/posts');
    }


   // ajaxのやつ
    public function ajaxlike(Request $request, Favorite $favorite)
    {
        
        $user = auth()->user();
        $id = $user->id;  // ユーザーのid
        $post_id = $request->post_id;  //記事のid
        $post = Post::find($post_id);  // 対応したポストの全てのデータ
        $like = new Favorite;
        $is_favorite = $favorite->isFavorite($user->id, $post_id);
        //loadCountとすればリレーションの数を○○_countという形で取得できる（今回の場合はいいねの総数）
        //  $kikiki = $post->favorites;
        //  $postLikesCount = count($kikiki);

        // 空でないなら
        if (!$is_favorite) {
            //likesテーブルのレコードを削除
            
            $like = new Favorite;
            $like->post_id = $request->post_id;
            $like->user_id = $id;
            $like->save();

        } else {
            //likesテーブルに新しいレコードを作成する
            $like = Favorite::where('post_id', $post_id)->where('user_id', $id);
            $like->delete();
        }
        $kikiki = $post->favorites;
        $postLikesCount = count($kikiki);

        //一つの変数にajaxに渡す値をまとめる
        //今回ぐらい少ない時は別にまとめなくてもいいけど一応。笑
        $json = [
            'postLikesCount' => $postLikesCount,
        ];
        //下記の記述でajaxに引数の値を返す
        return response()->json($json);
    }
}
