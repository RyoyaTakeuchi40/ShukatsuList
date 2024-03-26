#!/bin/sh

# Nuxtのプロジェクトディレクトリに移動
cd /var/www/nuxt

# .envファイルが存在するかチェック
if [ ! -f .env ]; then
    # .envファイルが存在しない場合は例をコピーして作成
    cp .env.example .env

    # npmのインストール
    npm install
fi

# npm起動
npm run dev