## セットアップ
- クローン
```
git clone git@github.com:posse-ap/teamdev-2023-posse2-team3A.git
```
- Docker Imageをビルドする
```
docker compose build --no-cache
```

## 起動
- コンテナを立ち上げる
```
docker compose up -d
```
### サービスTOP画面
http://localhost/

### クライアントの管理者画面
http://localhost/client/
- メールアドレス
  - levetech@agent.com
- パスワード
  - password1

その他メールアドレスは http://localhost:8081 のclientsテーブルで確認できます。パスワードはpassword'id'でログインできます。

### サービス(CRAFT)管理者画面
http://localhost/admin/
- メールアドレス
  - admin@example.com
- パスワード
  - password

## 停止
```
docker compose down
```
