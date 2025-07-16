<?php
/**
 * Template Name: 利用規約
 */
get_header(); ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>利用規約 | <?php bloginfo('name'); ?></title>
    <meta name="description" content="<?php bloginfo('name'); ?>の利用規約。サービス利用に関する重要事項をご確認ください。">
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

        .article {
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 1px solid #f0f0f0;
        }

        .article:last-child {
            border-bottom: none;
        }

        .article-title {
            font-family: var(--font-heading);
            font-size: 1.4rem;
            color: var(--color-primary);
            margin-bottom: 20px;
            padding-left: 16px;
            border-left: 4px solid var(--color-accent);
        }

        .article-content {
            line-height: 1.8;
            margin-bottom: 16px;
        }

        .article-list {
            margin: 16px 0;
            padding-left: 20px;
        }

        .article-list li {
            margin-bottom: 8px;
            line-height: 1.6;
        }

        .sub-list {
            margin: 8px 0;
            padding-left: 20px;
        }

        .note {
            background: #f8f9fa;
            padding: 16px;
            border-left: 4px solid var(--color-accent);
            margin: 20px 0;
            font-size: 14px;
        }

        .important {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 16px;
            margin: 20px 0;
        }

        .important-title {
            font-weight: 600;
            color: #856404;
            margin-bottom: 8px;
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
            
            .article-title {
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
                <span class="current">利用規約</span>
            </li>
        </ul>
    </nav>
</div>

<!-- ページヘッダー -->
<header class="page-header">
    <div class="container">
        <h1 class="page-title">利用規約</h1>
    </div>
</header>

<!-- メインコンテンツ -->
<main class="main-content">
    <div class="container">
        <div class="content-wrapper">
            
            <div class="last-updated">
                制定日：<?php echo date('Y年m月d日'); ?>
            </div>

            <!-- 第1条 -->
            <article class="article">
                <h2 class="article-title">第1条（適用範囲）</h2>
                <p class="article-content">
                    本利用規約（以下「本規約」といいます。）は、<?php bloginfo('name'); ?>（以下「当社」といいます。）が提供する
                    リースバック査定サービス及び関連サービス（以下「本サービス」といいます。）の利用に関して、
                    利用者と当社との間の権利義務関係を定めることを目的とし、利用者と当社との間に適用されます。
                </p>
            </article>

            <!-- 第2条 -->
            <article class="article">
                <h2 class="article-title">第2条（定義）</h2>
                <p class="article-content">本規約において使用する用語の定義は、以下のとおりです。</p>
                <ol class="article-list">
                    <li>「利用者」とは、本サービスを利用する個人または法人をいいます。</li>
                    <li>「査定依頼」とは、利用者が当社に対して不動産の査定を依頼することをいいます。</li>
                    <li>「個人情報」とは、利用者個人に関する情報であって、当該情報に含まれる氏名、住所、電話番号等により特定の個人を識別できるものをいいます。</li>
                    <li>「コンテンツ」とは、本サービス上で提供される文字、画像、動画、音声等の情報をいいます。</li>
                </ol>
            </article>

            <!-- 第3条 -->
            <article class="article">
                <h2 class="article-title">第3条（本サービスの内容）</h2>
                <p class="article-content">本サービスは、以下のサービスを提供します。</p>
                <ul class="article-list">
                    <li>不動産のリースバック査定サービス</li>
                    <li>不動産に関する相談・コンサルティングサービス</li>
                    <li>その他当社が提供するサービス</li>
                </ul>
            </article>

            <!-- 第4条 -->
            <article class="article">
                <h2 class="article-title">第4条（利用者の義務）</h2>
                <p class="article-content">利用者は、本サービスの利用にあたり、以下の義務を負います。</p>
                <ol class="article-list">
                    <li>本規約及び関連する法令を遵守すること</li>
                    <li>正確かつ最新の情報を提供すること</li>
                    <li>第三者の権利を侵害しないこと</li>
                    <li>本サービスの運営を妨げる行為をしないこと</li>
                    <li>その他、当社が定める事項を遵守すること</li>
                </ol>
            </article>

            <!-- 第5条 -->
            <article class="article">
                <h2 class="article-title">第5条（禁止事項）</h2>
                <p class="article-content">利用者は、本サービスの利用にあたり、以下の行為を行ってはならないものとします。</p>
                <ul class="article-list">
                    <li>法令に違反する行為または違反のおそれのある行為</li>
                    <li>当社または第三者の権利を侵害する行為</li>
                    <li>虚偽の情報を提供する行為</li>
                    <li>本サービスの運営を妨害する行為</li>
                    <li>コンピュータウイルス等の有害なプログラムを送信する行為</li>
                    <li>営業、宣伝、広告、勧誘等を目的とする行為</li>
                    <li>その他、当社が不適切と判断する行為</li>
                </ul>
            </article>

            <!-- 第6条 -->
            <article class="article">
                <h2 class="article-title">第6条（個人情報の取扱い）</h2>
                <p class="article-content">
                    当社は、利用者の個人情報を、当社のプライバシーポリシーに従って適切に取り扱います。
                    利用者は、当社のプライバシーポリシーに同意した上で本サービスを利用するものとします。
                </p>
            </article>

            <!-- 第7条 -->
            <article class="article">
                <h2 class="article-title">第7条（知的財産権）</h2>
                <p class="article-content">
                    本サービスに関する知的財産権（著作権、商標権、特許権等を含みますがこれらに限られません。）は、
                    当社または当社にライセンスを許諾した第三者に帰属します。
                    利用者は、これらの知的財産権を侵害する行為を行ってはならないものとします。
                </p>
            </article>

            <!-- 第8条 -->
            <article class="article">
                <h2 class="article-title">第8条（免責事項）</h2>
                <p class="article-content">当社は、以下の事項について一切の責任を負いません。</p>
                <ul class="article-list">
                    <li>本サービスの内容、品質、性能等に関する事項</li>
                    <li>本サービスの利用により利用者に生じた損害</li>
                    <li>システムの障害、通信回線の障害等による本サービスの中断・停止</li>
                    <li>第三者による本サービスの不正利用</li>
                    <li>その他、当社の責に帰さない事由による損害</li>
                </ul>
                
                <div class="important">
                    <div class="important-title">重要事項</div>
                    <p>査定結果は参考値であり、実際の取引価格を保証するものではありません。
                    最終的な取引条件については、別途協議の上で決定いたします。</p>
                </div>
            </article>

            <!-- 第9条 -->
            <article class="article">
                <h2 class="article-title">第9条（サービスの変更・中止）</h2>
                <p class="article-content">
                    当社は、利用者への事前の通知なく、本サービスの内容を変更し、または本サービスの提供を中止することがあります。
                    これにより利用者に損害が生じた場合でも、当社は一切の責任を負わないものとします。
                </p>
            </article>

            <!-- 第10条 -->
            <article class="article">
                <h2 class="article-title">第10条（規約の変更）</h2>
                <p class="article-content">
                    当社は、必要に応じて本規約を変更することがあります。
                    変更後の規約は、当社ウェブサイトに掲載した時点で効力を生じるものとします。
                    利用者は、本規約の変更に同意できない場合、本サービスの利用を中止することができます。
                </p>
            </article>

            <!-- 第11条 -->
            <article class="article">
                <h2 class="article-title">第11条（準拠法及び管轄裁判所）</h2>
                <p class="article-content">
                    本規約の解釈・適用については、日本法に準拠するものとします。
                    本サービスに関連して生じた紛争については、当社の本店所在地を管轄する地方裁判所を第一審の専属的合意管轄裁判所とします。
                </p>
            </article>

            <div class="note">
                <p><strong>お問い合わせ</strong></p>
                <p>本規約に関するご質問は、以下までお問い合わせください。</p>
                <p>
                    <?php bloginfo('name'); ?><br>
                    電話：050-5810-5875<br>
                    受付時間：9:00〜19:00（年中無休）<br>
                    メール：<a href="mailto:info@sumitsuzuke-tai.jp">info@sumitsuzuke-tai.jp</a>
                </p>
            </div>

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