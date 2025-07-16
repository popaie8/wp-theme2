# リースバック住み続け隊 - WordPress テーマ

不動産リースバック査定サービス専用のWordPressランディングページテーマです。

## 🏠 プロジェクト概要

- **サイト名**: リースバック住み続け隊
- **目的**: リースバックサービスの査定・相談獲得
- **代表者**: 代表取締役 黒江 貴裕
- **連絡先**: 
  - 📞 050-5810-5875
  - 💬 LINE: @377sitjf

## ✨ 主な機能

### 🤖 AI即時査定システム
- **メール収集**: 簡単な質問でメールアドレスを収集
- **AI査定**: 物件情報から即座に査定額を算出
- **無料特典**: 「リースバック活用ガイド」PDF自動生成
- **自動返信**: 査定結果とガイドを自動メール送信

### 📊 データ管理
- **Google Sheets連携**: 査定データを自動記録
- **データベース**: WordPress内にAI査定データを保存
- **PDF生成**: プロフェッショナルなデザインのガイドPDF

### 🎨 デザイン
- **レスポンシブ**: 全デバイス対応
- **動画対応**: ヒーロー動画・説明動画
- **フローティングCTA**: 常時表示のLINE・電話CTA
- **信頼性重視**: 実績・証言を効果的に配置

## 🚀 セットアップ

### 必要な環境
- WordPress 5.0以上
- PHP 7.4以上
- MySQL 5.6以上

### インストール手順

1. **テーマのアップロード**
   ```bash
   # テーマフォルダをWordPressにアップロード
   wp-content/themes/wp-theme2/
   ```

2. **テーマの有効化**
   - WordPress管理画面で「外観」→「テーマ」
   - 「wp-theme2」を有効化

3. **必要なページ作成**
   - トップページ: `index.php`を使用
   - 詳細査定: `page-lead-step2.php`
   - 会社概要: `page-company.php`

## 📁 ファイル構成

```
wp-theme2/
├── index.php                    # メインランディングページ
├── functions.php                # 機能・AJAX処理
├── style.css                    # テーマ基本スタイル
├── header.php                   # 共通ヘッダー
├── footer.php                   # 共通フッター
├── page-lead-step2.php         # 詳細査定フォーム
├── page-company.php            # 会社概要
├── includes/
│   ├── class-cta-manager.php   # CTA管理
│   └── class-pdf-generator.php # PDF生成
├── templates/partials/
│   └── super-simple-form.php   # AI査定フォーム
├── images/                     # 画像ファイル
├── videos/                     # 動画ファイル
├── pdfs/                       # PDF生成・保存
└── CLAUDE.md                   # プロジェクト情報
```

## 🔧 主要機能の設定

### AI査定システム
```php
// functions.php で設定済み
- データベーステーブル: wp_ai_assessments
- PDF生成: includes/class-pdf-generator.php
- メール送信: 自動返信機能
```

### Google Sheets連携
```php
// Webhook URL設定済み
$webhook_url = 'https://script.google.com/macros/s/...';
$secret_key = 'sumitsu2025';
```

### CTA設定
```php
// LINE・電話番号
LINE_ID: @377sitjf
PHONE: 050-5810-5875
```

## 🎯 コンバージョン最適化

### 実装済み改善
- ✅ **無駄なセクション削除**: ストーリー → 顧客証言
- ✅ **会社名統一**: 「一括査定」文言削除
- ✅ **LINE CTA統合**: フローティングCTA
- ✅ **AI査定独立**: メール収集 → ガイド配布の流れ
- ✅ **動画最適化**: 配置とオーバーレイ修正

### 成果指標
- フォーム完了率向上
- メール収集率向上
- PDF資料ダウンロード数

## 🔒 セキュリティ

- **nonce検証**: 全フォーム処理
- **データサニタイズ**: 入力値検証
- **PDF認証**: 一時URL・有効期限
- **SQL対策**: prepared statements使用

## 📈 データフロー

1. **AI査定フォーム** → WordPress DB保存
2. **Google Sheets** → 既存シートの「AI査定」タブ
3. **メール送信** → 顧客・管理者双方
4. **PDF生成** → 一時URL生成・24時間有効

## 🛠️ 開発情報

### 最新の改善 (2025年7月)
- **Google Sheets統合**: 既存シートの別タブに統一
- **PDFデザイン**: プロフェッショナルなスタイル
- **認証システム**: セキュアなアクセス制御
- **コード最適化**: 不要ファイル削除

### 技術スタック
- **WordPress**: カスタムテーマ
- **PHP**: サーバーサイド処理
- **JavaScript**: フロントエンド機能
- **CSS**: レスポンシブデザイン
- **Google Apps Script**: Sheets連携

## 📞 サポート

### 連絡先
- **代表**: 黒江 貴裕
- **電話**: 050-5810-5875
- **LINE**: @377sitjf

### 開発者向け
- **Git**: https://github.com/popaie8/wp-theme2
- **Issue**: GitHub Issues
- **Documentation**: `/CLAUDE.md`

## 📄 ライセンス

GPL v2 or later

---

*あなたの家の物語を、未来へ。愛着ある、この家と、これからも。*

**リースバック住み続け隊**