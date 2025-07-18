<?php
/**
 * Template Name: 会社概要
 */
get_header(); ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会社概要 | <?php bloginfo('name'); ?></title>
    <meta name="description" content="<?php bloginfo('name'); ?>の会社概要。企業理念、会社情報、アクセス情報をご紹介しています。">
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

        .container { max-width: 1000px; margin: 0 auto; padding: 0 20px; }

        /* パンくずリスト */
        .breadcrumb-container {
            background-color: #f8f9fa;
            padding: 15px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .breadcrumb {
            max-width: 1000px;
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
            padding: 80px 0;
            text-align: center;
        }
        .page-title {
            font-family: var(--font-heading);
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
        }
        .page-subtitle {
            font-size: 1.1rem;
            margin: 16px 0 0 0;
            opacity: 0.9;
        }

        /* メインコンテンツ */
        .main-content {
            padding: 80px 0;
        }

        .section {
            margin-bottom: 60px;
        }

        .section-title {
            font-family: var(--font-heading);
            font-size: 1.8rem;
            color: var(--color-primary);
            margin-bottom: 30px;
            padding-bottom: 12px;
            border-bottom: 3px solid var(--color-accent);
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 80px;
            height: 3px;
            background: var(--color-primary);
        }

        /* 企業理念 */
        .philosophy-content {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            margin-bottom: 40px;
        }

        .philosophy-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--color-secondary);
            text-align: center;
            font-weight: 500;
            text-wrap: balance;
        }

        /* 会社情報テーブル */
        .company-table {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .company-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .company-table th,
        .company-table td {
            padding: 20px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }

        .company-table th {
            background: var(--color-primary);
            color: #fff;
            font-weight: 600;
            width: 180px;
            vertical-align: middle;
        }

        .company-table td {
            background: #fff;
            color: var(--color-secondary);
            vertical-align: middle;
        }

        .company-table tr:last-child th,
        .company-table tr:last-child td {
            border-bottom: none;
        }

        /* アクセス情報 */
        .access-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-top: 30px;
        }

        .access-info {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .access-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--color-primary);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .access-details p {
            margin: 8px 0;
            line-height: 1.6;
        }

        .access-details strong {
            color: var(--color-primary);
        }

        /* お問い合わせボタン */
        .contact-section {
            background: linear-gradient(135deg, var(--color-accent), #D4A574);
            padding: 50px;
            border-radius: 16px;
            text-align: center;
            color: #fff;
        }

        .contact-title {
            font-family: var(--font-heading);
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        .contact-text {
            font-size: 1.1rem;
            margin-bottom: 30px;
            opacity: 0.95;
        }

        .contact-button {
            display: inline-block;
            background: #fff;
            color: var(--color-primary);
            padding: 16px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        }

        .contact-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            color: var(--color-primary);
            text-decoration: none;
        }

        /* フッター */
        .back-to-home {
            text-align: center;
            margin: 60px 0 40px;
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
                font-size: 2rem;
            }
            
            .philosophy-text {
                font-size: 1rem;
                line-height: 1.7;
                text-align: left;
            }
            
            .access-content {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .company-table th {
                width: 120px;
                padding: 15px;
                font-size: 14px;
            }
            
            .company-table td {
                padding: 15px;
                font-size: 14px;
            }
            
            .philosophy-content,
            .access-info {
                padding: 25px;
            }
            
            .contact-section {
                padding: 35px 25px;
            }
        }

        @media (max-width: 480px) {
            .company-table th,
            .company-table td {
                display: block;
                width: 100%;
                padding: 12px 15px;
            }
            
            .company-table th {
                background: var(--color-accent);
                border-bottom: 1px solid rgba(255,255,255,0.2);
            }
            
            .company-table td {
                background: #f8f9fa;
                border-bottom: 2px solid #e9ecef;
                margin-bottom: 1px;
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
                <span class="current">会社概要</span>
            </li>
        </ul>
    </nav>
</div>

<!-- ページヘッダー -->
<header class="page-header">
    <div class="container">
        <h1 class="page-title">会社概要</h1>
        <p class="page-subtitle">Company Profile</p>
    </div>
</header>

<!-- メインコンテンツ -->
<main class="main-content">
    <div class="container">
        
        <!-- 企業理念 -->
        <section class="section">
            <h2 class="section-title">企業理念</h2>
            <div class="philosophy-content">
                <p class="philosophy-text">
                    人生の重みを背負いながらも、<br>
                    決して諦めない。<br><br>
                    
                    家族との思い出が刻まれたその場所で、<br>
                    あなたが生き続けることを<br>
                    私たちは全力で支えます。<br><br>
                    
                    リースバックは単なる金融商品ではありません。<br>
                    それは、人生の再出発への希望であり、<br>
                    家族への愛情を形にする手段であり、<br>
                    未来への新たな扉を開く鍵なのです。<br><br>
                    
                    私たちは、お客様一人ひとりの物語に寄り添い、<br>
                    最適な選択肢を見つけ出すことで、<br>
                    「住み続ける」という当たり前の幸せを<br>
                    守り抜きます。<br><br>
                    
                    <strong>あなたの「今」を大切にし、<br>
                    「未来」に希望を灯す。</strong><br><br>
                    それが、住み続け隊の使命です。
                </p>
            </div>
        </section>

        <!-- 会社情報 -->
        <section class="section">
            <h2 class="section-title">会社情報</h2>
            <div class="company-table">
                <table>
                    <tr>
                        <th>会社名</th>
                        <td>株式会社クロフネチンタイ管理</td>
                    </tr>
                    <tr>
                        <th>設立</th>
                        <td>令和5年7月6日（2023年7月6日）</td>
                    </tr>
                    <tr>
                        <th>資本金</th>
                        <td>300万円</td>
                    </tr>
                    <tr>
                        <th>所在地</th>
                        <td>
                            〒230-0011<br>
                            神奈川県横浜市鶴見区上末吉四丁目11番4号<br>
                            アネックス第一ハイムA棟102
                        </td>
                    </tr>
                    <tr>
                        <th>事業内容</th>
                        <td>
                            ・リースバックサービスの提供<br>
                            ・不動産仲介業<br>
                            ・不動産コンサルティング業務<br>
                            ・Webメディア運営
                        </td>
                    </tr>
                    <tr>
                        <th>提携会社数</th>
                        <td style="font-size: 20px; font-weight: bold; color: #FF6A3D;">200社以上</td>
                    </tr>
                    <tr>
                        <th>電話番号</th>
                        <td>
                            <a href="tel:050-5810-5875" style="color: var(--color-primary); text-decoration: none; font-weight: 600; font-size: 18px; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px;">
                                <i class="fas fa-phone-alt" style="color: var(--color-accent); font-size: 16px;"></i>
                                050-5810-5875
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th>営業時間</th>
                        <td>9:00〜19:00（年中無休）</td>
                    </tr>
                </table>
            </div>
        </section>

        <!-- アクセス情報 -->
        <section class="section">
            <h2 class="section-title">アクセス情報</h2>
            <div class="access-content">
                <div class="access-info">
                    <h3 class="access-title">
                        <i class="fas fa-map-marker-alt"></i>
                        本社所在地
                    </h3>
                    <div class="access-details">
                        <p><strong>住所:</strong> 神奈川県横浜市鶴見区上末吉四丁目11番4号</p>
                        <p><strong>最寄駅:</strong> JR鶴見駅・京急鶴見駅</p>
                        <p><strong>アクセス:</strong> 鶴見駅より徒歩約15分</p>
                    </div>
                </div>
                
                <div class="access-info">
                    <h3 class="access-title">
                        <i class="fas fa-phone"></i>
                        お問い合わせ
                    </h3>
                    <div class="access-details">
                        <p><strong>電話:</strong> 050-5810-5875</p>
                        <p><strong>受付時間:</strong> 9:00〜19:00</p>
                        <p><strong>定休日:</strong> 年中無休</p>
                        <p><strong>対応エリア:</strong> 全国対応</p>
                    </div>
                </div>
            </div>
            
            <!-- Google Maps -->
            <div style="margin-top: 30px; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d17283.50939876552!2d139.6659718!3d35.529002399999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60185fc0e19d7679%3A0x37e4acf29e1243d3!2z44Ki44ON44OD44Kv44K556ys77yR44OP44Kk44OgQ-ajnw!5e1!3m2!1sja!2sjp!4v1748572404970!5m2!1sja!2sjp" 
                    width="100%" 
                    height="300" 
                    style="border:0; border-radius: 12px;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </section>

        <!-- お問い合わせセクション -->
        <section class="section">
            <div class="contact-section">
                <h2 class="contact-title">お気軽にお問い合わせください</h2>
                <p class="contact-text">
                    リースバックに関するご質問・ご相談は無料です。<br>
                    まずはお気軽にお電話または<br>
                    フォームからお問い合わせください。
                </p>
                <a href="<?php echo home_url(); ?>#assessment-form" class="contact-button">
                    無料査定を申し込む
                </a>
            </div>
        </section>
        
        <!-- ホームに戻るボタン -->
        <div class="back-to-home">
            <a href="<?php echo home_url(); ?>" class="back-button">
                <i class="fas fa-home"></i>
                ホームに戻る
            </a>
        </div>
    </div>
</main>

<?php wp_footer(); ?>
</body>
</html>