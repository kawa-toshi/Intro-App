<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Introduction;
use App\Models\User;
use App\Models\Follower;


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

      // null プロフィール登録してない場合
      $my_introduction = $introduction->where('user_id', $user_id)->get()->first();  // プロフィールを取得
      
      
      if($my_introduction){
      $my_profile_photo_url = $my_introduction->profile_image_path;  // プロフィール登録した画像取得
      $my_profile_cover_photo_url = $my_introduction->profile_cover_image_path;  // カバー画像取得
      $profile_message = $my_introduction->profile_message;

      return view('introduction.create', [
          'user' => $user,
          'profile_photo_url' => $my_profile_photo_url,
          'profile_cover_photo_url' => $my_profile_cover_photo_url,
          'profile_message' => $profile_message,
          'my_introduction' => $my_introduction  // プロフィール有無の判定用
      ]);
      } else {
        return view('introduction.create', [
          'user' => $user,
          'my_introduction' => $my_introduction
        ]);
      }
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
        $data = $request->all();
        if($profile_image && $cover_image){
          $profile_image_path = Storage::disk('s3')->putFile('profile-image', $profile_image, 'public');
          $cover_image_path = Storage::disk('s3')->putFile('cover-image', $cover_image, 'public');
          $introduction->profile_image_path = Storage::disk('s3')->url($profile_image_path);  // urlでs3の保存先urlを取得
          $introduction->profile_cover_image_path = Storage::disk('s3')->url($cover_image_path);
          $introduction->user_id = $user_id;
          $introduction->profile_message = $data['profile_message'];

          $introduction->save();
        // $post->postStore($user->id, $data);
          return redirect('/posts');
        }elseif($cover_image){
          $cover_image_path = Storage::disk('s3')->putFile('cover-image', $cover_image, 'public');
          $introduction->profile_cover_image_path = Storage::disk('s3')->url($cover_image_path);
          $introduction->user_id = $user_id;
          $introduction->profile_message = $data['profile_message'];

          $introduction->save();
          // $post->postStore($user->id, $data);
          return redirect('/posts');
        }elseif($profile_image){
          $profile_image_path = Storage::disk('s3')->putFile('profile-image', $profile_image, 'public');
          $introduction->profile_image_path = Storage::disk('s3')->url($profile_image_path);  // urlでs3の保存先urlを取得
          $introduction->user_id = $user_id;
          $introduction->profile_message = $data['profile_message'];
          $introduction->save();
        // $post->postStore($user->id, $data);
          return redirect('/posts');

        }else{
          $introduction->user_id = $user_id;
          $introduction->profile_message = $data['profile_message'];
          $introduction->save();
          // $post->postStore($user->id, $data);
          return redirect('/posts');
        }
        


        
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
      $user_id = $user->id;
      // プロフィール情報があれば格納 なければ null
      $introduction_user = $user->introductions->first();  // プロフィールが登録されているか

      $post = new Post();
      $introduction = new Introduction();
      $my_introduction = $introduction->where('user_id', $id)->get()->first();  // プロフィールを取得 現在ログイン中のユーザーのプロフィール
      // 投稿ユーザーから飛ぶとそのプロフィールになる


      // $idがログイン中のユーザーのidと等しいかどうかで、ユーザー自身のマイページか否か$follow_showで判定
      $follow_show = $id == $user_id;
      // following_idが記事のidと一致し、followed_idがログイン中のユーザーと一致するかどうかでそのページのユーザーにフォローされているか否か判定
      $follows = new Follower();
      $is_followed = $follows->where('followed_id', $user_id)->where('following_id', $id)->first();
      $is_following = $follows->where('following_id', $user_id)->where('followed_id', $id)->first(); // following_idがログイン中のユーザー
      
      // 自分自身のフォロー数
      $following =  $follows->where('following_id', $user_id)->get();
      $my_following_count = $following -> count();

      // 自分自身のフォロワー数
      $followed = $follows->where('followed_id', $user_id)->get();
      $my_followed_count = $followed -> count();
      
      // 自分以外のフォロー数
      $your_following =  $follows->where('following_id', $id)->get();
      $your_following_count = $your_following -> count();
      
      // 自分以外のフォロワー数
      $your_followed = $follows->where('followed_id', $id)->get();
      $your_followed_count = $your_followed -> count();
      
      
      // ログイン中のユーザーのプロフィールがあるかどうかで場合わけ 全部上の場合になっている 修正か削除必要か？
      if($my_introduction){
      $my_profile_photo_url = $my_introduction->profile_image_path;  // プロフィール登録した画像取得
      $my_profile_cover_photo_url = $my_introduction->profile_cover_image_path;  // カバー画像取得
      $profile_message = $my_introduction->profile_message;
      $your_user = User::find($id); // 自分以外のユーザーの名前取得に利用
      $posts = $post->where('user_id', $id)->get();  // 記事を投稿したユーザーの記事取得 記事のところはポストを投稿したユーザーidが送られる
      return view('introduction.show', [
          'introduction_user'     => $introduction_user,
          'is_following' => $is_following,
          'is_followed' => $is_followed,
          'follower_id' => $id,
          'follow_show' => $follow_show,
          'my_following_count' => $my_following_count,
          'my_followed_count' => $my_followed_count,
          'your_following_count' => $your_following_count,
          'your_followed_count' => $your_followed_count,
          'my_introduction'   => $my_introduction,
          'user'     => $user,
          'your_user' => $your_user,
          'posts' => $posts,
          'profile_photo_url' => $my_profile_photo_url,
          'profile_cover_photo_url' => $my_profile_cover_photo_url,
          'profile_message' => $profile_message
      ]);
      }else{
        $posts = $post->where('user_id', $id)->get();  // ログインユーザーの投稿した記事の取得

        return view('introduction.show', [
          'introduction_user'     => $introduction_user,
          'is_following' => $is_following,
          'follower_id' => $id,
          'follow_show' => $follow_show,
          'my_following_count' => $my_following_count,
          'my_followed_count' => $my_followed_count,
          'my_introduction'   => $my_introduction,
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
    public function edit($id, Introduction $introduction)
    {
      $user = auth()->user();
      // $introduction = Introduction::find($id);
      $user_id = $user->id;
      $introduction = new Introduction();

      $my_introduction = $introduction->where('user_id', $user_id)->get()->first();  // プロフィールを取得
      $my_introduction_id = $my_introduction->id;
      $my_profile_photo_url = $my_introduction->profile_image_path;  // プロフィール登録した画像取得
      $my_profile_cover_photo_url = $my_introduction->profile_cover_image_path;  // カバー画像取得
      $profile_message = $my_introduction->profile_message;

      return view('introduction.edit', [
        'user' => $user,
        'introduction_id' => $my_introduction_id,
        'profile_photo_url' => $my_profile_photo_url,
        'profile_cover_photo_url' => $my_profile_cover_photo_url,
        'profile_message' => $profile_message
    ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Introduction $introduction)
    {
      $user = auth()->user();
      $data = $request->all();

      $introduction = Introduction::find($data['id']);
      $profile_image = $request->file('profile_image_path');
      $cover_image = $request->file('profile_cover_image_path');
      // 問題 プロフィール画像登録のみ プロフィールメッセージ登録のみ カバー画像登録のみ プロフィール画像 メッセージのみ カバー画像 メッセージのみ

      // プロフィール画像あり カバー画像あり
      if($profile_image && $cover_image){

      $profile_image_path = Storage::disk('s3')->putFile('profile-image', $profile_image, 'public');
      $cover_image_path = Storage::disk('s3')->putFile('cover-image', $cover_image, 'public');

      $profile_image_url = Storage::disk('s3')->url($profile_image_path);  // urlでs3の保存先urlを取得
      $profile_cover_image_url = Storage::disk('s3')->url($cover_image_path);
      

      $introduction->fill([
      'profile_cover_image_path' => $profile_cover_image_url,
      'profile_image_path' => $profile_image_url,
      'profile_message' => $data['profile_message']
      ]);
      $introduction->save();

      return redirect(route('post'));
      // プロフィール画像なし カバー画像あり
      }elseif($cover_image){


        $cover_image_path = Storage::disk('s3')->putFile('cover-image', $cover_image, 'public');
        $profile_cover_image_url = Storage::disk('s3')->url($cover_image_path);

        $introduction->fill([
        'profile_cover_image_path' => $profile_cover_image_url,
        'profile_message' => $data['profile_message']
        ]);
        $introduction->save();

        return redirect(route('post'));
      // プロフィール画像あり カバー画像なし
      }elseif($profile_image){
      // 両方なし
      $profile_image_path = Storage::disk('s3')->putFile('profile-image', $profile_image, 'public');

      $profile_image_url = Storage::disk('s3')->url($profile_image_path);  // urlでs3の保存先urlを取得

      $introduction->fill([
      'profile_image_path' => $profile_image_url,
      'profile_message' => $data['profile_message']
      ]);

      $introduction->save();

      return redirect(route('post'));
      }else{
        $introduction->fill([
          'profile_message' => $data['profile_message']
          ]);

          $introduction->save();

          return redirect(route('post'));

      }
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


    // フォロー関連
    public function follow(Request $request)
    {
        $follower = auth()->user();  // 今ログインしているユーザー
        $user_id = $follower->id;
        $follows = new Follower();
        $follower_id = $request->follower_id; // フォローをしたい人のid

        // フォローしているか
        // $is_following = $follows->where('following_id', $user_id)->first();
        $is_following = $follows->where('following_id', $user_id)->where('followed_id', $follower_id)->first();

        if(!$is_following) {
          // フォローしていなければフォローする
          $follows->followed_id =  $follower_id;// urlでs3の保存先urlを取得
          $follows->following_id =  $user_id;
          $follows->save();
          return back();
        }
    }

    // フォロー解除
    public function unfollow(Request $request)
    {
      $follower = auth()->user();  // 今ログインしているユーザー
      $user_id = $follower->id;
      $follows = new Follower();
      $follower_id = $request->follower_id; // フォローをしたい人のid

      // フォローしているか
      $is_following = Follower::where('following_id', $user_id);
      $is_following->delete();


        // try{
          
        //     $is_following->delete();
        // } catch(\Throwable $e){
        //     abort(500);
        // }

        return back();
    }
}
