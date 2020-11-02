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


   // ajaxのいいね機能
    public function ajaxlike(Request $request, Favorite $favorite)
    {
        $user = auth()->user();
        $id = $user->id;  // ログインユーザーのid
        $post_id = $request->post_id;  //記事のid
        $post = Post::find($post_id);  // 対応したポストの全てのデータ
        $is_favorite = $favorite->isFavorite($user->id, $post_id); // ログインユーザーがお気に入りしているか判定


        // いいねしてなかったら
        if (!$is_favorite) {
            //favoritesテーブルのレコードを作成
            $like = new Favorite;
            $like->post_id = $request->post_id;
            $like->user_id = $id;
            $like->save();
        } else {
            //favoritesテーブルのレコードを削除
            $like = Favorite::where('post_id', $post_id)->where('user_id', $id);
            $like->delete();
        }
        // いいねを押した記事のfavoritesのデータを格納
        $post_favorites = $post->favorites;
        // いいねを押した記事のfavoritesテーブルの数を数える
        $postLikesCount = count($post_favorites);

        //一つの変数にajaxに渡す値をまとめる
        //今回ぐらい少ない時は別にまとめなくてもいいけど一応。
        $json = [
            'postLikesCount' => $postLikesCount,
        ];
        //下記の記述でajaxに引数の値を返す
        return response()->json($json);
    }

    // ajax コメント
    public function ajaxComment(Request $request, Comment $comment)
    {
      $post_id = $request->post_id;   // コメントする投稿のID
      $user = auth()->user();
      $user_id = $user->id;  // コメントしたユーザーのID
      $text = $request->text;  // コメントの内容
      $profile_image = $user->profile_photo_path;
      $user_name = $user->name;

      $comment->user_id = $user_id;
      $comment->post_id = $post_id;
      $comment->text = $text;
      $comment->save();
      $created_at = $comment->created_at->format('Y-m-d H:i');
      $comment_id = $comment->id;


      $json = ["user_id" => $user_id, "post_id" => $post_id, "text" => $text, "created_at" => $created_at, "profile_image" => $profile_image, "user_name" => $user_name, "comment_id" => $comment_id];
      return response()->json($json);

    }

    public function ajaxCommentDelete(Request $request)
    {

      $comment_id = $request->comment_id;
      $user = auth()->user();
      $comment = Comment::find($comment_id);

      Comment::destroy($comment_id);




      $json = ["comment_id" => $comment_id];
      return response()->json($json);

    }
}
