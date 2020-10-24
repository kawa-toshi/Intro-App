<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;



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
        return view('posts.index', [
            'user'      => $user,
            'posts'     => $posts
            ]);
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
}
