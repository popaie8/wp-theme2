# WordPressテーマ セットアップガイド

## 📋 概要

このガイドは、リースバックLPのWordPressテーマを完全にセットアップするための手順書です。

## 🚀 セットアップ手順

### 1. WordPressテーマのインストール

1. **テーマファイルのアップロード**
   ```
   wp-theme/ フォルダ全体をWordPressの wp-content/themes/ にアップロード
   ```

2. **テーマの有効化**
   - WordPress管理画面 → 外観 → テーマ
   - 「リースバック LP」を選択して有効化

### 2. 固定ページの作成

以下の固定ページを作成してください：

#### A. 詳細査定フォーム (/lead-step2/)
- **ページタイトル**: 詳細査定フォーム
- **スラッグ**: `lead-step2`
- **テンプレート**: 「詳細査定フォーム (Step-2)」を選択

#### B. 会社概要 (/company/)
- **ページタイトル**: 会社概要
- **スラッグ**: `company`
- **テンプレート**: 「会社概要」を選択

#### C. プライバシーポリシー (/privacy/)
- **ページタイトル**: プライバシーポリシー
- **スラッグ**: `privacy`
- **テンプレート**: 「プライバシーポリシー」を選択

#### D. 利用規約 (/terms/)
- **ページタイトル**: 利用規約
- **スラッグ**: `terms`
- **テンプレート**: 「利用規約」を選択

### 3. Google Sheets連携設定

#### A. Google Apps Script の設定

1. **新しいGoogleスプレッドシートを作成**
   - Google Driveで新しいスプレッドシートを作成
   - 「査定依頼管理」などの名前を付ける

2. **ヘッダー行の設定**
   ```
   A列: timestamp (送信日時)
   B列: name (お名前)
   C列: tel (電話番号)
   D列: email (メールアドレス)
   E列: zip (郵便番号)
   F列: property_type (物件種別)
   G列: full_address (住所)
   H列: chome (丁目)
   I列: banchi (番地)
   J列: building_name (建物名)
   K列: room_number (部屋番号)
   L列: layout_rooms (間取り部屋数)
   M列: layout_type (間取りタイプ)
   N列: area (面積)
   O列: area_unit (面積単位)
   P列: building_area (建物面積)
   Q列: building_area_unit (建物面積単位)
   R列: land_area (土地面積)
   S列: land_area_unit (土地面積単位)
   T列: age (築年数)
   U列: other_type (その他種類)
   V列: total_units (総戸数)
   W列: remarks (備考)
   X列: land_remarks (土地備考)
   Y列: ip_address (IPアドレス)
   ```

3. **Google Apps Script の作成**
   - スプレッドシート上で「拡張機能」→「Apps Script」
   - 以下のコードを貼り付け：

```javascript
function doPost(e) {
  try {
    // スプレッドシートの取得
    var sheet = SpreadsheetApp.getActiveSheet();
    
    // POSTデータの解析
    var data = JSON.parse(e.postData.contents);
    
    // データの行を作成
    var row = [
      data.timestamp || new Date(),
      data.name || '',
      data.tel || '',
      data.email || '',
      data.zip || '',
      data.property_type || '',
      data.full_address || '',
      data.chome || '',
      data.banchi || '',
      data.building_name || '',
      data.room_number || '',
      data.layout_rooms || '',
      data.layout_type || '',
      data.area || '',
      data.area_unit || '',
      data.building_area || '',
      data.building_area_unit || '',
      data.land_area || '',
      data.land_area_unit || '',
      data.age || '',
      data.other_type || '',
      data.total_units || '',
      data.remarks || '',
      data.land_remarks || '',
      data.ip_address || ''
    ];
    
    // スプレッドシートに追加
    sheet.appendRow(row);
    
    // 成功レスポンス
    return ContentService
      .createTextOutput(JSON.stringify({success: true}))
      .setMimeType(ContentService.MimeType.JSON);
      
  } catch (error) {
    // エラーレスポンス
    return ContentService
      .createTextOutput(JSON.stringify({success: false, error: error.toString()}))
      .setMimeType(ContentService.MimeType.JSON);
  }
}
```

4. **デプロイ設定**
   - 「デプロイ」→「新しいデプロイ」
   - 種類：「ウェブアプリ」
   - 実行者：「自分」
   - アクセスできるユーザー：「全員」
   - 「デプロイ」をクリック
   - **表示されるウェブアプリURLをコピー** (これがWebhook URL)

#### B. functions.php の設定

`wp-theme/functions.php` の119行目付近を編集：

```php
// Google Sheets Webhook URL（要設定）
$webhook_url = 'YOUR_GOOGLE_SHEETS_WEBHOOK_URL_HERE'; // ← ここを実際のURLに変更
```

**実際のWebhook URLに置き換えてください。**

### 4. メール設定

#### A. SMTPの設定（推奨）

WordPress管理画面で以下のプラグインをインストール：
- **WP Mail SMTP** または **Easy WP SMTP**

設定例：
```
SMTP Host: [お使いのSMTPサーバー]
SMTP Port: 587 (または465)
Encryption: TLS (またはSSL)
Username: [SMTPユーザー名]
Password: [SMTPパスワード]
```

#### B. 管理者メールアドレスの設定

WordPress管理画面 → 設定 → 一般：
- **管理者メールアドレス**: 査定依頼を受信したいメールアドレス

### 5. 最終確認

#### A. フォーム動作テスト

1. **メインページ確認**
   - 60秒査定フォームが表示されること
   - フォーム送信で詳細ページに遷移すること

2. **詳細フォーム確認**
   - 3ステップで正しく動作すること
   - 物件種別に応じてフォームが変わること
   - 郵便番号で住所が自動取得されること

3. **送信テスト**
   - フォーム送信が正常に完了すること
   - Google Sheetsにデータが記録されること
   - メールが送信されること

#### B. ページ確認

- **会社概要**: `/company/` でアクセス可能
- **プライバシーポリシー**: `/privacy/` でアクセス可能
- **利用規約**: `/terms/` でアクセス可能

## 🔧 カスタマイズ

### 会社情報の更新

以下のファイルで会社情報を更新してください：

1. **page-company.php**: 会社概要の詳細情報
2. **functions.php**: メール署名の会社情報
3. **index.php**: サイトタイトルとキャッチコピー

### デザインのカスタマイズ

CSS変数で色をカスタマイズ可能：

```css
:root {
    --color-primary: #1A3A4F;    /* メインカラー */
    --color-accent: #B98D4A;     /* アクセントカラー */
    --color-background: #F4F2EF; /* 背景色 */
}
```

## 📞 サポート

設定でご不明な点がございましたら、開発者までお問い合わせください。

## 📝 チェックリスト

セットアップ完了時に以下を確認してください：

- [ ] WordPressテーマが有効化されている
- [ ] 4つの固定ページが作成・公開されている
- [ ] Google Sheetsの連携が動作している
- [ ] メール送信が動作している
- [ ] フォームの送信テストが成功している
- [ ] 会社情報が正しく表示されている
- [ ] レスポンシブデザインが正常に動作している

## ⚠️ 注意事項

1. **セキュリティ**
   - WordPress、テーマ、プラグインは常に最新版に保つ
   - 強力なパスワードを使用する

2. **バックアップ**
   - 定期的にデータベースとファイルのバックアップを取る

3. **パフォーマンス**
   - 画像の最適化を実施する
   - キャッシュプラグインの導入を検討する