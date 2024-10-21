# Atte(勤怠管理システム)

<img src="https://github.com/user-attachments/assets/7d86a5a0-6bcd-46c7-a450-a0fd18887fd0" alt="アプリケーションの画像" width="500"/>


## 作成した目的
人事評価のため

## URL
デプロイのURLを貼り付けるログインなどがあれば注意事項など<br>
- 開発環境 : http://localhost<br>
- phpmyadmin : http://localhost:8080/

## 機能一覧
- ログイン機能
- 勤怠打刻機能
- ユーザー情報の編集機能
- 勤怠記録の編集機能

## 使用技術(実行環境)
- PHP8.3.12
- mysql8.0.26
- laravel8.83.8

## テーブル設計
<img src="https://github.com/user-attachments/assets/e0e789c9-e063-4d7b-a072-4762485ba540" width="500"/>

## ER図
<img src="https://github.com/user-attachments/assets/ad8d0831-6626-4a9e-bd48-41c280275c32" width="500"/>


## 環境構築
### Dockerビルド

- 1.git clone git@github.com:Ikedarion/Attendance.git
- 2.DockerDesktopアプリを立ち上げる
- 3.docker-compose up -d --build

### laravelの環境構築
- 1.docker-compose exec php bash
- 2.composer install
- 3.「.env.example」ファイルを 「.env」ファイルに命名を変更。<br>
    または、新しく.envファイルを作成
- 4..envに以下の環境変数を追加
  ```
  DB_CONNECTION=mysql
  DB_HOST=mysql
  DB_PORT=3306
  DB_DATABASE=laravel_db
  DB_USERNAME=laravel_user
  DB_PASSWORD=laravel_pass
- 5.アプリケーションキーの作成<br>
```php artisan migrate```
- 6.マイグレーションの実行<br>
```php artisan serve```
- 7.シーディングの実行<br>
```php artisan db:seed```


## その他
例) アカウントの種類(テストユーザー)<br>
- メールアドレス : test1@example.com
- パスワード : password1
- 役割 : 管理者
