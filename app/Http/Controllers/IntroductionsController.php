<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Introduction;


class IntroductionsController extends Controller
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

      // $idはuser_id
      $user = auth()->user();
      $user_id = $user->id;
      $introduction = new Introduction();

      $my_introduction = $introduction->where('user_id', $user_id)->get()->first();  // プロフィールを取得
      $my_profile_photo_url = $my_introduction->profile_image_path;  // プロフィール登録した画像取得
      $my_profile_cover_photo_url = $my_introduction->profile_cover_image_path;  // カバー画像取得
      $profile_message = $my_introduction->profile_message;



      return view('introduction.create', [
          'user' => $user,
          'profile_photo_url' => $my_profile_photo_url,
          'profile_cover_photo_url' => $my_profile_cover_photo_url,
          'profile_message' => $profile_message
      ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Introduction $introduction)
    {
        $user = auth()->user();
        $user_id = $user->id;
        $profile_image = $request->file('profile_image_path');
        $cover_image = $request->file('profile_cover_image_path');
        $profile_image_path = Storage::disk('s3')->putFile('profile-image', $profile_image, 'public');
        $cover_image_path = Storage::disk('s3')->putFile('cover-image', $cover_image, 'public');
        $data = $request->all();
        


        $introduction->profile_image_path = Storage::disk('s3')->url($profile_image_path);  // urlでs3の保存先urlを取得
        $introduction->profile_cover_image_path = Storage::disk('s3')->url($cover_image_path);
        $introduction->user_id = $user_id;
        $introduction->profile_message = $data['profile_message'];
        
        $introduction->save();
        // $post->postStore($user->id, $data);
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
      // $idはuser_id
      $user = auth()->user();
      // プロフィール情報があれば格納 なければ null
      $introduction_user = $user->introductions->first();

      $post = new Post();
      $introduction = new Introduction();
      $my_introduction = $introduction->where('user_id', $id)->get()->first();  // プロフィールを取得
      // プロフィール情報があるかどうかで場合わけ
      if($introduction_user){
      $my_profile_photo_url = $my_introduction->profile_image_path;  // プロフィール登録した画像取得
      $my_profile_cover_photo_url = $my_introduction->profile_cover_image_path;  // カバー画像取得
      $profile_message = $my_introduction->profile_message;
      $posts = $post->where('user_id', $id)->get();  // ログインユーザーの投稿した記事の取得
      return view('introduction.show', [
          'introduction_user'     => $introduction_user,
          'user'     => $user,
          'posts' => $posts,
          'profile_photo_url' => $my_profile_photo_url,
          'profile_cover_photo_url' => $my_profile_cover_photo_url,
          'profile_message' => $profile_message
      ]);
      }else{
        $posts = $post->where('user_id', $id)->get();  // ログインユーザーの投稿した記事の取得

        return view('introduction.show', [
          'introduction_user'     => $introduction_user,
          'user'     => $user,
          'posts' => $posts
      ]);
      }
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
        //
    }
}
