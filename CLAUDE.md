# CLAUDE.md - プロジェクト情報

## プロジェクト概要
- **サイト名**: リースバック住み続け隊
- **テーマ**: WordPressランディングページ
- **目的**: リースバックサービスの査定・相談獲得
- **最終更新**: 2025-07-19

## 現在のブランディング
- **会社名**: リースバック住み続け隊
- **LINE ID**: @377sitjf
- **電話番号**: 050-5810-5875
- **管理者メール**: info@sumitsuzuke-tai.jp

## ✅ 完了した主要改善
1. **メール送信機能完全修正** → 古いテーマの動作する設定を移植
2. **デバッグ機能強化** → 詳細なエラーログとテストツール実装
3. **レスポンシブUI最適化** → 改行位置とテキスト配置を調整
4. **CTA文言最適化** → より効果的な行動喚起文言に変更
5. **フローティングCTA改善** → 視認性と操作性を大幅向上
6. **プロジェクト整理** → 不要ファイルをアーカイブ化

## 🔧 技術的な解決事項
- **メール送信問題**: 定数未定義エラーを解決
- **管理者メール**: 固定値 `info@sumitsuzuke-tai.jp` に変更
- **デバッグツール**: `debug-mail.php` 実装（アーカイブ済み）
- **PHPMailerエラー取得**: 詳細なエラー情報を取得可能

## 📁 プロジェクト構成の最適化
- **アーカイブ化**: 不要ファイル8個を `/archive/` に移動
- **整理対象**: 一時ファイル、古いクラス、未使用メディア
- **保持**: 本番使用中のファイルのみ残存

## 重要なファイル
- index.php: メインランディングページ
- functions.php: WordPressカスタマイズ
- includes/class-cta-manager.php: CTA管理システム
- includes/class-pdf-generator.php: PDF生成システム

## 設定情報
- **動画フォルダ**: /videos/
- **画像フォルダ**: /images/
- **CSSフレームワーク**: カスタムCSS（変数使用）
- **JavaScriptライブラリ**: Font Awesome、Google Fonts

## ⚠️ 変更禁止項目（絶対に変更しないでください）

### 1. フォーム実装
- **AI査定フォーム** (#super-simple-form) - templates/partials/super-simple-form.php
- **メインフォーム** (#assessment-form) - index.php内の60秒査定フォーム
- **詳細査定フォーム** (lead-form) - page-lead-step2.php

### 2. Google Tag Manager (GTM)
- **コンテナID**: GTM-T3B4TDCC（変更禁止）
- **実装場所**:
  - header.php: GTMヘッドタグ
  - footer.php: GTMボディタグ
  - 各種イベントトラッキング実装
- **トラッキングイベント**:
  - assessment_click: 査定CTAクリック
  - line_contact: LINE連絡
  - phone_call: 電話連絡
  - ai_assessment_guide_request: AI査定完了

### 3. メール自動返信システム
- **AI査定メール処理**: handle_ai_assessment_submit (functions.php:195行目)
- **詳細査定メール処理**: ultimate_lead_submit (functions.php:644行目)
- **メール送信関数**: 
  - send_ai_assessment_email: AI査定用
  - send_notification_emails: 詳細査定用

### 4. Google Sheets統合
- **Webhook URL**: 設定済み（変更禁止）
- **認証キー**: X-Api-Key設定済み
- **送信関数**:
  - send_ai_assessment_to_sheets: AI査定データ送信
  - send_to_google_sheets: 詳細査定データ送信（37フィールド）

### 5. WordPress AJAXハンドラー
- **AI査定**: wp_ajax_ai_assessment_submit / wp_ajax_nopriv_ai_assessment_submit
- **詳細査定**: admin_post_lead_submit / admin_post_nopriv_lead_submit
- **PDF生成**: wp_ajax_download_assessment_pdf / wp_ajax_nopriv_download_assessment_pdf

### 6. データフロー（変更禁止）
1. **AI査定フロー**:
   - AI査定入力 → メール入力 → PDFガイド生成 → メール送信 → Google Sheets記録
   - 正式査定へ誘導 → メインフォーム（#assessment-form）へ

2. **詳細査定フロー**:
   - メインフォーム入力（郵便番号・物件種別） → /lead-step2/へ遷移
   - 3ステップ入力 → 送信 → メール送信 → Google Sheets記録

## 実装時の注意事項
- 上記の変更禁止項目は絶対に削除・変更しないでください
- 新機能追加時は既存の機能に影響しないよう注意
- GTMタグやイベント名は変更しない
- フォームのIDやクラス名は変更しない
- AJAXアクション名は変更しない