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
    <!-- CSS読み込み -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/main.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/pages/animations.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/pages/header.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/pages/sections.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/pages/landing.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/pages/footer.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/pages/floating-cta.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/cta-system.css">
    
    <style>

        /* 重複削除済み - 外部CSSファイルに移動 */
        
        /* 削除 - sections.cssで対応済み */
        
        .special-section-title::after {
            width: 120px;
            height: 6px;
            background: linear-gradient(90deg, 
                transparent, 
                var(--color-accent), 
                var(--color-primary), 
                var(--color-accent), 
                transparent);
            box-shadow: 0 4px 12px rgba(185, 141, 74, 0.4);
        }
        
        .special-section-title::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 200px;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(185, 141, 74, 0.3), transparent);
            border-radius: 2px;
        }
        
        /* --- ヒーローセクション（改良版） --- */
        .hero {
            height: 100vh;
            min-height: 600px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #fff;
            position: relative;
            overflow: hidden;
            padding-top: 80px; /* ヘッダー分の余白を調整 */
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
                url('<?php echo get_template_directory_uri(); ?>/images/家の土台のイメージ.avif') center/cover;
        }
        
        /* モバイルでも動画を表示 */
        @media (max-width: 768px) {
            .hero-video {
                display: block;
                object-fit: cover;
                width: 100%;
                height: 100%;
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
                rgba(26, 58, 79, 0.85) 0%, 
                rgba(185, 141, 74, 0.75) 100%);
            z-index: 2;
        }

        .hero-content {
            position: relative;
            z-index: 3;
            max-width: 900px;
            padding: 0 20px;
            animation: fadeIn 1.2s ease-out forwards;
        }

        .hero-title {
            font-family: var(--font-heading);
            font-size: clamp(2rem, 4.5vw + 0.5rem, 4rem);
            font-weight: 900;
            margin-bottom: var(--spacing-lg);
            line-height: 1.3;
            animation: slideUp 0.8s 0.3s ease-out forwards;
            opacity: 0;
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
            text-wrap: balance;
            text-shadow: 
                0 4px 16px rgba(0, 0, 0, 0.7),
                0 2px 8px rgba(0, 0, 0, 0.9),
                0 1px 4px rgba(0, 0, 0, 0.8);
            letter-spacing: -0.02em;
        }
        
        .hero-title .highlight {
            display: inline-block;
            background: linear-gradient(120deg, 
                var(--color-accent) 0%, 
                #D4A574 50%, 
                #FFD700 100%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 900;
            text-shadow: none;
            position: relative;
            z-index: 1;
        }
        
        .hero-title .highlight::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(120deg, 
                rgba(185, 141, 74, 0.2) 0%, 
                rgba(255, 215, 0, 0.1) 100%);
            filter: blur(8px);
            z-index: -1;
            border-radius: 8px;
        }

        .hero-stats {
            display: flex;
            justify-content: center;
            gap: clamp(1rem, 3vw, 2.5rem);
            margin-bottom: var(--spacing-xl);
            animation: fadeIn 0.8s 0.5s ease-out forwards;
            opacity: 0;
            flex-wrap: wrap;
        }
        
        .stat-item {
            text-align: center;
            background: rgba(255, 255, 255, 0.2);
            padding: clamp(0.75rem, 2vw, 1.25rem) clamp(1rem, 2vw, 1.5rem);
            border-radius: 12px;
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.35);
            min-width: 100px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        }
        
        .stat-number {
            display: block;
            font-size: clamp(1.4rem, 3vw, 2.2rem);
            font-weight: 900;
            color: #fff;
            margin-bottom: 0.25rem;
            text-shadow: 
                0 3px 8px rgba(0, 0, 0, 0.5),
                0 1px 4px rgba(0, 0, 0, 0.7);
            letter-spacing: -0.02em;
        }
        
        .stat-label {
            font-size: clamp(0.7rem, 1.5vw, 0.9rem);
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
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
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 24px rgba(185, 141, 74, 0.4);
            animation: fadeInUp 0.8s 0.9s ease-out forwards;
            opacity: 0;
            position: relative;
            overflow: hidden;
        }
        
        /* PC表示でのセカンダリCTA */
        @media (min-width: 769px) {
            .hero-cta.secondary {
                background: linear-gradient(135deg, #ffffff, #f8f8f8);
                color: var(--color-primary);
                border: 2px solid var(--color-accent);
                box-shadow: 0 6px 20px rgba(185, 141, 74, 0.3);
                font-weight: 700;
            }
            
            .hero-cta.secondary:hover {
                background: linear-gradient(135deg, #f8f8f8, #ffffff);
                transform: translateY(-4px);
                box-shadow: 0 10px 30px rgba(185, 141, 74, 0.4);
                color: var(--color-primary);
                border-color: #D4A574;
            }
        }
        
        .hero-cta::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .hero-cta:hover::before {
            width: 300px;
            height: 300px;
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
            animation: slideUp 0.8s 0.7s ease-out forwards;
            opacity: 0;
        }
        
        .benefit-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(255, 255, 255, 0.25);
            padding: clamp(0.75rem, 1.5vw, 1rem) clamp(1rem, 2vw, 1.5rem);
            border-radius: 30px;
            backdrop-filter: blur(25px);
            font-size: clamp(0.9rem, 1.5vw, 1rem);
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.35);
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }
        
        .benefit-item:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.25);
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
            animation: fadeInUp 0.8s 0.9s ease-out forwards;
            opacity: 0;
        }
        
        /* アニメーション完了後の状態を保証 */
        .hero-cta-group > * {
            opacity: 1 !important;
        }
        
        /* スクロールダウンインジケーター */
        .scroll-down {
            position: absolute;
            bottom: 100px; /* CTAと被らないように位置を上げる */
            left: 50%;
            transform: translateX(-50%);
            z-index: 3;
            color: #fff;
            text-align: center;
            font-size: 0.8rem;
            animation: fadeIn 1.5s 1.2s ease-out forwards;
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
            background: linear-gradient(135deg, 
                #f8f9fa 0%, 
                #fff 25%, 
                #f4f2ef 50%, 
                #fff 75%, 
                #f8f9fa 100%);
            padding: clamp(4rem, 10vw, 6rem) 0;
            position: relative;
            overflow: hidden;
        }
        
        .assessment-form::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 50% 50%, 
                rgba(185, 141, 74, 0.05) 0%, 
                transparent 60%);
            pointer-events: none;
        }
        
        .assessment-form::after {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, transparent, var(--color-accent), transparent);
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(185, 141, 74, 0.3);
        }

        .form-container {
            max-width: 650px;
            margin: 0 auto;
            padding: clamp(2rem, 5vw, 3rem);
            background: #f8f9fa;
            border-radius: 24px;
            box-shadow: 
                0 15px 50px rgba(0,0,0,0.12),
                0 5px 20px rgba(185, 141, 74, 0.08);
            border: 2px solid rgba(185, 141, 74, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, 
                var(--color-primary), 
                var(--color-accent), 
                var(--color-primary));
            border-radius: 24px 24px 0 0;
        }
        
        .form-container::after {
            content: '';
            position: absolute;
            top: 10px;
            right: 10px;
            width: 40px;
            height: 40px;
            background: radial-gradient(circle, 
                rgba(185, 141, 74, 0.1) 0%, 
                transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .form-title {
            font-family: var(--font-heading);
            font-size: clamp(1.8rem, 4vw, 2.5rem);
            font-weight: 800;
            background: linear-gradient(135deg, var(--color-primary), var(--color-accent));
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 16px;
            text-align: center;
            line-height: 1.2;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
            padding: clamp(0.875rem, 2vw, 1.125rem);
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            box-sizing: border-box;
            background: #fff;
            -webkit-appearance: none;
            appearance: none;
        }
        
        .form-group input:hover,
        .form-group select:hover {
            border-color: #ccc;
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
            box-shadow: 0 0 0 4px rgba(185, 141, 74, 0.1);
        }

        .submit-button {
            width: 100%;
            background: #fff;
            color: var(--color-primary);
            padding: clamp(1.125rem, 2.5vw, 1.375rem);
            border: 2px solid var(--color-accent);
            border-radius: 50px;
            font-size: clamp(1.05rem, 2vw, 1.25rem);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: var(--spacing-lg);
            min-height: 56px;
            position: relative;
            overflow: hidden;
        }
        
        .submit-button::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .submit-button:active::before {
            width: 300px;
            height: 300px;
        }

        .submit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(185, 141, 74, 0.4);
            background: #f8f9fa;
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
            background: linear-gradient(180deg, 
                rgba(26, 58, 79, 0.5) 0%, 
                rgba(26, 58, 79, 0.7) 100%); 
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
            background: linear-gradient(180deg, #f8f9fa 0%, #fff 50%, #f8f9fa 100%);
        }
        
        .manga-box { 
            border: 2px solid #EAE2D9; 
            border-radius: 16px; 
            padding: clamp(1.5rem, 4vw, 2rem); 
            background: #fff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
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
            border-radius: 16px;
            padding: clamp(1rem, 2vw, 1.25rem); 
            position: relative;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            line-height: 1.6;
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
            padding: clamp(3rem, 8vw, 5rem) 0;
            position: relative;
        }
        
        .customer-value-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60%;
            max-width: 400px;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--color-accent), transparent);
            border-radius: 3px;
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
            justify-content: flex-end;
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
            background: linear-gradient(180deg, #fff 0%, #f4f2ef 100%);
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
            padding: 40px;
            background: linear-gradient(135deg, var(--color-accent), #D4A574);
            border-radius: 16px;
            margin-top: 40px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(185, 141, 74, 0.3);
            animation: pulseGlow 3s ease-in-out infinite;
        }
        
        @keyframes pulseGlow {
            0%, 100% {
                box-shadow: 0 8px 32px rgba(185, 141, 74, 0.3);
            }
            50% {
                box-shadow: 0 12px 48px rgba(185, 141, 74, 0.5);
            }
        }
        
        .sincere-promise::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, 
                transparent 30%, 
                rgba(255, 255, 255, 0.1) 50%, 
                transparent 70%);
            animation: shine 3s infinite;
        }
        
        .sincere-promise h3 {
            color: #fff;
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 1;
        }
        
        .sincere-promise p { 
            margin: 0;
            color: #fff;
            font-size: clamp(1rem, 2vw, 1.2rem);
            line-height: 1.8;
            font-weight: 500;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }
        
        /* レスポンシブで「す。」だけが残らないように調整 */
        @media (max-width: 480px) {
            .sincere-promise p {
                font-size: 0.95rem;
                padding: 0 10px;
            }
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
                rgba(26, 58, 79, 0.8) 0%, 
                rgba(185, 141, 74, 0.7) 100%);
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
            background: linear-gradient(180deg, #f4f2ef 0%, #fff 100%);
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
            max-width: 500px;
            margin: 0 auto;
            display: block;
            border-radius: 12px; 
            margin-top: 24px; 
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        .promise-item h3 { 
            font-size: 1.8rem; 
            margin-bottom: 16px; 
        }
        
        .promise-item p {
            margin-bottom: 0;
            line-height: 1.8;
        }

        /* --- アクションセクション --- */
        .action-section { 
            background: linear-gradient(180deg, #f8f9fa 0%, #fff 100%);
            text-align: center; 
            padding: clamp(3rem, 8vw, 5rem) 0;
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

        /* フローティングCTAを外部CSSファイルに移動済み */

        /* アニメーションを外部CSSファイルに移動済み */
        
        /* 文字折り返し制御 */
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
                padding-top: 100px;
            }
            
            .hero-title {
                font-size: clamp(1.75rem, 4vw + 0.5rem, 3rem);
            }
            
            .hero-cta-group {
                flex-direction: column;
                max-width: 300px;
                margin: var(--spacing-xl) auto 0;
            }
            
            .hero-cta-group {
                flex-direction: column;
                width: 100%;
                max-width: 300px;
                gap: clamp(0.5rem, 1.5vw, 0.75rem);
                margin-top: var(--spacing-md);
            }
            
            .hero-cta {
                width: 100%;
                padding: clamp(0.875rem, 2vw, 1rem) clamp(1.25rem, 2.5vw, 1.5rem);
                font-size: clamp(0.95rem, 2.2vw, 1.05rem);
                border-radius: 25px;
                min-height: 48px;
            }
            
            .hero-cta.primary {
                box-shadow: 0 6px 20px rgba(185, 141, 74, 0.5);
            }
            
            .hero-cta.secondary {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border: 2px solid rgba(185, 141, 74, 0.8);
                color: var(--color-primary);
                font-weight: 600;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            }
            
            .hero-cta.secondary:hover {
                background: rgba(255, 255, 255, 1);
                border-color: var(--color-accent);
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            }
        }
        
        /* タブレット対応 */
        @media (max-width: 1024px) {
            :root {
                --spacing-xs: 0.375rem;
                --spacing-sm: 0.75rem;
                --spacing-md: 1.25rem;
                --spacing-lg: 1.75rem;
                --spacing-xl: 2.25rem;
                --spacing-2xl: 3rem;
            }
            
            section {
                padding: clamp(2.5rem, 5vw, 3.5rem) 0;
            }
            
            .hero {
                min-height: 500px;
                max-height: 700px;
            }
            
            .hero-title {
                font-size: clamp(1.8rem, 4.5vw, 2.8rem);
                line-height: 1.3;
            }
            
            .hero-stats {
                gap: clamp(0.75rem, 2vw, 1.5rem);
            }
            
            h2.section-title {
                font-size: clamp(1.6rem, 3vw, 2.2rem);
                margin-bottom: var(--spacing-lg);
            }
            
            .value-cards {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .testimonial-grid {
                grid-template-columns: 1fr;
                gap: 1.25rem;
            }
        }
        
        /* モバイル対応 */
        @media (max-width: 768px) {
            body {
                font-size: 16px; /* モバイル用フォントサイズ */
                line-height: 1.6; /* 行間を狭く */
                padding-bottom: 85px; /* フローティングCTA分の余白 */
            }
            
            .header {
                padding: 16px 20px;
                background: rgba(26, 58, 79, 0.9);
            }
            
            .logo-img {
                height: 60px;
            }
            
            .logo-text {
                font-size: 17px;
            }
            
            .header-cta {
                right: 16px;
            }
            
            .header-cta a {
                padding: 8px 16px;
                font-size: 0.85rem;
                gap: 6px;
            }
            
            .header-cta i {
                font-size: 0.9rem;
            }
            
            .hero {
                height: calc(100vh - 60px); /* ヘッダーを考慮 */
                min-height: 450px;
                max-height: 600px; /* 最大高さを制限 */
                padding: 0 16px;
                padding-top: 60px; /* ヘッダー分の余白を減らす */
            }
            
            .hero-title {
                font-size: clamp(1.6rem, 4.5vw, 2.2rem);
                line-height: 1.25;
                margin-bottom: var(--spacing-sm);
            }
            
            .hero-subtitle {
                font-size: clamp(1rem, 3vw, 1.2rem);
            }
            
            .form-container {
                margin: 0 10px;
                padding: clamp(1.25rem, 3vw, 1.5rem) clamp(1rem, 2.5vw, 1.25rem);
                border-radius: 16px;
                box-shadow: 0 4px 16px rgba(0,0,0,0.05);
            }
            
            .form-header {
                margin-bottom: 1.5rem;
            }
            
            .form-title {
                font-size: clamp(1.3rem, 3.5vw, 1.6rem);
                margin-bottom: 0.25rem;
                line-height: 1.2;
            }
            
            .form-subtitle {
                font-size: clamp(0.9rem, 2vw, 1rem);
                line-height: 1.4;
            }
            
            .form-group {
                margin-bottom: var(--spacing-md);
            }
            
            .form-group label {
                font-size: clamp(0.85rem, 1.8vw, 0.95rem);
                margin-bottom: 4px;
                font-weight: 600;
            }
            
            .form-group input,
            .form-group select {
                font-size: 16px; /* iOSのズームを防ぐ */
                padding: clamp(0.75rem, 1.8vw, 0.875rem);
                border-radius: 10px;
            }
            
            .submit-button {
                font-size: clamp(0.95rem, 2.2vw, 1.05rem);
                padding: clamp(0.875rem, 2vw, 1rem);
                min-height: 48px;
                border-radius: 25px;
                margin-top: var(--spacing-md);
            }
            
            .form-benefits {
                flex-wrap: wrap;
                justify-content: center;
                gap: 8px;
                margin-top: 16px;
            }
            
            .form-benefits li {
                font-size: clamp(0.75rem, 1.8vw, 0.85rem);
                gap: 6px;
            }

            /* モバイルでの調整 - コンパクト化 */
            :root {
                --container-padding: 16px;
                --spacing-xs: 0.25rem;
                --spacing-sm: 0.5rem;
                --spacing-md: 1rem;
                --spacing-lg: 1.5rem;
                --spacing-xl: 2rem;
                --spacing-2xl: 2.5rem;
            }
            
            section {
                padding: clamp(2rem, 5vw, 3rem) 0;
            }
            
            /* セクション間の区切り線をモバイルでは非表示 */
            section:not(:last-child)::after {
                display: none;
            }
            
            h2.section-title {
                font-size: clamp(1.4rem, 3.5vw, 1.8rem);
                margin-bottom: var(--spacing-md);
                padding-bottom: 0.5rem;
                line-height: 1.3;
            }
            
            h2.section-title::after {
                width: 40px;
                height: 2px;
            }
            
            .hero-stats {
                flex-direction: row;
                width: 100%;
                justify-content: space-evenly;
                gap: clamp(0.5rem, 1.5vw, 0.75rem);
                margin-bottom: var(--spacing-sm);
            }
            
            .stat-item {
                min-width: 85px;
                padding: clamp(0.5rem, 1.5vw, 0.75rem) clamp(0.5rem, 1.5vw, 0.75rem);
                border-radius: 10px;
            }
            
            .stat-number {
                font-size: clamp(1.1rem, 3vw, 1.5rem);
                font-weight: 700;
            }
            
            .stat-label {
                font-size: clamp(0.7rem, 1.5vw, 0.85rem);
                line-height: 1.2;
            }
            
            .hero-benefits {
                gap: clamp(0.4rem, 1vw, 0.6rem);
                margin: var(--spacing-sm) 0;
            }
            
            .benefit-item {
                flex: 1 1 auto;
                justify-content: center;
                min-height: 38px;
                font-size: clamp(0.8rem, 1.8vw, 0.9rem);
                padding: 0.5rem 0.75rem;
                gap: 0.4rem;
            }
            
            .benefit-item i {
                font-size: 1em;
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
            
            /* フローティングCTAスタイルを外部CSSファイルに移動済み */
            
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
            body {
                font-size: 17px;
            }
            
            .header {
                padding: 14px 16px;
                background: rgba(26, 58, 79, 0.95);
            }
            
            .logo-img {
                height: 50px;
            }
            
            .logo-text {
                font-size: 15px;
            }
            
            .header-cta {
                display: flex; /* 小画面でも表示 */
                right: 10px;
            }
            
            .header-cta a {
                padding: 6px 12px;
                font-size: 0.8rem;
            }
            
            .hero {
                padding-top: 70px; /* 小画面用のヘッダー余白 */
                min-height: 500px;
            }
            
            .hero-title {
                font-size: clamp(1.6rem, 6vw, 2.2rem);
                line-height: 1.25;
            }
            
            .hero-subtitle {
                font-size: clamp(0.95rem, 3vw, 1.1rem);
            }

            /* スクロールダウンインジケーターの調整 */
            .scroll-down {
                display: none; /* モバイルでは非表示にする */
            }
            
            .scroll-down .arrow {
                height: 35px;
                margin-top: 8px;
            }
            
            /* 重複したスタイルを削除 */

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
            
            /* フローティングCTAスタイルを外部CSSファイルに移動済み */
            
            /* 小画面での顧客価値セクション */
            .value-cards {
                gap: 0.875rem;
            }
            
            .value-card {
                padding: 0.875rem;
                border-radius: 12px;
            }
            
            .card-icon {
                font-size: 1.75rem;
                margin-bottom: 0.5rem;
            }
            
            .value-card h3 {
                font-size: 0.95rem;
                margin-bottom: 0.5rem;
                line-height: 1.3;
            }
            
            .value-card p {
                font-size: 0.85rem;
                line-height: 1.5;
                margin-bottom: 0.75rem;
            }
            
            .card-stats {
                flex-direction: column;
                align-items: flex-end;
                gap: 0.125rem;
                margin-top: 0.5rem;
            }
            
            .stat-label,
            .stat-value {
                font-size: 0.75rem;
            }
            
            .testimonial-grid {
                gap: 0.875rem;
            }
            
            .testimonial-card {
                padding: 0.875rem;
                border-radius: 10px;
            }
            
            .testimonial-content p {
                font-size: 0.85rem;
                line-height: 1.5;
                margin-bottom: 0.75rem;
            }
            
            .testimonial-author {
                gap: 0.25rem;
            }
            
            .author-name {
                font-size: 0.75rem;
                line-height: 1.2;
            }
            
            .author-case {
                font-size: 0.65rem;
            }
        }

        /* フッター */
        /* フッタースタイルを外部CSSファイルに移動済み */
        
        @media (max-width: 768px) {
            .footer {
                padding: 40px 0 20px;
                margin-top: 60px;
            }
            
            .footer-content {
                margin-bottom: 30px;
            }
            
            .footer-links {
                flex-direction: column;
                gap: 15px;
                padding: 20px 0;
                align-items: center;
            }
            
            .footer-links a {
                text-align: center;
                padding: 5px 0;
            }
        }

        /* 🎯 動きと魅力的なアニメーション */
        
        /* フローティングアニメーション */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        /* パルスアニメーション */
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        /* グラデーション移動 */
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        /* 光の効果 */
        @keyframes shine {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        
        /* フェードイン上昇 */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* セクションタイトルにアニメーション追加 */
        h2.section-title {
            animation: fadeInUp 0.8s ease-out;
        }
        
        h2.section-title.special-section-title {
            background-size: 200% 200%;
            animation: fadeInUp 0.8s ease-out, gradientShift 3s ease-in-out infinite;
        }
        
        /* フォームコンテナに魅力的な動き */
        .form-container {
            transition: all 0.4s ease;
            animation: fadeInUp 1s ease-out;
        }
        
        .form-container:hover {
            transform: translateY(-8px);
            box-shadow: 
                0 20px 60px rgba(0,0,0,0.15),
                0 8px 25px rgba(185, 141, 74, 0.2);
        }
        
        /* 統計カードにフローティング効果 */
        .stat-item {
            animation: float 3s ease-in-out infinite;
            transition: transform 0.3s ease;
        }
        
        .stat-item:nth-child(1) { animation-delay: 0s; }
        .stat-item:nth-child(2) { animation-delay: 1s; }
        .stat-item:nth-child(3) { animation-delay: 2s; }
        
        .stat-item:hover {
            transform: translateY(-5px) scale(1.05);
        }
        
        /* CTAボタンに脈動効果 */
        .hero-cta.primary {
            animation: pulse 2s ease-in-out infinite;
            position: relative;
            overflow: hidden;
        }
        
        .hero-cta.primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            animation: shine 2s linear infinite;
        }
        
        /* 価値カードにホバー効果 */
        .value-card {
            transition: all 0.3s ease;
        }
        
        .value-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        
        .card-icon {
            transition: transform 0.3s ease;
        }
        
        .value-card:hover .card-icon {
            transform: scale(1.2);
        }
        
        /* お客様の声カードに波動効果 */
        .testimonial-card {
            transition: all 0.3s ease;
        }
        
        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.1);
        }
        
        /* ヘッダーCTAにホバー効果強化 */
        .header-cta a {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .header-cta a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s ease;
        }
        
        .header-cta a:hover::before {
            left: 100%;
        }
        
        /* フローティングCTAアニメーションを外部CSSファイルに移動済み */
        
        /* セクション表示時のアニメーション */
        section {
            opacity: 0;
            transform: translateY(50px);
            animation: fadeInUp 0.8s ease-out forwards;
        }
        
        section:nth-child(1) { animation-delay: 0.1s; }
        section:nth-child(2) { animation-delay: 0.2s; }
        section:nth-child(3) { animation-delay: 0.3s; }
        section:nth-child(4) { animation-delay: 0.4s; }
        
        /* スクロール時のパララックス効果（軽量版） */
        .hero {
            background-attachment: fixed;
        }
        
        /* アイコンに回転効果 */
        .trust-icon i {
            transition: transform 0.3s ease;
        }
        
        .trust-item:hover .trust-icon i {
            transform: scale(1.1);
        }
        
        /* 3つのお約束の画像にズーム効果 */
        .promise-item img {
            transition: transform 0.4s ease;
        }
        
        .promise-item:hover img {
            transform: scale(1.1);
        }
        
        /* フォーム入力フィールドにフォーカス効果 */
        .form-group input:focus,
        .form-group select:focus {
            transform: scale(1.02);
            transition: all 0.3s ease;
        }
        
        /* パフォーマンス最適化 */
        * {
            will-change: auto;
        }
        
        .form-container,
        .stat-item,
        .value-card,
        .hero-cta.primary {
            will-change: transform;
        }
    </style>
</head>

<body <?php body_class(); ?>>
    <!-- ヘッダー -->
    <header class="header">
        <a href="<?php echo home_url(); ?>" class="header-logo">
            <img src="<?php echo get_template_directory_uri(); ?>/images/logo-sumitsuzuke.png" alt="住み続け隊" class="logo-img">
            <span class="logo-text">リースバックの住み続け隊</span>
        </a>
        <div class="header-cta">
            <a href="#super-simple-form" onclick="CTAManager.trackClick('header_ai_diagnosis')">
                <i class="fas fa-search"></i> 簡易診断
            </a>
        </div>
        <nav class="header-nav" style="display: none;">
            <a href="<?php echo home_url('/company/'); ?>">会社概要</a>
            <a href="<?php echo home_url('/privacy/'); ?>">プライバシーポリシー</a>
            <a href="<?php echo home_url('/terms/'); ?>">利用規約</a>
        </nav>
    </header>

    <!-- ヒーローセクション -->
    <section class="hero">
        <video class="hero-video" autoplay muted loop playsinline preload="metadata" 
               poster="<?php echo get_template_directory_uri(); ?>/images/家の土台のイメージ.avif">
            <source src="<?php echo get_template_directory_uri(); ?>/videos/日本上空ドローン映像提供.mp4" type="video/mp4">
            <source src="<?php echo get_template_directory_uri(); ?>/videos/video-1750840581181.mp4" type="video/mp4">
            <source src="<?php echo get_template_directory_uri(); ?>/videos/Generated_File_June_24_2025_-_11_03PM.mp4" type="video/mp4">
            <!-- 動画が対応していない場合のフォールバック -->
            お使いのブラウザは動画をサポートしていません。
        </video>
        <div class="hero-content">
            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number">最短即日</span>
                    <span class="stat-label">査定完了</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">平均7日</span>
                    <span class="stat-label">資金調達</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">85%</span>
                    <span class="stat-label">事業継続率</span>
                </div>
            </div>
            
            <h1 class="hero-title">
                <strong>最短7日で資金調達。</strong><br><span class="highlight">自宅に住みながら、<br>ビジネスチャンスを掴む</span>
            </h1>
            
            <div class="hero-benefits">
                <div class="benefit-item">
                    <span>スピード査定・即日回答</span>
                </div>
                <div class="benefit-item">
                    <i class="fas fa-building"></i>
                    <span>事業継続しながら資金調達</span>
                </div>
                <div class="benefit-item">
                    <span>銀行融資より圧倒的に早い</span>
                </div>
            </div>
            
            <div class="hero-cta-group">
                <a href="#super-simple-form" class="hero-cta primary">
                    <i class="fas fa-chart-line"></i>
                    今すぐ資金調達額を確認
                </a>
                <a href="tel:050-5810-5875" class="hero-cta secondary">
                    <i class="fas fa-phone-volume"></i>
                    緊急相談ホットライン
                </a>
            </div>
        </div>
        <div class="scroll-down">
            最短即日で資金調達可能
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
            <h2 class="section-title">1分でわかる<br>リースバックって、なあに？</h2>
            <div class="manga-box">
                <div class="manga-chat"><div class="icon">🤔</div><div class="bubble"><p>家に住み続けたい…でも、将来のためのお金も必要じゃ…。どうしたものか…</p></div></div>
                <div class="manga-chat right"><div class="bubble"><p>そんなお悩みに、<strong>「リースバック」</strong>という方法があるんですよ。</p></div><div class="icon">💡</div></div>
                <div class="manga-chat"><div class="icon">🤔</div><div class="bubble"><p>リース…バック…？</p></div></div>
                <div class="manga-chat right"><div class="bubble"><p>はい。お客様の今の家を、私たちが一度買い取らせていただき、<strong>まとまったお金</strong>をお渡しします。</p></div><div class="icon">💡</div></div>
                <div class="manga-chat right"><div class="bubble"><p>その後は、私たちに<strong>毎月の家賃</strong>をお支払いいただくことで、今の家に<strong>そのまま住み続けていただけるんです。</strong></p></div><div class="icon">💡</div></div>
                <div class="manga-chat"><div class="icon">😮</div><div class="bubble"><p>まあ！家に住み続けられるのに、お金が手に入るのか！</p></div></div>
            </div>
            <div class="manga-summary">つまり…住み慣れた家はそのままで、まとまった資金を得られる仕組みです。</div>
        </div>
    </section>

    <!-- AI査定フォーム（最適位置） -->
    <section id="super-simple-form" class="assessment-form">
        <div class="container">
            <h2 class="section-title special-section-title">🤖 AI査定で即座に概算額をチェック</h2>
            <?php include get_template_directory() . '/templates/partials/super-simple-form.php'; ?>
        </div>
    </section>

    <!-- 統合ストーリー・顧客価値セクション -->
    <section class="customer-value-section">
        <div class="container">
            <h2 class="section-title">リースバックで実現する、3つのビジネスメリット</h2>
            
            <div class="value-cards">
                <div class="value-card">
                    <h3>スピード重視の資金調達</h3>
                    <p>最短即日で査定完了、平均7日で資金調達。銀行融資より圧倒的に早く、ビジネスチャンスを逃しません。</p>
                    <div class="card-stats">
                        <span class="stat-label">最短調達</span>
                        <span class="stat-value">3日</span>
                    </div>
                </div>
                
                <div class="value-card">
                    <h3>柔軟な返済・買戻しオプション</h3>
                    <p>事業が軌道に乗ったら買い戻し可能。賃料は経費計上可能で、資金繰りに合わせた条件設定ができます。</p>
                    <div class="card-stats">
                        <span class="stat-label">買戻し実績</span>
                        <span class="stat-value">45%</span>
                    </div>
                </div>
                
                <div class="value-card">
                    <h3>事業と生活の両立</h3>
                    <p>自宅兼事務所でも利用可能。引っ越し不要で事業継続、家族への影響を最小限に抑えます。</p>
                    <div class="card-stats">
                        <span class="stat-label">事業継続率</span>
                        <span class="stat-value">85%</span>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-section">
                <h3>お客様の声</h3>
                <div class="testimonial-grid">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <p>「コロナ禍で急激に運転資金が必要になりました。銀行融資を待つ余裕がない中、1週間で資金調達でき、店舗を守れました。」</p>
                        </div>
                        <div class="testimonial-author">
                            <span class="author-name">佐藤様（40代・飲食店経営）</span>
                            <span class="author-case">緊急運転資金</span>
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
                            <p>「新規物件の買付タイミングを逃したくなく、自宅を活用しました。5日で査定が完了し、優良物件への投資が実現しました。」</p>
                        </div>
                        <div class="testimonial-author">
                            <span class="author-name">鈴木様（50代・不動産投資家）</span>
                            <span class="author-case">投資資金調達</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="section-cta">
                <p class="cta-subtitle">ビジネスの成長ステージに合わせた最適な資金調達をサポート</p>
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
                <h3>だからこそ、<br>私たちがいます。</h3>
                <p>お客様にとって本当にリースバックが最良の選択なのか、私たちは専門家の視点から誠実にお伝えします。</p>
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
            <p style="text-align: left;">ビジネスにおいて、タイミングは成功の鍵です。資金調達のスピードが、新たなチャンスを掴むか逃すかを決定します。<br><br>私たちは、経営者の皆様が直面する資金調達の課題を深く理解しています。銀行融資の審査を待つ間に、貴重な機会を失うことがあってはなりません。<br><br>リースバックは、スピーディーかつ柔軟な資金調達手段として、皆様のビジネスの成長と継続を力強くサポートします。</p>
            <p class="signature">リースバック住み続け隊</p>
        </div>
    </section>

    <!-- 3つのお約束セクション -->
    <section class="promise-section">
        <div class="container">
            <h2 class="section-title">リースバック住み続け隊 3つのお約束</h2>
            <div class="promise-item">
                <h3>1. スピードと確実性を重視</h3>
                <p>最短即日で査定完了、平均7日で資金調達。ビジネスの重要なタイミングを逃さないよう、迅速かつ確実なサポートをお約束します。</p>
                <img src="<?php echo get_template_directory_uri(); ?>/images/光が差し込むイメージ.avif" alt="光が差し込むイメージ">
            </div>
            <div class="promise-item">
                <h3>2. 事業に最適な条件設計</h3>
                <p>賃料の経費計上、買戻しオプション、資金繰りに合わせた返済計画など、事業の成長ステージに応じた柔軟な条件を設計します。</p>
                <img src="https://images.unsplash.com/photo-1554224155-1696413565d3?auto=format&fit=crop&w=870" alt="真摯に向き合う手元のイメージ">
            </div>
            <div class="promise-item">
                <h3>3. 信頼と実績のネットワーク</h3>
                <p>複数の金融機関、不動産会社との提携により、最高の資金調達条件を実現。事業継続率85%の実績が、私たちの信頼性を証明しています。</p>
                <img src="<?php echo get_template_directory_uri(); ?>/images/家の土台のイメージ.avif" alt="家の土台のイメージ">
            </div>
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
            <h2>あなたの家の物語を<br>未来へ</h2>
            <p>愛着ある、この家と、これからも。その想いを、私たちはお守りします。</p>
        </div>
    </section>

    <!-- アクションセクション削除 - CTAが重複のため -->

    <!-- 信頼性インジケーター -->
    <?php include get_template_directory() . '/templates/partials/trust-indicators.php'; ?>

    <!-- メインフォーム（詳細査定への入口） -->
    <section id="assessment-form" class="assessment-form">
        <div class="container">
            <h2 class="section-title special-section-title">💰 詳細査定で正確な資金調達額を算出</h2>
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
                        <li><i class="fas fa-network-wired"></i> 最大10社に一括依頼</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- フローティングCTA -->
    <?php CTAManager::render_floating_cta(); ?>

    <!-- フッター -->
    <footer class="footer">
        <div class="container">
            <div class="footer-links">
                <a href="<?php echo home_url('/company/'); ?>">会社概要</a>
                <a href="<?php echo home_url('/privacy/'); ?>">プライバシーポリシー</a>
                <a href="<?php echo home_url('/terms/'); ?>">利用規約</a>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> リースバック住み続け隊 All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // スムーススクロールとフォーム処理
        document.addEventListener('DOMContentLoaded', function() {
            // ヘッダーのスクロール処理
            const header = document.querySelector('.header');
            let lastScrollY = window.scrollY;
            
            window.addEventListener('scroll', () => {
                const currentScrollY = window.scrollY;
                
                // スクロール位置が50px以上でヘッダー背景を変更
                if (currentScrollY > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
                
                lastScrollY = currentScrollY;
            });
            
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
