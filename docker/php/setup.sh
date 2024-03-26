#!/bin/bash

# Laravelのプロジェクトディレクトリに移動
cd /work/backend

# .envファイルが存在するかチェック
if [ ! -f .env ]; then
    # .envファイルが存在しない場合は例をコピーして作成
    cp .env.example .env

    # sqliteファイルを作成
    touch ./database/database.sqlite 

    # Composerのインストール
    composer install

    # Laravelのキーを生成
    php artisan key:generate

    # マイグレーション実行
    php artisan migrate
fi
