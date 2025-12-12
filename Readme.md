# このレポジトリについて

このレポジトリは、Laravel のテンプレートプロジェクトです。
主に以下の機能が含まれています：

- ユーザー認証（Laravel Fortify を使用）
- 基本的なルーティング設定
- カスタムタイムゾーンとロケール設定
- その他、一般的な Laravel アプリケーションに必要な設定

これらの設定は、Laravel アプリケーションの開発を迅速に開始するための基盤として利用できます。

# 使用技術(実行環境)

php php:8.3-fpm  
Laravel 10.x  
MySQL 8.0  
nginx:1.21.1

# 環境構築

## Docker ビルド

1. git clone git@github.com:teruma-nanami/laravel-template.git
1. cd laravel-template
1. docker compose up -d --build

## Laravel 環境構築

1. docker composer exec php bash
1. composer install
1. .env.example ファイルから.env を作成し、環境変数を変更
1. php artisan key:generate
1. php artisan migrate
1. php artisan db:seed
1. php artisan storage:link

## mailhog の環境構築

.env ファイルを以下のように変更してください。

```
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

mailhog の起動確認についてはブラウザで http://localhost:8025 にアクセスし、MailHog の Web インターフェースが表示されることを確認します。
