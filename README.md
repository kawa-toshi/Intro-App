# README

## アプリ名

Intro-App

## 本番環境

https://intro-app1.herokuapp.com/

テストアカウント<br>
メールアドレス testsample@com<br>
パスワード testsample

## 概要

おすすめのアプリを紹介するアプリです。<br>
アカウント登録をした後に、プロフィール登録をすることでおすすめのアプリについての投稿ができます。

## USAGE

瞑想のアプリを発見してこのアプリをたくさんの人に知って欲しいと思ったことから開発をしました。<br>
おすすめのアプリを紹介できますし、他の人々の紹介するアプリを知ることで自分の生活もより便利になる可能性が高まります。<br>

## 実装した機能

1.ユーザー登録機能(ログインなど)<br> 2.記事登録機能<br> 3.いいね機能(非同期)<br> 4.フォロー機能<br> 5.プロフィール登録機能(カバー画像、プロフィール画像など)<br>6.コメント機能(非同期)

## 今後の実装予定の内容

カテゴリー機能
タグ機能

### DB 設計(使用しないデータベースのカラムは省略)

## comments テーブル

| Column          | Type    | Options                        |
| --------------- | ------- | ------------------------------ |
| user_id         | integer | null: false, foreign_key: true |
| post_id         | integer | null: false, foreign_key: true |
| introduction_id | integer | null: false, foreign_key: true |
| text            | text    | null: false                    |

### Association

-   belongs_to :post
-   belongs_to :user
-   belongs_to :introduction

## favorites テーブル

| Column  | Type    | Options                        |
| ------- | ------- | ------------------------------ |
| post_id | integer | null: false, foreign_key: true |
| user_id | integer | null: false, foreign_key: true |

### Association

-   belongs_to :user
-   belongs_to :post

## followers テーブル

| Column       | Type    | Options                        |
| ------------ | ------- | ------------------------------ |
| following_id | integer | null: false, foreign_key: true |
| followed_id  | integer | null: false, foreign_key: true |

## introductions テーブル

| Column                   | Type    | Options                        |
| ------------------------ | ------- | ------------------------------ |
| user_id                  | integer | null: false, foreign_key: true |
| profile_cover_image_path | text    |                                |
| profile_image_path       | text    |                                |
| profile_message          | text    | null: false                    |

### Association

-   belongs_to :user
-   has_many :posts
-   has_many :comments

## posts テーブル

| Column          | Type    | Options                        |
| --------------- | ------- | ------------------------------ |
| user_id         | integer | null: false, foreign_key: true |
| introduction_id | integer | null: false, foreign_key: true |
| title           | text    | null: false                    |
| content         | text    | null: false                    |
| image_path      | text    |                                |

### Association

-   belongs_to :user
-   belongs_to :introduction
-   has_many :favorites
-   has_many :comments

## users テーブル

| Column   | Type   | Options     |
| -------- | ------ | ----------- |
| name     | string | null: false |
| email    | string | null: false |
| password | string | null: false |

### Association

-   has_many :posts
-   has_many :favorites
-   has_many :comments
