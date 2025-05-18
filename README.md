SD-7 - スーパーマーケット向け品出し支援システム
2024年度 プロジェクト演習C
本システムはスーパーマーケットにおける品出し業務を支援することを目的とした画像認識および情報管理システムです。

📂 システム概要
画像認識による品出し検知（肌色認識を利用）

JANコード読み取りによる商品情報取得

棚配置管理と可視化

在庫通知機能

従業員情報・ログイン管理

PHP & MySQL によるデータベース連携

🛠 導入方法
前提環境
XAMPP（Apache + MySQL）

Python（Flask, OpenCV）

Windows 11推奨（カメラデバイスの設定が確認しやすいため）

モジュールのインストール
以下をコマンドプロンプトで実行してください：

bash
コピーする
編集する
pip install flask
pip install opencv-python
📁 フォルダ構成
cam_k/
品出しを支援する画像認識（肌色検出）機能。

app.py を実行し、Flaskでローカルサーバーを起動。

カメラ画面: http://127.0.0.1:5000/camera_screen/0

📌 アクセス方法:
http://localhost/SD-7/top/TOP.html → 品出し → 棚番号の詳細

cam_t/
JANコードを読み取り、DBに登録された商品情報を取得。

アクセスURL:
http://localhost/SD-7/cam_t/barcode.html

information/
商品情報、従業員情報、基準値などを登録・管理。

従業員ログインフォームあり。

📌 新規ユーザー登録:
http://localhost/SD-7/information/情報登録3.html

📌 ログイン情報例:

種別	ユーザー名	パスワード
一般ログイン	th	a
管理者ログイン	th	a

notice/
品出しが必要な棚に対して通知を行うシステム。

php/
商品やユーザー情報の登録・更新などのPHPスクリプト。

information/ の HTMLと連携。

search/
倉庫の棚情報可視化やJANコードによる商品検索（開発途中）。

tana/
商品棚のレイアウト・位置登録用ツール。

登録画面: http://localhost/SD-7/tana/tana.html

Stocking/
tana/ で登録した棚を品出し時に反映。

表示例:
http://localhost/SD-7/Stocking/品出し2.html

top/
システムのTOP画面など、HTMLとCSSで構成。

sql/
shinadasi.sql または shinadasi(1).sql：本システムで使用するDBファイル

📌 DB接続情報（例）:

データベース名: shinadasi

ユーザー名: sina

パスワード: sina

⚠️ 注意事項
barcode.html で読み取ったJANコードは information/情報登録5.html の内容と連携しています。

barcode.html は TOP.html から直接リンクされていないため、手動でアクセスしてください。

管理者ログインに関しては、phpMyAdminで「ユーザ名」テーブルと「ログイン管理」テーブルの 管理者ID を一致させる必要があります。

🔧 開発状況
一部機能（searchフォルダなど）は開発途中。

不要ファイルが含まれている可能性があります。

👨‍💻 開発メンバー
プロジェクト演習C「SD-7」チーム(6人)（2024年度）

