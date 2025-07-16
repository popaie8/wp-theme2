<?php
/**
 * メインランディングページ (2.html のWordPress版)
 */

get_header();
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    <?php wp_head(); ?>
    <style>
        :root {
            --color-primary: #1A3A4F; /* 深い紺色 */
            --color-secondary: #333333; /* テキスト */
            --color-accent: #B98D4A;  /* 上品なゴールド/ブラウン */
            --color-background: #F4F2EF; /* 柔らかいベージュ */
            --font-body: 'Noto Sans JP', sans-serif;
            --font-heading: 'Noto Serif JP', serif;
            /* スペーシングシステム */
            --spacing-xs: 0.5rem;
            --spacing-sm: 1rem;
            --spacing-md: 1.5rem;
            --spacing-lg: 2rem;
            --spacing-xl: 3rem;
            --spacing-2xl: 4rem;
            /* コンテナ幅 */
            --container-max: 1200px;
            --container-padding: 24px;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font-body);
            background-color: var(--color-background);
            margin: 0;
            padding: 0;
            font-size: 16px;
            line-height: 1.8;
            color: var(--color-secondary);
            -webkit-font-smoothing: antialiased;
            padding-bottom: 80px; /* フローティングCTA分の余白 */
        }

        /* --- 固定ヘッダー --- */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: clamp(0.75rem, 2vw, 1.25rem) clamp(1rem, 3vw, 2rem);
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-sizing: border-box;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            background: rgba(26, 58, 79, 0.05);
        }
        
        .header-logo {
            font-family: var(--font-heading);
            font-size: clamp(1rem, 2vw + 0.5rem, 1.3rem);
            font-weight: 700;
            color: #fff;
            text-decoration: none;
            mix-blend-mode: exclusion;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 60%;
            flex-shrink: 1;
        }

        .header-cta {
            flex-shrink: 0;
        }
        
        .header-cta a {
            font-family: var(--font-body);
            font-weight: 500;
            color: #fff;
            text-decoration: none;
            border: 1px solid rgba(255,255,255,0.7);
            padding: clamp(0.4rem, 1vw, 0.5rem) clamp(0.75rem, 2vw, 1rem);
            border-radius: 20px;
            transition: all 0.3s ease;
            font-size: clamp(0.75rem, 1.5vw, 0.9rem);
            white-space: nowrap;
            display: inline-block;
        }

        .header-cta a:hover {
            background-color: rgba(255,255,255,1);
            color: var(--color-primary);
            transform: translateY(-1px);
        }

        .header-nav {
            display: none;
        }

        .container { 
            max-width: var(--container-max);
            margin: 0 auto;
            padding: 0 var(--container-padding);
            width: 100%;
            box-sizing: border-box;
        }
        section {
            padding: clamp(3rem, 8vw, 5rem) 0;
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 1.2s ease-out, transform 1.2s ease-out;
        }
        section.visible { opacity: 1; transform: translateY(0); }

        h2, h3 {
            font-family: var(--font-heading);
            font-weight: 700;
            line-height: 1.6;
            color: var(--color-primary);
        }
        h2.section-title {
            font-size: clamp(1.5rem, 3vw + 0.5rem, 2.5rem);
            text-align: center;
            margin-bottom: var(--spacing-xl);
            font-weight: 500;
            line-height: 1.4;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            text-wrap: balance;
        }
        
        /* --- ヒーローセクション（改良版） --- */
        .hero {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #fff;
            position: relative;
            overflow: hidden;
        }
        
        .hero-video {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            transform: translate(-50%, -50%);
            z-index: 1;
            object-fit: cover;
            pointer-events: none; /* 動画クリック無効化 */
            opacity: 1; /* 初期から表示 */
            transition: opacity 1s ease-in-out; /* フェードイン効果 */
            display: block !important; /* 表示を強制 */
        }
        
        /* 動画が読み込まれない場合のフォールバック背景 */
        .hero {
            background: linear-gradient(135deg, 
                rgba(26, 58, 79, 0.9) 0%, 
                rgba(185, 141, 74, 0.8) 100%),
                url('<?php echo get_template_directory_uri(); ?>/images/hero-bg.jpg') center/cover;
        }
        
        /* モバイルでは動画を無効化してパフォーマンス向上 */
        @media (max-width: 768px) {
            .hero-video {
                display: none;
            }
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, 
                rgba(26, 58, 79, 0.7) 0%, 
                rgba(185, 141, 74, 0.6) 100%);
            z-index: 2;
        }

        .hero-content {
            position: relative;
            z-index: 3;
            max-width: 900px;
            padding: 0 20px;
            animation: fadeIn 1.5s ease-out forwards;
        }

        .hero-title {
            font-family: var(--font-heading);
            font-size: clamp(1.8rem, 4vw + 0.5rem, 3.5rem);
            font-weight: 700;
            margin-bottom: var(--spacing-lg);
            line-height: 1.4;
            animation: slideUp 1s 0.5s ease-out forwards;
            opacity: 0;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            text-wrap: balance;
        }
        
        .hero-title .highlight {
            display: inline-block;
            background: linear-gradient(120deg, var(--color-accent) 0%, #D4A574 100%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
        }

        .hero-stats {
            display: flex;
            justify-content: center;
            gap: clamp(1rem, 3vw, 2.5rem);
            margin-bottom: var(--spacing-xl);
            animation: fadeIn 1s 0.3s ease-out forwards;
            opacity: 0;
            flex-wrap: wrap;
        }
        
        .stat-item {
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            padding: clamp(0.75rem, 2vw, 1.25rem) clamp(1rem, 2vw, 1.5rem);
            border-radius: 12px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            min-width: 100px;
        }
        
        .stat-number {
            display: block;
            font-size: clamp(1.2rem, 2.5vw, 1.8rem);
            font-weight: 700;
            color: #fff;
            margin-bottom: 0.25rem;
        }
        
        .stat-label {
            font-size: clamp(0.7rem, 1.5vw, 0.9rem);
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
        }

        .hero-cta {
            display: inline-block;
            background: linear-gradient(135deg, var(--color-accent), #D4A574);
            color: #fff;
            padding: 20px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(185, 141, 74, 0.4);
            animation: slideUp 1s 1.1s ease-out forwards;
            opacity: 0;
        }

        .hero-cta:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(185, 141, 74, 0.6);
            color: #fff;
            text-decoration: none;
        }

        .hero-benefits {
            display: flex;
            justify-content: center;
            gap: clamp(0.75rem, 2vw, 1.5rem);
            margin: var(--spacing-xl) 0;
            flex-wrap: wrap;
            animation: slideUp 1s 0.8s ease-out forwards;
            opacity: 0;
        }
        
        .benefit-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(255, 255, 255, 0.15);
            padding: clamp(0.75rem, 1.5vw, 1rem) clamp(1rem, 2vw, 1.5rem);
            border-radius: 30px;
            backdrop-filter: blur(10px);
            font-size: clamp(0.85rem, 1.5vw, 1rem);
            font-weight: 500;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .benefit-item:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }
        
        .benefit-item i {
            color: var(--color-accent);
            font-size: 1.2em;
        }
        
        .hero-cta-group {
            display: flex;
            justify-content: center;
            gap: clamp(0.75rem, 2vw, 1.25rem);
            margin-top: var(--spacing-xl);
            flex-wrap: wrap;
            animation: slideUp 1s 1.1s ease-out forwards;
            opacity: 0;
        }
        
        /* スクロールダウンインジケーター */
        .scroll-down {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 3;
            color: #fff;
            text-align: center;
            font-size: 0.8rem;
            animation: fadeIn 2s 1.5s ease-out forwards;
            opacity: 0;
        }

        .scroll-down .arrow {
            width: 1px;
            height: 50px;
            background-color: #fff;
            margin: 10px auto 0;
            animation: scroll-indicator 2s infinite ease-in-out;
        }
        
        @keyframes scroll-indicator {
            0% { transform: scaleY(0); transform-origin: top; }
            50% { transform: scaleY(1); transform-origin: top; }
            51% { transform: scaleY(1); transform-origin: bottom; }
            100% { transform: scaleY(0); transform-origin: bottom; }
        }

        /* 60秒査定フォーム */
        .assessment-form {
            background: #fff;
            padding: 60px 0;
            position: relative;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: clamp(1.5rem, 4vw, 2.5rem);
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }

        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .form-title {
            font-family: var(--font-heading);
            font-size: 2rem;
            color: var(--color-primary);
            margin-bottom: 12px;
        }

        .form-subtitle {
            color: #666;
            font-size: 1.1rem;
        }

        .form-group {
            margin-bottom: var(--spacing-md);
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--color-primary);
        }

        .req {
            color: #e74c3c;
            font-size: 0.9rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: clamp(0.75rem, 2vw, 1rem);
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
            background: #fff;
            -webkit-appearance: none;
            appearance: none;
        }
        
        .form-group select {
            background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"%3e%3cpolyline points="6 9 12 15 18 9"%3e%3c/polyline%3e%3c/svg%3e');
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1.25rem;
            padding-right: 2.5rem;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--color-accent);
        }

        .submit-button {
            width: 100%;
            background: linear-gradient(135deg, var(--color-primary), #0F2A3F);
            color: #fff;
            padding: clamp(1rem, 2.5vw, 1.25rem);
            border: none;
            border-radius: 50px;
            font-size: clamp(1rem, 2vw, 1.2rem);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: var(--spacing-lg);
        }

        .submit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(26, 58, 79, 0.4);
        }

        .form-benefits {
            list-style: none;
            padding: 0;
            margin: 24px 0 0 0;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 16px;
        }

        .form-benefits li {
            color: #666;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-benefits i {
            color: var(--color-accent);
        }

        /* --- 最終メッセージセクション --- */
        .final-message-section {
            padding: 0; 
            height: 80vh; 
            display: flex; 
            flex-direction: column;
            justify-content: center; 
            align-items: center; 
            text-align: center;
            color: #fff; 
            position: relative;
            overflow: hidden;
        }
        
        .final-message-video {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            transform: translate(-50%, -50%);
            z-index: 0;
            object-fit: cover;
            opacity: 1;
            transition: opacity 1s ease-in-out;
            display: block !important;
        }
        
        .final-message-section::before {
            content: ''; 
            position: absolute; 
            top: 0; 
            left: 0; 
            right: 0; 
            bottom: 0;
            background-color: rgba(26, 58, 79, 0.4); 
            z-index: 1;
        }
        
        .final-message-content { 
            position: relative; 
            z-index: 2; 
            padding: 0 24px; 
        }
        
        .final-message-content h2 { 
            font-size: 2rem; 
            color: #fff; 
            font-weight: 500; 
            line-height: 1.6; 
        }
        
        .final-message-content p { 
            font-size: 1rem; 
            opacity: 0.9; 
            margin-top: 20px; 
        }

        /* --- マンガ教育セクション --- */
        .manga-section { 
            background-color: #fff; 
        }
        
        .manga-box { 
            border: 2px solid #EAE2D9; 
            border-radius: 8px; 
            padding: 24px; 
        }
        
        .manga-chat { 
            display: flex; 
            align-items: flex-start; 
            gap: 16px; 
            margin-bottom: 24px; 
        }
        
        .manga-chat:last-child { 
            margin-bottom: 0; 
        }
        
        .manga-chat .icon { 
            font-size: 40px; 
        }
        
        .manga-chat .bubble {
            background-color: var(--color-background); 
            border-radius: 12px;
            padding: 16px; 
            position: relative;
        }
        
        .manga-chat.right { 
            flex-direction: row-reverse; 
        }
        
        .manga-chat.right .bubble { 
            background-color: #E3EDF3; 
        }
        
        .manga-summary {
            text-align: center; 
            font-size: 1.2rem; 
            font-weight: 700;
            background-color: #FFFBEB; 
            padding: 24px; 
            margin-top: 32px;
            border-radius: 8px; 
            color: var(--color-primary);
        }

        /* --- 顧客価値セクション --- */
        .customer-value-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            padding: var(--spacing-lg) 0;
            position: relative;
        }
        
        .customer-value-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--color-primary), var(--color-accent), var(--color-primary));
        }
        
        .value-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: var(--spacing-md);
            margin-bottom: var(--spacing-lg);
        }
        
        .value-card {
            background: #fff;
            padding: var(--spacing-md);
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
            position: relative;
            overflow: hidden;
        }
        
        .value-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--color-primary), var(--color-accent));
        }
        
        .value-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }
        
        .card-icon {
            font-size: 3rem;
            margin-bottom: var(--spacing-sm);
            display: block;
        }
        
        .value-card h3 {
            color: var(--color-primary);
            font-size: 1.2rem;
            margin-bottom: var(--spacing-sm);
            line-height: 1.4;
        }
        
        .value-card p {
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: var(--spacing-sm);
            font-size: 0.95rem;
        }
        
        .card-stats {
            display: flex;
            align-items: center;
            gap: var(--spacing-xs);
            background: #f8f9fa;
            padding: var(--spacing-xs) var(--spacing-sm);
            border-radius: 8px;
            margin-top: var(--spacing-sm);
        }
        
        .stat-label {
            font-size: 0.8rem;
            color: #6c757d;
        }
        
        .stat-value {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--color-accent);
        }
        
        .testimonial-section {
            margin-top: var(--spacing-lg);
        }
        
        .testimonial-section h3 {
            text-align: center;
            color: var(--color-primary);
            margin-bottom: var(--spacing-md);
            font-size: 1.5rem;
        }
        
        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: var(--spacing-md);
        }
        
        .testimonial-card {
            background: #fff;
            padding: var(--spacing-md);
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            border-left: 4px solid var(--color-accent);
            transition: all 0.3s ease;
        }
        
        .testimonial-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .testimonial-content {
            margin-bottom: var(--spacing-sm);
        }
        
        .testimonial-content p {
            color: #495057;
            line-height: 1.6;
            font-style: italic;
            margin: 0;
        }
        
        .testimonial-author {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .author-name {
            font-weight: 600;
            color: var(--color-primary);
            font-size: 0.9rem;
        }
        
        .author-case {
            background: var(--color-accent);
            color: #fff;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .section-cta {
            text-align: center;
            margin-top: var(--spacing-lg);
            padding: var(--spacing-md);
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 15px;
        }
        
        .cta-subtitle {
            color: var(--color-primary);
            font-size: 1.1rem;
            margin-bottom: var(--spacing-sm);
            font-weight: 600;
        }

        /* --- 知識セクション --- */
        .knowledge-section { 
            background-color: #fff; 
        }
        
        .merit-box, .demerit-box { 
            margin-bottom: 40px; 
        }
        
        .merit-box h3, .demerit-box h3 { 
            font-size: 1.5rem; 
            text-align: center; 
            margin-bottom: 24px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 8px; 
        }
        
        .merit-box ul, .demerit-box ul { 
            list-style: none; 
            padding-left: 0; 
        }
        
        .merit-box li, .demerit-box li {
            background-color: var(--color-background); 
            border-radius: 8px;
            padding: 20px; 
            margin-bottom: 12px; 
            font-weight: 500;
        }
        
        .sincere-promise {
            text-align: center; 
            padding: 24px;
            background-color: #E3EDF3; 
            border-radius: 8px;
        }
        
        .sincere-promise p { 
            margin: 0; 
        }

        /* --- 代表メッセージセクション --- */
        .message-section { 
            text-align: center;
            position: relative;
            overflow: hidden;
            color: #fff;
            padding: clamp(4rem, 8vw, 6rem) 0;
        }
        
        .message-video {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            transform: translate(-50%, -50%);
            z-index: 0;
            object-fit: cover;
            opacity: 1;
            transition: opacity 1s ease-in-out;
            display: block !important;
        }
        
        .message-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, 
                rgba(26, 58, 79, 0.7) 0%, 
                rgba(185, 141, 74, 0.6) 100%);
            z-index: 1;
        }
        
        .message-section .container {
            position: relative;
            z-index: 2;
        }
        
        .message-section h2 {
            color: #fff;
        }
        
        .handwriting-image {
            width: 100%; 
            max-width: 400px;
            height: auto;
            border: 1px solid #D3C9BC;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 24px;
        }
        
        .signature { 
            text-align: right; 
            margin-top: 24px; 
        }

        /* --- 3つのお約束セクション --- */
        .promise-section { 
            background-color: #fff; 
        }
        
        .promise-item { 
            text-align: center; 
            margin-bottom: 60px; 
        }
        
        .promise-item:last-child { 
            margin-bottom: 0; 
        }
        
        .promise-item img { 
            width: 100%; 
            border-radius: 8px; 
            margin-bottom: 24px; 
        }
        
        .promise-item h3 { 
            font-size: 1.8rem; 
            margin-bottom: 16px; 
        }

        /* --- アクションセクション --- */
        .action-section { 
            background-color: #fff; 
            text-align: center; 
        }
        
        .action-section .container { 
            padding: 0 24px 40px; 
        }
        
        .action-section .lead-text { 
            margin: -20px auto 40px; 
        }
        
        .action-section .cta-button {
            display: inline-block; 
            background-color: var(--color-accent);
            color: #fff; 
            text-decoration: none; 
            text-align: center;
            padding: 20px; 
            font-size: 1.2rem; 
            font-weight: 700;
            border-radius: 8px; 
            width: 100%; 
            max-width: 400px;
            box-sizing: border-box;
        }
        
        .action-section .tel-area { 
            margin-top: 32px; 
        }
        
        .action-section .tel-area p { 
            margin: 0 0 8px 0; 
            font-size: 0.9rem; 
        }
        
        .action-section .tel-area a {
            color: var(--color-primary); 
            font-size: 1.8rem; 
            font-weight: 700;
            text-decoration: none;
        }

        /* --- フローティングCTA --- */
        .floating-cta {
            position: fixed; 
            bottom: 0; 
            left: 0; 
            right: 0;
            background: #fff; 
            padding: 16px 24px;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            transform: translateY(100%);
            animation: slideInUp 0.5s 2s ease-out forwards;
        }
        
        .floating-cta .cta-button {
            width: 100%; 
            display: block; 
            background-color: var(--color-accent);
            color: #fff; 
            text-decoration: none; 
            text-align: center;
            padding: 18px; 
            font-size: 1.1rem; 
            font-weight: 700;
            border-radius: 8px; 
            box-sizing: border-box;
        }
        
        .floating-cta .tel-link {
            text-align: center; 
            margin-top: 12px; 
            font-size: 0.9rem;
        }
        
        .floating-cta .tel-link a {
            color: var(--color-primary); 
            font-weight: 700; 
            text-decoration: none;
        }

        /* --- アニメーション --- */
        @keyframes fadeIn { 
            from { opacity: 0; } 
            to { opacity: 1; } 
        }
        
        @keyframes slideUp { 
            from { 
                opacity: 0; 
                transform: translateY(30px); 
            } 
            to { 
                opacity: 1; 
                transform: translateY(0); 
            } 
        }
        
        @keyframes slideInUp { 
            from { transform: translateY(100%); } 
            to { transform: translateY(0); } 
        }

        /* --- 文字折り返し制御 --- */
        .text-balance {
            text-wrap: balance;
        }
        
        .text-pretty {
            text-wrap: pretty;
        }
        
        @supports not (text-wrap: balance) {
            .text-balance,
            .text-pretty {
                max-width: 65ch;
                margin-left: auto;
                margin-right: auto;
            }
        }

        /* タブレット対応 */
        @media (max-width: 1024px) {
            :root {
                --container-padding: 20px;
            }
            
            .hero {
                height: 90vh;
            }
            
            .hero-title {
                font-size: clamp(1.75rem, 4vw + 0.5rem, 3rem);
            }
            
            .hero-cta-group {
                flex-direction: column;
                max-width: 300px;
                margin: var(--spacing-xl) auto 0;
            }
            
            .hero-cta {
                width: 100%;
            }
        }
        
        /* モバイル対応 */
        @media (max-width: 768px) {
            .header {
                padding: 12px 16px;
            }
            
            .header-logo {
                font-size: clamp(0.9rem, 4vw, 1.1rem);
                max-width: 50%;
            }
            
            .header-cta a {
                padding: 6px 12px;
                font-size: clamp(0.7rem, 3vw, 0.8rem);
                border-radius: 15px;
            }
            
            .hero {
                height: 80vh;
                padding: 0 20px;
                padding-top: 60px; /* ヘッダー分の余白追加 */
            }
            
            .hero-title {
                font-size: 2.2rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .form-container {
                margin: 0 20px;
                padding: 30px 20px;
            }
            
            .form-benefits {
                flex-direction: column;
                align-items: center;
            }

            /* モバイルでの調整 */
            :root {
                --container-padding: 16px;
            }
            
            .hero-title {
                font-size: clamp(1.5rem, 5vw, 2.2rem);
            }
            
            .stat-item {
                min-width: 85px;
            }
            
            .benefit-item {
                flex: 1 1 100%;
                justify-content: center;
            }

            .action-section .container { 
                padding: 0 16px 40px; 
            }
            
            .action-section .cta-button { 
                font-size: 1rem; 
                padding: 16px 20px;
                margin: 0 auto;
            }
            
            .floating-cta { 
                padding: 12px 16px; 
            }
            
            .floating-cta .cta-button { 
                font-size: 1rem; 
                padding: 14px 16px;
            }
            
            /* 顧客価値セクションのレスポンシブ */
            .value-cards {
                grid-template-columns: 1fr;
                gap: var(--spacing-sm);
            }
            
            .value-card {
                padding: var(--spacing-sm);
            }
            
            .card-icon {
                font-size: 2.5rem;
            }
            
            .value-card h3 {
                font-size: 1.1rem;
            }
            
            .testimonial-grid {
                grid-template-columns: 1fr;
                gap: var(--spacing-sm);
            }
            
            .testimonial-card {
                padding: var(--spacing-sm);
            }
            
            .testimonial-author {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--spacing-xs);
            }
            
            .section-cta {
                padding: var(--spacing-sm);
            }
            
            .cta-subtitle {
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .header {
                padding: 10px 12px;
            }
            
            .header-logo {
                font-size: clamp(0.8rem, 5vw, 1rem);
                max-width: 45%;
            }
            
            .header-cta a {
                padding: 5px 10px;
                font-size: clamp(0.6rem, 3.5vw, 0.75rem);
                border-radius: 12px;
            }
            
            .hero {
                padding-top: 50px; /* さらに小さなヘッダー分の余白 */
            }
            
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }

            /* 小画面での調整 */
            .hero {
                min-height: 600px;
            }
            
            .hero-cta-group {
                width: 100%;
                padding: 0 var(--spacing-sm);
            }
            
            .form-container {
                margin: 0;
                border-radius: 0;
                box-shadow: none;
            }

            .action-section .container { 
                padding: 0 12px 40px; 
            }
            
            .action-section .cta-button { 
                font-size: 0.9rem; 
                padding: 14px 16px;
            }
            
            .floating-cta { 
                padding: 10px 12px; 
            }
            
            .floating-cta .cta-button { 
                font-size: 0.9rem; 
                padding: 12px 14px;
            }
            
            /* 小画面での顧客価値セクション */
            .value-card {
                padding: 1rem;
            }
            
            .card-icon {
                font-size: 2rem;
            }
            
            .value-card h3 {
                font-size: 1rem;
            }
            
            .value-card p {
                font-size: 0.9rem;
            }
            
            .card-stats {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.25rem;
            }
            
            .testimonial-card {
                padding: 1rem;
            }
            
            .testimonial-content p {
                font-size: 0.9rem;
            }
            
            .author-name {
                font-size: 0.8rem;
            }
            
            .author-case {
                font-size: 0.7rem;
            }
        }
    </style>
</head>

<body <?php body_class(); ?>>
    <!-- ヘッダー -->
    <header class="header">
        <a href="<?php echo home_url(); ?>" class="header-logo">
            <?php bloginfo('name'); ?>
        </a>
        <?php CTAManager::render_header_cta(); ?>
        <nav class="header-nav" style="display: none;">
            <a href="<?php echo home_url('/company/'); ?>">会社概要</a>
            <a href="<?php echo home_url('/privacy/'); ?>">プライバシーポリシー</a>
            <a href="<?php echo home_url('/terms/'); ?>">利用規約</a>
        </nav>
    </header>

    <!-- ヒーローセクション -->
    <section class="hero">
        <video class="hero-video" autoplay muted loop playsinline preload="metadata" 
               poster="<?php echo get_template_directory_uri(); ?>/images/hero-bg.jpg">
            <source src="<?php echo get_template_directory_uri(); ?>/videos/日本上空ドローン映像提供.mp4" type="video/mp4">
            <source src="<?php echo get_template_directory_uri(); ?>/videos/video-1750840581181.mp4" type="video/mp4">
            <source src="<?php echo get_template_directory_uri(); ?>/videos/Generated_File_June_24_2025_-_11_03PM.mp4" type="video/mp4">
            <!-- 動画が対応していない場合のフォールバック -->
            お使いのブラウザは動画をサポートしていません。
        </video>
        <div class="hero-content">
            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number">2,800万円</span>
                    <span class="stat-label">平均査定額</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">97%</span>
                    <span class="stat-label">満足度</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">1,250件</span>
                    <span class="stat-label">査定実績</span>
                </div>
            </div>
            
            <h1 class="hero-title">
                住み慣れた我が家で、<span class="highlight">安心の老後資金を確保</span>
            </h1>
            
            <div class="hero-benefits">
                <div class="benefit-item">
                    <i class="fas fa-home"></i>
                    <span>今の家にそのまま住める</span>
                </div>
                <div class="benefit-item">
                    <i class="fas fa-yen-sign"></i>
                    <span>まとまった資金が手に入る</span>
                </div>
                <div class="benefit-item">
                    <i class="fas fa-shield-alt"></i>
                    <span>営業電話は一切なし</span>
                </div>
            </div>
            
            <div class="hero-cta-group">
                <a href="#super-simple-form" class="hero-cta primary">
                    <i class="fas fa-calculator"></i>
                    10秒で概算査定
                </a>
                <a href="tel:050-5810-5875" class="hero-cta secondary">
                    <i class="fas fa-phone"></i>
                    電話で相談
                </a>
            </div>
        </div>
        <div class="scroll-down">
            まずは概算をチェック
            <div class="arrow"></div>
        </div>
    </section>

    <script>
    // 動画の読み込み監視
    document.addEventListener('DOMContentLoaded', function() {
        const heroVideo = document.querySelector('.hero-video');
        const messageVideo = document.querySelector('.message-video');
        const finalVideo = document.querySelector('.final-message-video');
        
        // 動画処理の共通関数
        function setupVideo(video, name) {
            if (!video) {
                console.log(`${name}動画要素が見つかりません`);
                return;
            }
            
            console.log(`${name}動画を設定中...`);
            console.log(`${name}動画パス:`, video.src || 'source要素から取得');
            
            // 強制的に動画を表示
            video.style.display = 'block';
            video.style.opacity = '1';
            
            // 動画読み込みエラーハンドリング
            video.addEventListener('error', function(e) {
                console.error(`${name}動画読み込みエラー:`, e);
                const sources = video.querySelectorAll('source');
                sources.forEach((source, index) => {
                    console.log(`${name}動画ソース${index + 1}:`, source.src);
                });
                video.style.display = 'none';
            });
            
            // 動画が読み込まれた場合の処理
            video.addEventListener('loadeddata', function() {
                console.log(`${name}動画読み込み成功`);
                video.style.opacity = '1';
            });
            
            // 動画が再生可能になった場合の処理
            video.addEventListener('canplay', function() {
                console.log(`${name}動画再生準備完了`);
                video.play().catch(function(error) {
                    console.log(`${name}動画自動再生エラー:`, error);
                });
            });
            
            // 動画ソースのチェック
            const sources = video.querySelectorAll('source');
            sources.forEach((source, index) => {
                console.log(`${name}動画ソース${index + 1}:`, source.src);
            });
            
            // 強制的に再生を試行
            setTimeout(function() {
                if (video.paused) {
                    video.play().catch(function(error) {
                        console.log(`${name}動画手動再生エラー:`, error);
                    });
                }
            }, 500);
        }
        
        // 各動画を設定
        setupVideo(heroVideo, 'ヒーロー');
        setupVideo(messageVideo, '私たちの想い');
        setupVideo(finalVideo, '最終メッセージ');
    });
    </script>

    <!-- マンガ教育セクション -->
    <section class="manga-section">
        <div class="container">
            <h2 class="section-title">1分でわかる リースバックって、なあに？</h2>
            <div class="manga-box">
                <div class="manga-chat"><div class="icon">🤔</div><div class="bubble"><p>家に住み続けたい…でも、将来のためのお金も必要じゃ…。どうしたものか…</p></div></div>
                <div class="manga-chat right"><div class="bubble"><p>そんなお悩みに、<strong>「リースバック」</strong>という方法があるんですよ。</p></div><div class="icon">💡</div></div>
                <div class="manga-chat"><div class="icon">🤔</div><div class="bubble"><p>リース…バック…？</p></div></div>
                <div class="manga-chat right"><div class="bubble"><p>はい。お客様の今の家を、私たちが一度買い取らせていただき、<strong>まとまったお金</strong>をお渡しします。</p></div><div class="icon">💡</div></div>
                <div class="manga-chat right"><div class="bubble"><p>その後は、私たちに<strong>毎月の家賃</strong>をお支払いいただくことで、今の家に<strong>そのまま住み続けて</strong>いただけるんです。</p></div><div class="icon">💡</div></div>
                <div class="manga-chat"><div class="icon">😮</div><div class="bubble"><p>まあ！家に住み続けられるのに、お金が手に入るのか！</p></div></div>
            </div>
            <div class="manga-summary">つまり…<br>「住み慣れた家はそのまま」で<br>「まとまった資金を得られる」仕組みです。</div>
        </div>
    </section>

    <!-- AI査定フォーム（最適位置） -->
    <section id="super-simple-form" class="assessment-form">
        <div class="container">
            <?php include get_template_directory() . '/templates/partials/super-simple-form.php'; ?>
        </div>
    </section>

    <!-- 統合ストーリー・顧客価値セクション -->
    <section class="customer-value-section">
        <div class="container">
            <h2 class="section-title">リースバックで叶える、3つの安心</h2>
            
            <div class="value-cards">
                <div class="value-card">
                    <div class="card-icon">👴</div>
                    <h3>穏やかな老後を送るための、資金という安心</h3>
                    <p>住み慣れた家に住み続けながら、まとまった資金を手にできます。老後の生活費や医療費の心配から解放されます。</p>
                    <div class="card-stats">
                        <span class="stat-label">平均調達額</span>
                        <span class="stat-value">1,200万円</span>
                    </div>
                </div>
                
                <div class="value-card">
                    <div class="card-icon">🏢</div>
                    <h3>事業を守り、未来へ繋ぐための、賢い資金調達</h3>
                    <p>事業の運転資金や設備投資に必要な資金を、不動産を活用して調達。事業継続と成長を支援します。</p>
                    <div class="card-stats">
                        <span class="stat-label">最短期間</span>
                        <span class="stat-value">2週間</span>
                    </div>
                </div>
                
                <div class="value-card">
                    <div class="card-icon">👨‍👩‍👧‍👦</div>
                    <h3>子供たちへ、負担ではなく円満な資産の引継ぎを</h3>
                    <p>相続時の負担を軽減し、家族間のトラブルを防ぎます。将来の買い戻しオプションで柔軟な相続対策も可能です。</p>
                    <div class="card-stats">
                        <span class="stat-label">満足度</span>
                        <span class="stat-value">98%</span>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-section">
                <h3>お客様の声</h3>
                <div class="testimonial-grid">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <p>「住み慣れた家に住み続けながら、老後資金を確保できました。スタッフの対応も親切で安心してお任せできました。」</p>
                        </div>
                        <div class="testimonial-author">
                            <span class="author-name">田中様（70代・東京都）</span>
                            <span class="author-case">老後資金確保</span>
                        </div>
                    </div>
                    
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <p>「事業拡大のための資金調達がスムーズに進みました。銀行融資より柔軟で、事業を継続しながら成長できています。」</p>
                        </div>
                        <div class="testimonial-author">
                            <span class="author-name">佐藤様（50代・神奈川県）</span>
                            <span class="author-case">事業資金調達</span>
                        </div>
                    </div>
                    
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <p>「相続対策で利用しました。子供たちに負担をかけることなく、円満に資産を整理できて本当に良かったです。」</p>
                        </div>
                        <div class="testimonial-author">
                            <span class="author-name">鈴木様（60代・千葉県）</span>
                            <span class="author-case">相続対策</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="section-cta">
                <p class="cta-subtitle">あなたの状況に合わせた最適なプランをご提案します</p>
                <?php CTAManager::render_cta_group(['primary', 'line']); ?>
            </div>
        </div>
    </section>

    <!-- 知識セクション -->
    <section class="knowledge-section">
        <div class="container">
            <h2 class="section-title">知っていただきたい、大切なこと。</h2>
            <div class="merit-box">
                <h3>✅ リースバックが叶えること</h3>
                <ul><li>今の家に、そのまま住み続けられる</li><li>まとまった資金を一括で受け取れる</li><li>家の売却を近所に知られずに済む</li><li>固定資産税などの維持費が不要になる</li><li>将来、家を買い戻せる可能性もある</li></ul>
            </div>
            <div class="demerit-box">
                <h3>⚠️ ご注意いただきたいこと</h3>
                <ul><li>所有権がなくなるため、売却価格は相場より低めになる</li><li>賃貸契約となるため、毎月の家賃が発生する</li><li>買い戻し価格は、売却価格より高くなる場合が多い</li></ul>
            </div>
            <div class="sincere-promise">
                <h3>だからこそ、私たちがいます。</h3>
                <p>私たちは、お客様にとって本当にリースバックが最良の選択なのか、専門家の視点から、誠実にお伝えすることをお約束します。</p>
            </div>
        </div>
    </section>

    <!-- 代表メッセージセクション -->
    <section class="message-section">
        <video class="message-video" autoplay muted loop playsinline preload="metadata">
            <source src="<?php echo get_template_directory_uri(); ?>/videos/video-1750840581181.mp4" type="video/mp4">
            <source src="<?php echo get_template_directory_uri(); ?>/videos/Generated_File_June_24_2025_-_11_03PM.mp4" type="video/mp4">
            <source src="<?php echo get_template_directory_uri(); ?>/videos/日本上空ドローン映像提供.mp4" type="video/mp4">
            お使いのブラウザは動画をサポートしていません。
        </video>
        <div class="container">
            <h2 class="section-title">私たちの想い</h2>
            <p style="text-align: left;">お客様の「家」は、単なる資産ではありません。<br>そこには、計り知れないほどの時間と、思い出と、人生そのものが刻まれています。<br><br>私たちは、その価値に深い敬意を払い、お客様一人ひとりの物語に、真摯に寄り添うことをお約束いたします。<br><br>リースバックという選択が、お客様の未来をより豊かに、より安心できるものにするための一助となれば、これに勝る喜びはありません。</p>
            <p class="signature">リースバック住み続け隊<br>代表取締役 黒江 貴裕</p>
        </div>
    </section>

    <!-- 3つのお約束セクション -->
    <section class="promise-section">
        <div class="container">
            <h2 class="section-title">リースバック住み続け隊 3つのお約束</h2>
            <div class="promise-item"><img src="<?php echo get_template_directory_uri(); ?>/images/光が差し込むイメージ.avif" alt="光が差し込むイメージ"><h3>1. 最高の条件を、追求します</h3><p>私たちは、複数の提携企業の中から、お客様の家の価値を最大限に評価し、最も有利な条件をご提案できる会社を見つけ出します。</p></div>
            <div class="promise-item"><img src="https://images.unsplash.com/photo-1554224155-1696413565d3?auto=format&fit=crop&w=870" alt="真摯に向き合う手元のイメージ"><h3>2. 専門家として、誠実です</h3><p>数字の裏にあるお客様の想いを理解し、メリットだけでなくご注意いただきたい点も全てお伝えした上で、最適なプランを設計します。</p></div>
            <div class="promise-item"><img src="<?php echo get_template_directory_uri(); ?>/images/家の土台のイメージ.avif" alt="家の土台のイメージ"><h3>3. 揺るぎない安心を、お約束します</h3><p>しつこい営業や不要なご連絡は一切行いません。お客様ご自身のペースで、じっくりとご決断いただける環境をお守りします。</p></div>
        </div>
    </section>

    <!-- 最終メッセージセクション -->
    <section class="final-message-section">
        <video class="final-message-video" autoplay muted loop playsinline preload="metadata"
               poster="<?php echo get_template_directory_uri(); ?>/images/最終メッセージ.avif">
            <source src="<?php echo get_template_directory_uri(); ?>/videos/Generated_File_June_24_2025_-_11_03PM.mp4" type="video/mp4">
            <source src="<?php echo get_template_directory_uri(); ?>/videos/video-1750840581181.mp4" type="video/mp4">
            <source src="<?php echo get_template_directory_uri(); ?>/videos/日本上空ドローン映像提供.mp4" type="video/mp4">
            お使いのブラウザは動画をサポートしていません。
        </video>
        <div class="final-message-content">
            <h2>あなたの家の物語を、未来へ。</h2>
            <p>愛着ある、この家と、これからも。<br>その想いを、私たちはお守りします。</p>
        </div>
    </section>

    <!-- アクションセクション -->
    <section class="action-section" id="contact">
        <div class="container">
            <h2 class="section-title">最初の一歩</h2>
            <p class="lead-text">お客様のペースを何よりも大切にします。しつこい営業は一切行わないことを、固くお約束いたします。</p>
            <a href="#assessment-form" class="cta-button">無料で相談・査定を依頼する</a>
            <div class="tel-area">
                <p>お電話でのご相談をご希望の方へ</p>
                <a href="tel:050-5810-5875">📞 050-5810-5875</a>
                <p style="font-size:0.8rem; margin-top:8px;">（受付時間：9:00〜19:00 年中無休）</p>
            </div>
        </div>
    </section>

    <!-- 信頼性インジケーター -->
    <?php include get_template_directory() . '/templates/partials/trust-indicators.php'; ?>


    <!-- 従来のフォーム（A/Bテスト用に残す） -->
    <section id="assessment-form" class="assessment-form">
        <div class="container">
            <div class="form-container">
                <header class="form-header">
                    <h2 class="form-title">60秒で概算査定額をチェック</h2>
                    <p class="form-subtitle">郵便番号と物件種別だけで OK！</p>
                </header>

                <div class="form-body">
                    <form action="<?php echo home_url('/lead-step2/'); ?>" method="get" class="js-simple-form">
                        <!-- 郵便番号 -->
                        <div class="form-group">
                            <label for="zip">郵便番号 <span class="req">必須</span></label>
                            <input type="text" id="zip" name="zip"
                                   placeholder="例）1234567"
                                   maxlength="7" pattern="\d{7}" required>
                        </div>

                        <!-- 物件種別 -->
                        <div class="form-group">
                            <label for="property-type">物件種別 <span class="req">必須</span></label>
                            <select id="property-type" name="property-type" required>
                                <option value="" hidden>選択してください</option>
                                <option value="mansion-unit">マンション（区分）</option>
                                <option value="house">一戸建て</option>
                                <option value="land">土地</option>
                                <option value="mansion-building">マンション一棟</option>
                                <option value="building">ビル一棟</option>
                                <option value="apartment-building">アパート一棟</option>
                                <option value="other">その他</option>
                            </select>
                        </div>

                        <!-- 送信ボタン -->
                        <button type="submit" class="submit-button">
                            無料査定スタート
                        </button>

                        <!-- 後続ページ識別（任意） -->
                        <input type="hidden" name="step" value="1">
                    </form>

                    <!-- ベネフィット表示 -->
                    <ul class="form-benefits">
                        <li><i class="fas fa-check-circle"></i> 完全無料・匿名査定</li>
                        <li><i class="fas fa-lock"></i> SSL暗号化通信で安心</li>
                        <li><i class="fas fa-bolt"></i> 最大10社に一括依頼</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- フローティングCTA -->
    <?php CTAManager::render_floating_cta(); ?>

    <script>
        // スムーススクロールとフォーム処理
        document.addEventListener('DOMContentLoaded', function() {
            // セクション表示アニメーション
            const sections = document.querySelectorAll('section');
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -100px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            sections.forEach(section => {
                observer.observe(section);
            });

            // フォーム送信処理
            const simpleForm = document.querySelector('.js-simple-form');
            if (simpleForm) {
                simpleForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const zip = document.getElementById('zip').value.trim();
                    const propertyType = document.getElementById('property-type').value;
                    
                    if (!zip || !propertyType) {
                        alert('郵便番号と物件種別を入力してください。');
                        return;
                    }
                    
                    if (zip.length !== 7 || !/^\d{7}$/.test(zip)) {
                        alert('郵便番号は7桁の数字で入力してください。');
                        return;
                    }
                    
                    // WordPress固定ページに遷移
                    const url = `<?php echo home_url('/lead-step2/'); ?>?zip=${zip}&property-type=${propertyType}`;
                    window.location.href = url;
                });
            }
        });
    </script>

    <?php wp_footer(); ?>
</body>
</html>
