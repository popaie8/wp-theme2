# CLAUDE.md - プロジェクト情報

## プロジェクト概要
- **サイト名**: リースバック住み続け隊
- **テーマ**: WordPressランディングページ
- **目的**: リースバックサービスの査定・相談獲得

## 現在のブランディング
- **会社名**: リースバック住み続け隊
- **LINE ID**: @377sitjf
- **電話番号**: 050-5810-5875
- **代表者**: 代表取締役 黒江 貴裕

## 完了した主要改善
1. **無駄なストーリーセクション削除** → 価値のある顧客証言セクション
2. **会社名統一** → 「一括査定」文言削除
3. **LINE CTA統合** → フローティングCTA常時表示
4. **レスポンシブ改善** → モバイル対応完了

## 現在の問題
- **動画表示不具合**: ヒーロー動画と最終メッセージ動画が表示されない
- **実装済み**: 動画コード完全実装済み
- **原因**: WordPressまたはサーバー設定の可能性

## 次回対応優先度
1. **HIGH**: 動画表示問題の解決
2. **MEDIUM**: パフォーマンス最適化
3. **LOW**: 細かいデザイン調整

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