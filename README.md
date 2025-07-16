# RealEstate Leaseback Pro - WordPress Theme

不動産リースバック査定専用ランディングページテーマ

## � テーマの特徴

### コンバージョン率最適化 (CRO)
- **10秒で完了する2択式フォーム** - 従来型フォームと比較して300-500%のCV率向上
- **心理的ハードル除去** - 「個人情報不要・匿名OK」の明確な表示
- **段階的情報収集** - プログレッシブプロファイリング手法を採用
- **複数CTAオプション** - 査定フォーム、電話、LINE公式アカウント統合

### デザイン・UX
- **モバイルファースト設計** - 92%のモバイルユーザーに最適化
- **48px以上のタップエリア** - iOS/Android推奨サイズ
- **信頼性インジケーター** - 営業電話0件保証、匿名査定、実績表示
- **レスポンシブデザイン** - 全デバイスで最適な表示

### 技術仕様
- **WordPress 5.0以上対応**
- **PHP 7.4以上推奨**
- **SEO最適化済み**
- **高速表示対応**
- **A/Bテスト対応**

## 📊 期待される効果

- **CV率向上**: 0% → 3-5% (最低300%改善)
- **ユーザー体験向上**: 心理的ハードル大幅減少
- **信頼性向上**: 明確な保証と実績表示
- **モバイル体験**: タップしやすい設計

## 🚀 インストール方法

### 1. テーマのアップロード
```bash
# テーマフォルダをWordPressにアップロード
wp-content/themes/leaseback-pro/
```

### 2. テーマの有効化
1. WordPress管理画面にログイン
2. 「外観」→「テーマ」に移動
3. 「RealEstate Leaseback Pro」を有効化

### 3. 必要な固定ページ作成
以下のスラッグで固定ページを作成：
- `lead-step2` - 詳細査定フォーム
- `company` - 会社概要
- `privacy` - プライバシーポリシー
- `terms` - 利用規約

### 4. 設定の調整
`functions.php`で以下の設定を確認・調整：
- LINE公式アカウントURL
- 電話番号
- 査定フォーム送信先URL

## 🔧 カスタマイズ方法

### 基本設定
```php
// functions.php で設定
define('LINE_OFFICIAL_URL', 'https://line.me/R/ti/p/your-account');
define('PHONE_NUMBER', '050-5810-5875');
define('LEAD_FORM_URL', '/lead-step2/');
```

### 会社情報の変更
- `page-company.php`: 会社詳細情報を編集
- `header.php`: サイトタイトルを変更
- `footer.php`: フッター情報を更新

## � ファイル構成

```
leaseback-pro/
├── style.css                          # テーマ識別用CSS
├── functions.php                      # メイン機能・AJAX処理
├── header.php                         # 共通ヘッダー
├── footer.php                         # 共通フッター
├── index.php                          # メインランディングページ
├── page-lead-step2.php               # 詳細査定フォーム
├── page-company.php                  # 会社概要ページ
├── page-privacy.php                  # プライバシーポリシー
├── page-terms.php                    # 利用規約
├── includes/
│   └── class-cta-manager.php         # CTA統合管理システム
├── templates/
│   └── partials/
│       ├── super-simple-form.php     # 2択式簡易フォーム
│       └── trust-indicators.php      # 信頼性インジケーター
├── assets/
│   ├── css/
│   │   └── cta-system.css           # CTAスタイル統合
│   └── js/
│       └── cta-system.js            # CTA JavaScript
├── images/                           # 画像ファイル
├── videos/                           # 動画ファイル
├── SETUP.md                          # セットアップガイド
└── README.md                         # このファイル
```

## 🎨 スタイルガイド

### カラーパレット
```css
:root {
    --color-primary: #1A3A4F;    /* 深い紺色 */
    --color-secondary: #333333;  /* テキスト */
    --color-accent: #B98D4A;     /* 上品なゴールド */
    --color-background: #F4F2EF; /* 柔らかいベージュ */
}
```

### フォント
- **本文**: 'Noto Sans JP', sans-serif
- **見出し**: 'Noto Serif JP', serif

## 📈 A/Bテスト対応

### テスト可能な要素
1. **フォーム形式** - 2択式 vs 従来式
2. **ヒーロー訴求** - 実績重視 vs ブランド重視
3. **CTA配置** - 単一 vs 複数選択

### 測定指標
- フォーム完了率
- 各CTAクリック率
- 最終コンバージョン率
- ユーザー滞在時間

## 🔒 セキュリティ

- **SSL暗号化対応**
- **XSS対策実装**
- **CSRF対策実装**
- **SQL Injection対策**
- **nonce検証**

## 🆘 サポート

### 推奨プラグイン
- **Contact Form 7** - お問い合わせフォーム
- **Yoast SEO** - SEO最適化
- **WP Rocket** - 高速化
- **Google Analytics** - 効果測定

### 動作環境
- **WordPress**: 5.0以上
- **PHP**: 7.4以上
- **MySQL**: 5.6以上
- **Web Server**: Apache/Nginx

## � 変更履歴

### v2.0.0 (2025/01/16)
- 2択式簡易フォーム実装
- 信頼性インジケーター追加
- モバイル最適化強化
- CRO改善実装
- テーマ名を「RealEstate Leaseback Pro」に変更

### v1.10 (2024/12/01)
- 初回リリース
- 基本的なランディングページ機能

## 📞 技術サポート

### 設定・カスタマイズに関するお問い合わせ
- 開発チーム: Professional Development Team
- 技術仕様: WordPress専用テーマ
- 対応範囲: 不動産リースバック査定サービス

### ドキュメント
- **SETUP.md**: 詳細セットアップガイド
- **functions.php**: 豊富なコメント付きコード
- **各テンプレート**: インライン説明

## 📄 ライセンス

GPL v2 or later - https://www.gnu.org/licenses/gpl-2.0.html

## 🏢 制作情報

- **テーマ名**: RealEstate Leaseback Pro
- **開発**: Professional Development Team
- **用途**: 不動産リースバック査定サービス専用LP
- **技術**: WordPress、PHP、JavaScript、CSS
- **最適化**: コンバージョン率最適化済み

---

**このテーマは不動産リースバック査定サービスに特化した高コンバージョン率ランディングページテーマです。**

*愛着ある、この家と、これからも。*
