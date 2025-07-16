<?php
/**
 * Template Name: プライバシーポリシー
 */
get_header(); ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プライバシーポリシー | <?php bloginfo('name'); ?></title>
    <meta name="description" content="<?php bloginfo('name'); ?>のプライバシーポリシー。個人情報の取り扱いについて詳しくご説明いたします。">
    <?php wp_head(); ?>
    <style>
        :root {
            --color-primary: #1A3A4F;
            --color-secondary: #333333;
            --color-accent: #B98D4A;
            --color-background: #F4F2EF;
            --font-body: 'Noto Sans JP', sans-serif;
            --font-heading: 'Noto Serif JP', serif;
        }

        body {
            font-family: var(--font-body);
            background-color: var(--color-background);
            margin: 0;
            padding: 0;
            font-size: 16px;
            line-height: 1.8;
            color: var(--color-secondary);
        }

        .container { max-width: 800px; margin: 0 auto; padding: 0 20px; }

        /* パンくずリスト */
        .breadcrumb-container {
            background-color: #f8f9fa;
            padding: 15px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .breadcrumb {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
            font-size: 14px;
            color: #666;
        }
        .breadcrumb ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }
        .breadcrumb li {
            display: flex;
            align-items: center;
        }
        .breadcrumb li:not(:last-child)::after {
            content: '>';
            margin: 0 8px;
            color: #999;
            font-size: 12px;
        }
        .breadcrumb a {
            color: var(--color-primary);
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .breadcrumb a:hover {
            color: var(--color-accent);
            text-decoration: underline;
        }
        .breadcrumb .current {
            color: #999;
            font-weight: 500;
        }
        .breadcrumb .home-icon {
            color: var(--color-accent);
            margin-right: 5px;
            font-size: 12px;
        }

        /* ヘッダー */
        .page-header {
            background: linear-gradient(135deg, var(--color-primary), #0F2A3F);
            color: #fff;
            padding: 60px 0;
            text-align: center;
        }
        .page-title {
            font-family: var(--font-heading);
            font-size: 2.2rem;
            font-weight: 700;
            margin: 0;
        }

        /* メインコンテンツ */
        .main-content {
            padding: 60px 0;
            background: #fff;
            margin: 40px 0;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .content-wrapper {
            padding: 0 40px;
        }

        .last-updated {
            text-align: right;
            color: #666;
            font-size: 14px;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
        }

        .section {
            margin-bottom: 40px;
        }

        .section-title {
            font-family: var(--font-heading);
            font-size: 1.4rem;
            color: var(--color-primary);
            margin-bottom: 20px;
            padding-left: 16px;
            border-left: 4px solid var(--color-accent);
        }

        .subsection-title {
            font-size: 1.1rem;
            color: var(--color-primary);
            margin: 24px 0 12px 0;
            font-weight: 600;
        }

        .content-text {
            line-height: 1.8;
            margin-bottom: 16px;
        }

        .content-list {
            margin: 16px 0;
            padding-left: 20px;
        }

        .content-list li {
            margin-bottom: 8px;
            line-height: 1.6;
        }

        .table-wrapper {
            overflow-x: auto;
            margin: 20px 0;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            background: #f8f9fa;
            border-radius: 8px;
            overflow: hidden;
        }

        .info-table th,
        .info-table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        .info-table th {
            background: var(--color-primary);
            color: #fff;
            font-weight: 600;
        }

        .contact-info {
            background: #f8f9fa;
            padding: 24px;
            border-radius: 8px;
            margin: 24px 0;
        }

        .contact-info h4 {
            color: var(--color-primary);
            margin-bottom: 12px;
        }

        /* ホームに戻るボタン */
        .back-to-home {
            text-align: center;
            margin: 40px 0;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--color-primary);
            color: white;
            padding: 14px 28px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background: #0F2A3F;
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }

        /* レスポンシブ対応 */
        @media (max-width: 768px) {
            .page-title {
                font-size: 1.8rem;
            }
            
            .content-wrapper {
                padding: 0 20px;
            }
            
            .section-title {
                font-size: 1.2rem;
            }
        }
    </style>
</head>

<body <?php body_class(); ?>>

<!-- パンくずリスト -->
<div class="breadcrumb-container">
    <nav class="breadcrumb">
        <ul>
            <li>
                <a href="<?php echo home_url(); ?>">
                    <i class="fas fa-home home-icon"></i>ホーム
                </a>
            </li>
            <li>
                <span class="current">プライバシーポリシー</span>
            </li>
        </ul>
    </nav>
</div>

<!-- ページヘッダー -->
<header class="page-header">
    <div class="container">
        <h1 class="page-title">プライバシーポリシー</h1>
    </div>
</header>

<!-- メインコンテンツ -->
<main class="main-content">
    <div class="container">
        <div class="content-wrapper">
            
            <div class="last-updated">
                制定日：<?php echo date('Y年m月d日'); ?>
            </div>

            <!-- 基本方針 -->
            <section class="section">
                <h2 class="section-title">基本方針</h2>
                <p class="content-text">
                    <?php bloginfo('name'); ?>（以下「当社」といいます。）は、お客様の個人情報保護の重要性を認識し、
                    個人情報の保護に関する法律（個人情報保護法）を遵守するとともに、以下のプライバシーポリシーに従って、
                    適切な取扱い及び保護に努めます。
                </p>
            </section>

            <!-- 個人情報の定義 -->
            <section class="section">
                <h2 class="section-title">個人情報の定義</h2>
                <p class="content-text">
                    個人情報とは、お客様個人に関する情報であって、お客様の氏名、生年月日、住所、電話番号、
                    電子メールアドレス等により、お客様を識別できる情報をいいます。
                </p>
            </section>

            <!-- 個人情報の収集 -->
            <section class="section">
                <h2 class="section-title">個人情報の収集</h2>
                <p class="content-text">
                    当社は、以下の場合に個人情報を収集いたします：
                </p>
                <ul class="content-list">
                    <li>査定依頼フォームでのお申し込み時</li>
                    <li>お電話でのお問い合わせ時</li>
                    <li>メールでのお問い合わせ時</li>
                    <li>各種サービスのお申し込み時</li>
                    <li>その他、当社サービス利用時</li>
                </ul>
            </section>

            <!-- 個人情報の利用目的 -->
            <section class="section">
                <h2 class="section-title">個人情報の利用目的</h2>
                <p class="content-text">
                    当社は、収集した個人情報を以下の目的で利用いたします：
                </p>
                <ul class="content-list">
                    <li>不動産査定サービスの提供</li>
                    <li>リースバックサービスの提供</li>
                    <li>お客様へのご連絡・ご案内</li>
                    <li>契約締結及び履行</li>
                    <li>アフターサービスの提供</li>
                    <li>新サービス・商品のご案内</li>
                    <li>統計資料の作成（個人を特定できない形式）</li>
                    <li>その他、当社業務の適正な遂行</li>
                </ul>
            </section>

            <!-- 個人情報の第三者提供 -->
            <section class="section">
                <h2 class="section-title">個人情報の第三者提供</h2>
                <p class="content-text">
                    当社は、以下の場合を除き、お客様の同意なく個人情報を第三者に提供することはありません：
                </p>
                <ul class="content-list">
                    <li>法令に基づく場合</li>
                    <li>人の生命、身体又は財産の保護のために必要がある場合</li>
                    <li>公衆衛生の向上又は児童の健全な育成の推進のため特に必要がある場合</li>
                    <li>国の機関若しくは地方公共団体又はその委託を受けた者が法令の定める事務を遂行することに対して協力する必要がある場合</li>
                    <li>提携先企業等へのサービス提供のため必要な場合（事前に同意をいただいた場合）</li>
                </ul>
            </section>

            <!-- 個人情報の管理 -->
            <section class="section">
                <h2 class="section-title">個人情報の管理</h2>
                <p class="content-text">
                    当社は、個人情報の正確性を保ち、これを安全に管理いたします。
                    個人情報への不正アクセス、個人情報の紛失、破壊、改ざん及び漏洩などを防止するため、
                    適切なセキュリティ対策を実施いたします。
                </p>
            </section>

            <!-- 個人情報の開示・訂正・削除 -->
            <section class="section">
                <h2 class="section-title">個人情報の開示・訂正・削除</h2>
                <p class="content-text">
                    お客様ご本人が、個人情報の開示・訂正・削除等を希望される場合には、
                    本人確認をさせていただいた上で、合理的な期間内に対応いたします。
                </p>
            </section>

            <!-- Cookie等の利用 -->
            <section class="section">
                <h2 class="section-title">Cookie等の利用</h2>
                <p class="content-text">
                    当社ウェブサイトでは、より良いサービス提供のため、Cookie及び類似技術を使用する場合があります。
                    これらの技術により個人を特定することはありません。
                </p>
            </section>

            <!-- お問い合わせ窓口 -->
            <section class="section">
                <h2 class="section-title">お問い合わせ窓口</h2>
                <div class="contact-info">
                    <h4>個人情報に関するお問い合わせ</h4>
                    <p class="content-text">
                        <strong><?php bloginfo('name'); ?></strong><br>
                        電話：050-5810-5875<br>
                        受付時間：9:00〜19:00（年中無休）<br>
                        メール：<a href="mailto:info@sumitsuzuke-tai.jp">info@sumitsuzuke-tai.jp</a>
                    </p>
                </div>
            </section>

            <!-- プライバシーポリシーの変更 -->
            <section class="section">
                <h2 class="section-title">プライバシーポリシーの変更</h2>
                <p class="content-text">
                    当社は、法令の変更等に伴い、本プライバシーポリシーを変更することがあります。
                    変更後のプライバシーポリシーについては、当社ウェブサイトに掲載したときから効力を生じるものとします。
                </p>
            </section>

        </div>
    </div>
</main>

<!-- ホームに戻るボタン -->
<div class="back-to-home">
    <div class="container">
        <a href="<?php echo home_url(); ?>" class="back-button">
            <i class="fas fa-home"></i>
            ホームに戻る
        </a>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>