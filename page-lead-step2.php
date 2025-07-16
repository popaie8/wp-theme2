<?php
/**
 * Template Name: 詳細査定フォーム (Step-2)
 * URL 例： /lead-step2/?zip=1234567&property-type=mansion-unit
 */
get_header();

// Step-1 から渡ってきた値を取得
$zip  = sanitize_text_field( $_GET['zip']  ?? '' );
$type = sanitize_text_field( $_GET['property-type'] ?? '' );

// 物件種別ラベル — Step-1 と同じ並びで
$labels = [
  'mansion-unit'       => 'マンション（区分）',
  'house'              => '一戸建て',
  'land'               => '土地',
  'mansion-building'   => 'マンション一棟',
  'building'           => 'ビル一棟',
  'apartment-building' => 'アパート一棟',
  'other'              => 'その他',
];
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-T3B4TDCC');</script>
    <!-- End Google Tag Manager -->

    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <title>無料査定フォーム - <?php bloginfo('name'); ?></title>
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

        /* パンくずリスト */
        .breadcrumb-container {
            background-color: #f8f9fa;
            padding: 15px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .breadcrumb {
            max-width: 820px;
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

        /* リードフォームスタイル */
        .lead-form {
            padding: clamp(60px, 8vw, 100px) 0;
            background: var(--color-background);
            min-height: 100vh;
        }

        .lead-form .container { 
            max-width: 820px; 
            margin: 0 auto;
            padding: 0 20px;
        }

        .form-wrapper {
            background: #fff;
            border-radius: 14px;
            padding: clamp(40px, 6vw, 60px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            position: relative;
        }

        .lead-title {
            font-family: var(--font-heading);
            font-size: clamp(1.5rem, 4vw, 2rem);
            color: var(--color-primary);
            text-align: center;
            margin-bottom: 40px;
            font-weight: 500;
        }

        /* プログレスメーター */
        .progress-container {
            margin-bottom: 40px;
        }

        .progress-bar {
            background: #e9ecef;
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .progress-fill {
            background: linear-gradient(90deg, var(--color-primary), var(--color-accent));
            height: 100%;
            width: 33.33%;
            transition: width 0.4s ease;
        }

        .step-indicators {
            display: flex;
            justify-content: space-between;
            position: relative;
        }

        .step-indicator {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            position: relative;
        }

        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e9ecef;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }

        .step-indicator.active .step-number {
            background: var(--color-primary);
            color: white;
        }

        .step-indicator.completed .step-number {
            background: var(--color-accent);
            color: white;
        }

        .step-label {
            font-size: 12px;
            font-weight: 500;
            color: #6c757d;
            text-align: center;
        }

        .step-indicator.active .step-label,
        .step-indicator.completed .step-label {
            color: var(--color-primary);
            font-weight: 600;
        }

        /* フォームスタイル */
        .form-block {
            border: none;
            padding: 0;
            margin-bottom: 32px;
        }

        .form-block legend {
            font-family: var(--font-heading);
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--color-primary);
            margin-bottom: 24px;
            padding: 0;
        }

        .form-row {
            display: flex;
            gap: 18px;
            margin-bottom: 18px;
        }

        .form-row.two-col > * {
            flex: 1 1 calc(50% - 9px);
        }

        .form-row.three-col {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .form-row.three-col .form-group {
            flex: 1 1 calc(33.33% - 8px);
            min-width: 120px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            flex: 1 1 100%;
        }

        .form-group label {
            font-weight: 600;
            color: var(--color-primary);
            margin-bottom: 8px;
            font-size: 14px;
        }

        .req {
            color: var(--color-accent);
            font-size: 0.85rem;
            margin-left: 4px;
            font-weight: 600;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 14px 15px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: all 0.3s ease;
            font-family: var(--font-body);
            background: #fff;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--color-accent);
            box-shadow: 0 0 0 3px rgba(185, 141, 74, 0.1);
        }

        .form-group input.readonly {
            background: #f8f9fa;
            color: #6c757d;
            cursor: not-allowed;
        }

        .note {
            font-size: 12px;
            color: #6c757d;
            margin-top: 4px;
        }

        /* ステップコンテンツ */
        .step-content {
            display: none;
        }

        .step-content.active {
            display: block;
        }

        /* ボタンスタイル */
        .button-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 40px;
        }
        
        /* 決定ボタンを必ず上に */
        .btn-next, .btn-submit {
            order: 1;
        }
        
        /* 戻るボタンを必ず下に */
        .btn-prev {
            order: 2;
        }

        .btn {
            padding: 16px 32px;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 160px;
        }

        .btn-prev {
            background: #6c757d;
            color: white;
            border: 2px solid #6c757d;
        }

        .btn-prev:hover {
            background: #5a6268;
            border-color: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
        }

        .btn-next,
        .btn-submit {
            background: linear-gradient(135deg, var(--color-accent), var(--color-primary));
            color: white;
            border: 2px solid var(--color-accent);
        }

        .btn-next:hover,
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(185, 141, 74, 0.4);
            filter: brightness(1.1);
        }

        /* 同意チェックボックス */
        .agree {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 14px;
            line-height: 1.6;
        }

        .agree input[type="checkbox"] {
            margin: 0;
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .agree a {
            color: var(--color-accent);
            text-decoration: underline;
        }

        .agree a:hover {
            color: var(--color-primary);
        }

        /* 物件詳細フォーム用スタイル */
        .layout-input {
            display: flex;
            gap: 12px;
        }

        .layout-rooms,
        .layout-type {
            flex: 1;
            min-width: 120px;
        }

        .unit-toggle {
            display: flex;
            gap: 16px;
            margin-bottom: 12px;
        }

        .unit-toggle label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: normal;
            margin-bottom: 0;
        }

        .area-input-group {
            position: relative;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .area-input-group input {
            flex: 1;
            padding-right: 50px;
        }

        .area-input-group .unit-display {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            font-size: 14px;
            pointer-events: none;
        }

        /* 個人情報管理表記とリンク */
        .privacy-notice {
            margin-top: 32px;
            text-align: center;
            padding-top: 24px;
            border-top: 1px solid #e9ecef;
        }

        .privacy-text {
            font-size: 12px;
            color: #666;
            margin-bottom: 12px;
            line-height: 1.5;
        }

        .footer-links {
            font-size: 12px;
            color: #666;
        }

        .footer-links a {
            color: var(--color-accent);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .footer-links a:hover {
            color: var(--color-primary);
            text-decoration: underline;
        }

        .footer-links .separator {
            margin: 0 8px;
            color: #999;
        }

        .area-unit {
            font-weight: 600;
            color: var(--color-primary);
            min-width: 24px;
        }

        /* シンプルフッター */
        .simple-footer {
            background-color: var(--color-primary);
            color: #fff;
            padding: 30px 0;
            margin-top: 60px;
            text-align: center;
        }

        .footer-home-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--color-accent);
            color: white;
            padding: 14px 28px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .footer-home-button:hover {
            background: #A17A3F;
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }

        .footer-copyright p {
            margin: 0;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
        }

        /* モーダルスタイル */
        .thanks-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .thanks-modal.show {
            opacity: 1;
            visibility: visible;
        }

        .thanks-modal-content {
            background: white;
            padding: 48px;
            border-radius: 16px;
            text-align: center;
            max-width: 500px;
            margin: 20px;
            transform: scale(0.8);
            transition: transform 0.3s ease;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .thanks-modal.show .thanks-modal-content {
            transform: scale(1);
        }

        .thanks-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #28a745, #20c997);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 40px;
            color: white;
        }

        .thanks-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--color-primary);
            margin-bottom: 16px;
            font-family: var(--font-heading);
        }

        .thanks-message {
            font-size: 16px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 32px;
        }

        .thanks-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .thanks-btn {
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            font-size: 14px;
            box-sizing: border-box;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
        }

        .thanks-btn-primary {
            background: var(--color-primary);
            color: white;
        }

        .thanks-btn-primary:hover {
            background: #0E2A3D;
            color: white;
        }

        .thanks-btn-secondary {
            background: #f8f9fa;
            color: #666;
            border: 2px solid #dee2e6;
        }

        .thanks-btn-secondary:hover {
            background: #e9ecef;
            color: #495057;
        }

        /* 送信中オーバーレイ */
        .form-sending {
            position: relative;
        }

        .form-sending::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .form-sending::before {
            content: "送信中...";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: var(--color-accent);
            color: white;
            padding: 16px 24px;
            border-radius: 8px;
            font-weight: 600;
            z-index: 1001;
            box-shadow: 0 4px 12px rgba(185,141,74, 0.3);
        }

        /* 送信成功モーダル */
        .thanks-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .thanks-modal.show {
            opacity: 1;
            visibility: visible;
        }

        .thanks-modal-content {
            background: white;
            border-radius: 16px;
            padding: 40px;
            max-width: 500px;
            width: 90%;
            text-align: center;
            transform: scale(0.8);
            transition: transform 0.3s ease;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .thanks-modal.show .thanks-modal-content {
            transform: scale(1);
        }

        .thanks-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #28a745, #20c997);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 40px;
            color: white;
        }

        .thanks-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--color-primary);
            margin-bottom: 16px;
            font-family: var(--font-heading);
        }

        .thanks-message {
            font-size: 16px;
            color: var(--color-secondary);
            margin-bottom: 32px;
            line-height: 1.6;
        }

        .thanks-message p {
            margin-bottom: 12px;
        }


        .thanks-btn-primary {
            background: var(--color-primary);
            color: white;
        }

        .thanks-btn-primary:hover {
            background: #0E2A3D;
            color: white;
        }

        .thanks-btn-secondary {
            background: #f8f9fa;
            color: #666;
            border: 2px solid #dee2e6;
        }

        .thanks-btn-secondary:hover {
            background: #e9ecef;
            color: #495057;
        }

        /* レスポンシブ対応 */
        @media (max-width: 768px) {
            .lead-form {
                padding: 40px 0;
            }
            
            .form-wrapper {
                padding: 30px 20px;
                margin: 0 10px;
            }
            
            .form-row.two-col {
                flex-direction: column;
                gap: 12px;
            }
            
            .form-row.two-col > * {
                flex: 1 1 100%;
            }

            .form-row.three-col {
                flex-direction: column;
                gap: 12px;
            }
            
            .form-row.three-col .form-group {
                flex: 1 1 100%;
                min-width: 100%;
            }

            .three-col .form-group label {
                font-size: 14px;
                margin-bottom: 6px;
            }
            
            .form-group input,
            .form-group select,
            .form-group textarea {
                padding: 14px 16px;
                font-size: 16px;
                box-sizing: border-box;
                width: 100%;
            }
            
            .three-col .form-group input,
            .three-col .form-group select {
                padding: 14px;
                font-size: 16px;
                box-sizing: border-box;
                width: 100%;
            }

            .step-label {
                font-size: 10px;
            }

            .step-number {
                width: 32px;
                height: 32px;
                font-size: 12px;
            }

            .layout-input {
                flex-direction: column;
            }

            .layout-rooms, .layout-type {
                min-width: 100%;
            }

            .footer-home-button {
                font-size: 14px;
                padding: 14px 24px;
            }
            
            .footer-home-button i {
                font-size: 14px;
            }

            .privacy-notice {
                margin-top: 24px;
                padding-top: 20px;
            }

            .privacy-text {
                font-size: 11px;
                margin-bottom: 10px;
            }

            .footer-links {
                font-size: 11px;
            }

            .footer-links .separator {
                margin: 0 6px;
            }
            
            .btn {
                padding: 18px 36px;
                font-size: 16px;
                min-height: 48px;
                min-width: 140px;
            }
            
            .agree {
                padding: 16px 0;
            }
            
            .agree input[type="checkbox"] {
                width: 20px;
                height: 20px;
                margin-right: 12px;
            }
            
            .unit-toggle label {
                padding: 12px 8px;
                min-height: 44px;
            }
        }

        @media (max-width: 480px) {
            .lead-form {
                padding: 20px 0;
            }
            
            .form-wrapper {
                padding: 24px 18px;
                margin: 0 10px;
            }
            
            .lead-title {
                font-size: 1.3rem;
                margin-bottom: 30px;
            }
            
            .form-row.three-col {
                gap: 10px;
            }
            
            .form-row.three-col .form-group {
                flex: 1 1 100%;
                min-width: 100%;
            }

            .three-col .form-group label {
                font-size: 13px;
                margin-bottom: 5px;
            }
            
            .form-group input,
            .form-group select,
            .form-group textarea {
                padding: 16px 18px;
                font-size: 16px;
                box-sizing: border-box;
                width: 100%;
            }
            
            .three-col .form-group input,
            .three-col .form-group select {
                padding: 16px;
                font-size: 16px;
                box-sizing: border-box;
                width: 100%;
            }
            
            .step-number {
                width: 28px;
                height: 28px;
                font-size: 11px;
            }
            
            .step-label {
                font-size: 9px;
            }

            /* モーダルレスポンシブ */
            .thanks-modal-content {
                padding: 32px 24px;
                margin: 20px;
            }
            
            .thanks-title {
                font-size: 20px;
            }
            
            .thanks-message {
                font-size: 14px;
            }
            
            .thanks-buttons {
                flex-direction: column;
                gap: 12px;
            }
            
            .thanks-btn {
                width: 100%;
                padding: 16px 24px;
                justify-content: center;
                min-height: 48px;
                box-sizing: border-box;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            
            .btn {
                padding: 16px 20px;
                font-size: 16px;
                box-sizing: border-box;
                width: 100%;
                margin: 6px 0;
            }
            
            .button-group {
                flex-direction: column;
                gap: 12px;
                width: 100%;
            }
            
            .agree {
                padding: 20px 0;
            }
            
            .agree input[type="checkbox"] {
                width: 24px;
                height: 24px;
                margin-right: 16px;
            }
            
            .unit-toggle label {
                padding: 16px 12px;
                min-height: 48px;
            }
        }
    </style>
</head>

<body <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T3B4TDCC"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

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
                <span class="current">無料査定フォーム</span>
            </li>
        </ul>
    </nav>
</div>

<section class="lead-form" id="lead-form-section">
  <div class="container">
    <div class="form-wrapper">
      <h2 class="lead-title">物件詳細とご連絡先を入力してください</h2>

      <!-- プログレスメーター -->
      <div class="progress-container">
        <div class="progress-bar">
          <div class="progress-fill" id="progressFill"></div>
        </div>
        <div class="step-indicators">
          <div class="step-indicator active" data-step="1">
            <div class="step-number">1</div>
            <div class="step-label">物件所在地</div>
          </div>
          <div class="step-indicator" data-step="2">
            <div class="step-number">2</div>
            <div class="step-label">物件情報</div>
          </div>
          <div class="step-indicator" data-step="3">
            <div class="step-number">3</div>
            <div class="step-label">お客様情報</div>
          </div>
        </div>
      </div>

      <!-- フォーム -->
      <form action="<?= esc_url( admin_url( 'admin-post.php' ) ); ?>"
            method="post" class="js-detail-form" id="detailForm">

        <!-- hidden 必須パラメータ -->
        <input type="hidden" name="action" value="lead_submit">
        <input type="hidden" name="zip" value="<?= esc_attr( $zip ); ?>">
        <input type="hidden" name="property-type" value="<?= esc_attr( $type ); ?>" id="propertyType">
        <input type="hidden" name="inq_type" value="51">
        <?php wp_nonce_field( 'lead_form_nonce', 'nonce' ); ?>

        <!-- Step 1: 物件所在地 -->
        <div class="step-content active" data-step="1">
          <fieldset class="form-block">
            <legend>物件所在地</legend>

            <div class="form-row two-col">
              <div class="form-group">
                <label>郵便番号</label>
                <input type="text" class="readonly" value="<?= esc_attr( $zip ); ?>" readonly>
              </div>
              <div class="form-group">
                <label>物件種別</label>
                <input type="text" class="readonly" value="<?= esc_html( $labels[$type] ?? '' ); ?>" readonly>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>都道府県</label>
                <input type="text" name="pref" class="readonly js-pref-display" value="自動取得中…" readonly>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>市区町村</label>
                <input type="text" name="city" class="readonly js-city-display" value="自動取得中…" readonly>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>町名</label>
                <input type="text" name="town" class="readonly js-town-display" value="自動取得中…" readonly>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>丁目 <span class="req">必須</span></label>
                <select name="chome" class="js-chome" required>
                  <option value="">選択してください</option>
                </select>
              </div>
            </div>

            <div class="form-row three-col">
              <div class="form-group">
                <label>番地・号 <span class="req">必須</span></label>
                <input type="text" name="banchi" placeholder="例）10-3" required>
              </div>
              <div class="form-group">
                <label>建物名</label>
                <input type="text" name="building_name" placeholder="例）○○マンション">
                <div class="note">※マンション・ビル等の場合のみ</div>
              </div>
              <div class="form-group">
                <label>部屋番号</label>
                <input type="text" name="room_number" placeholder="例）101">
                <div class="note">※マンション・アパート等の場合のみ</div>
              </div>
            </div>
          </fieldset>
        </div>

        <!-- Step 2: 物件情報 -->
        <div class="step-content" data-step="2">
          <fieldset class="form-block">
            <legend>物件情報</legend>
            <div id="propertyDetails">
              <!-- 動的に生成される物件詳細フォーム -->
            </div>
          </fieldset>
        </div>

        <!-- Step 3: お客様情報 -->
        <div class="step-content" data-step="3">
          <fieldset class="form-block">
            <legend>お客様情報</legend>

            <div class="form-row two-col">
              <div class="form-group">
                <label>お名前 <span class="req">必須</span></label>
                <input type="text" name="name" placeholder="例）山田 太郎" required>
              </div>
              <div class="form-group">
                <label>電話番号 <span class="req">必須</span></label>
                <input type="tel" name="tel" placeholder="例）090-1234-5678"
                       pattern="\d{2,4}-?\d{2,4}-?\d{3,4}" required>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>メールアドレス <span class="req">必須</span></label>
                <input type="email" name="email" placeholder="例）sample@example.com" required>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>ご質問・ご要望など</label>
                <textarea name="remarks" rows="4" placeholder="査定に関するご質問やご要望がございましたら、こちらにご記入ください。&#10;（例）売却時期、価格の希望、その他気になる点など"></textarea>
                <div class="note">※任意項目です。お気軽にご記入ください。</div>
              </div>
            </div>

            <div class="form-row">
              <label class="agree">
                <input type="checkbox" name="agree" required>
                <span> <a href="<?php echo home_url('/terms/'); ?>" target="_blank">利用規約</a> と
                <a href="<?php echo home_url('/privacy/'); ?>" target="_blank">プライバシーポリシー</a> に同意する</span>
              </label>
            </div>
          </fieldset>
        </div>

        <!-- ボタン -->
        <div class="button-group">
          <button type="button" class="btn btn-next" id="nextBtn">次へ</button>
          <button type="submit" class="btn btn-submit" id="submitBtn" style="display: none;">無料査定を依頼する</button>
          <button type="button" class="btn btn-prev" id="prevBtn" style="display: none;">戻る</button>
        </div>
      </form>

      <!-- 個人情報管理表記とリンク -->
      <div class="privacy-notice">
          <p class="privacy-text">※個人情報は厳重に管理し、査定目的以外には使用いたしません。</p>
          <div class="footer-links">
              <a href="<?php echo home_url('/company/'); ?>">会社概要</a>
              <span class="separator">|</span>
              <a href="<?php echo home_url('/privacy/'); ?>">プライバシーポリシー</a>
              <span class="separator">|</span>
              <a href="<?php echo home_url('/terms/'); ?>">利用規約</a>
          </div>
      </div>
    </div>
  </div>
</section>

<!-- シンプルフッター -->
<footer class="simple-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-home">
                <a href="<?php echo home_url(); ?>" class="footer-home-button">
                    <i class="fas fa-home"></i>
                    ホームに戻る
                </a>
            </div>
            <div class="footer-copyright">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?> All Rights Reserved.</p>
            </div>
        </div>
    </div>
</footer>

<!-- 参考コードのJavaScriptを WordPress 対応版に -->
<script>
/**
 * WordPress対応版リードフォーム制御（37フィールド完全対応）
 */

// 定数
const STORAGE_KEY = 'leadFormData';
const WP_ADMIN_POST_URL = '<?php echo esc_url(admin_url('admin-post.php')); ?>';

// DOM要素の取得
const getFormElements = () => ({
  form: document.getElementById('detailForm'),
  propertyTypeInput: document.getElementById('propertyType'),
  nextBtn: document.getElementById('nextBtn'),
  prevBtn: document.getElementById('prevBtn'),
  submitBtn: document.getElementById('submitBtn'),
  progressFill: document.getElementById('progressFill'),
  propertyDetails: document.getElementById('propertyDetails')
});

// ユーティリティ関数
const utils = {
  getUrlParam: (param) => {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
  },

  storage: {
    data: {},
    
    save: function(newData) {
      try {
        if (!this.data || typeof this.data !== 'object') {
          this.data = {};
        }
        
        if (newData && typeof newData === 'object') {
          this.data = { ...this.data, ...newData };
        }
        
        if (typeof Storage !== 'undefined' && window.sessionStorage) {
          try {
            sessionStorage.setItem(STORAGE_KEY, JSON.stringify(this.data));
          } catch (e) {
            console.warn('sessionStorage保存エラー:', e);
          }
        }
        
        console.log('📝 フォームデータ保存成功:', this.data);
        return true;
      } catch (e) {
        console.error('フォームデータの保存に失敗:', e);
        if (!this.data) {
          this.data = {};
        }
        return false;
      }
    },
    
    load: function() {
      try {
        if (!this.data || typeof this.data !== 'object') {
          this.data = {};
        }
        
        if (typeof Storage !== 'undefined' && window.sessionStorage) {
          try {
            const stored = sessionStorage.getItem(STORAGE_KEY);
            if (stored) {
              const parsedData = JSON.parse(stored);
              if (parsedData && typeof parsedData === 'object') {
                this.data = parsedData;
                console.log('🔄 データ復元成功:', this.data);
                return this.data;
              }
            }
          } catch (e) {
            console.warn('sessionStorage復元エラー:', e);
          }
        }
        
        console.log('🔄 メモリデータを返却:', this.data);
        return this.data;
      } catch (e) {
        console.error('フォームデータの復元に失敗:', e);
        this.data = {};
        return {};
      }
    },
    
    clear: function() {
      try {
        this.data = {};
        if (typeof Storage !== 'undefined' && window.sessionStorage) {
          sessionStorage.removeItem(STORAGE_KEY);
        }
        console.log('🗑️ データクリア完了');
      } catch (e) {
        console.warn('フォームデータのクリアに失敗:', e);
        this.data = {};
      }
    }
  },

  range: (length) => Array.from({ length }, (_, i) => i + 1),

  debounce: (func, wait) => {
    let timeout;
    return function executedFunction(...args) {
      const later = () => {
        clearTimeout(timeout);
        func(...args);
      };
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
    };
  }
};

// 住所取得API
const addressApi = {
  async fetchAddress(zip) {
    try {
      const response = await fetch(`https://zipcloud.ibsnet.co.jp/api/search?zipcode=${zip}`);
      const data = await response.json();
      
      if (!data.results) {
        throw new Error('住所が見つかりません');
      }

      return {
        pref: data.results[0].address1,
        city: data.results[0].address2,
        town: data.results[0].address3.replace(/(\d.*丁目?)$/, '')
      };
    } catch (error) {
      console.error('住所取得エラー:', error);
      throw error;
    }
  },

  updateAddressFields({ pref, city, town }) {
    const prefDisplay = document.querySelector('.js-pref-display');
    const cityDisplay = document.querySelector('.js-city-display');
    const townDisplay = document.querySelector('.js-town-display');

    if (prefDisplay) prefDisplay.value = pref;
    if (cityDisplay) cityDisplay.value = city;
    if (townDisplay) townDisplay.value = town;
  },

  initChomeSelect(max = 20) {
    const chomeSel = document.querySelector('.js-chome');
    if (!chomeSel) return;
    
    chomeSel.innerHTML = '<option value="">選択してください</option>';
    utils.range(max).forEach(i => {
      chomeSel.insertAdjacentHTML('beforeend', `<option value="${i}">${i}丁目</option>`);
    });
  }
};

// ステップフォーム管理（WordPress対応）
class StepFormManager {
  constructor(propertyType = 'mansion-unit') {
    this.currentStep = 1;
    this.totalSteps = 3;
    this.propertyType = propertyType;
    
    console.log('StepFormManager初期化 - 物件種別:', this.propertyType);
    this.init();
  }

  init() {
    this.bindEvents();
    this.updateUI();
  }

  bindEvents() {
    const { nextBtn, prevBtn, form } = getFormElements();

    if (nextBtn) {
      nextBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        this.handleNext();
        return false;
      });
    }
    
    if (prevBtn) {
      prevBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        this.handlePrev();
        return false;
      });
    }
    
    if (form) {
      form.addEventListener('submit', (e) => {
        e.preventDefault();
        e.stopPropagation();
        this.handleSubmit(e);
        return false;
      });
    }
  }

  handleNext() {
    console.log('次へボタン - 現在:', this.currentStep);
    
    if (!this.validateCurrentStep()) {
      console.log('バリデーション失敗');
      return;
    }
    
    if (this.currentStep < this.totalSteps) {
      this.currentStep++;
      this.updateUI();
      
      if (this.currentStep === 2) {
        this.generatePropertyDetails();
      }
    }
  }

  handlePrev() {
    if (this.currentStep > 1) {
      this.currentStep--;
      this.updateUI();
    }
  }

  validateCurrentStep() {
    const currentStepElement = document.querySelector(`.step-content[data-step="${this.currentStep}"]`);
    if (!currentStepElement) {
      console.error('ステップが見つかりません:', this.currentStep);
      return false;
    }

    // HTML5バリデーションを無効化
    const form = document.querySelector('#js-lead-form');
    if (form) {
      form.setAttribute('novalidate', 'true');
    }

    const requiredFields = currentStepElement.querySelectorAll('[required]');
    
    for (const field of requiredFields) {
      const isVisible = field.offsetParent !== null && 
                       field.offsetWidth > 0 &&
                       field.offsetHeight > 0 &&
                       field.style.display !== 'none' && 
                       field.style.visibility !== 'hidden' &&
                       !field.hasAttribute('disabled') &&
                       !field.hasAttribute('readonly');
      
      if (!isVisible) {
        console.log('非表示フィールドをスキップ:', field.name);
        continue;
      }
      
      let isEmpty = false;
      if (field.type === 'checkbox') {
        isEmpty = !field.checked;
      } else {
        isEmpty = !field.value?.trim();
      }
      
      if (isEmpty) {
        console.log('必須フィールドが空:', field.name);
        
        try {
          if (typeof field.focus === 'function') {
            field.focus();
            field.scrollIntoView({ behavior: 'smooth', block: 'center' });
          }
        } catch (e) {
          console.warn('フォーカス不可能:', field.name, e);
        }
        
        let fieldLabel = field.name;
        const labelElement = currentStepElement.querySelector(`label[for="${field.id}"], label[data-field="${field.name}"]`);
        if (labelElement) {
          fieldLabel = labelElement.textContent.replace(/\s*必須\s*/, '').trim();
        }
        
        alert(`${fieldLabel}を入力してください。`);
        return false;
      }
    }
    
    return true;
  }

  updateUI() {
    // ステップコンテンツ切り替え
    document.querySelectorAll('.step-content').forEach(content => {
      content.classList.remove('active');
    });
    
    const activeStep = document.querySelector(`.step-content[data-step="${this.currentStep}"]`);
    if (activeStep) {
      activeStep.classList.add('active');
    }

    // インジケーター更新
    document.querySelectorAll('.step-indicator').forEach((indicator, index) => {
      const stepNum = index + 1;
      indicator.classList.remove('active', 'completed');
      
      if (stepNum === this.currentStep) {
        indicator.classList.add('active');
      } else if (stepNum < this.currentStep) {
        indicator.classList.add('completed');
      }
    });

    // プログレスバー更新
    const { progressFill } = getFormElements();
    if (progressFill) {
      const percentage = (this.currentStep / this.totalSteps) * 100;
      progressFill.style.width = `${percentage}%`;
    }

    // ボタン表示制御
    const { prevBtn, nextBtn, submitBtn } = getFormElements();
    
    if (prevBtn) prevBtn.style.display = this.currentStep === 1 ? 'none' : 'block';
    if (nextBtn) nextBtn.style.display = this.currentStep === this.totalSteps ? 'none' : 'block';
    if (submitBtn) submitBtn.style.display = this.currentStep === this.totalSteps ? 'block' : 'none';
  }

  generatePropertyDetails() {
    const { propertyDetails } = getFormElements();
    if (!propertyDetails) {
      console.error('propertyDetails コンテナが見つかりません');
      return;
    }

    console.log('物件詳細生成:', this.propertyType);
    
    const formGenerators = {
      'mansion-unit': () => this.generateMansionForm(),
      'house': () => this.generateHouseForm(),
      'land': () => this.generateLandForm(),
      'mansion-building': () => this.generateBuildingForm(),
      'building': () => this.generateBuildingForm(),
      'apartment-building': () => this.generateBuildingForm(),
      'other': () => this.generateOtherForm()
    };

    const generator = formGenerators[this.propertyType] || formGenerators['mansion-unit'];
    propertyDetails.innerHTML = generator();
    
    this.bindAreaUnitEvents();
  }

  generateMansionForm() {
    const roomOptions = utils.range(9).map(i => `<option value="${i}">${i}</option>`).join('');
    const ageOptions = utils.range(31).map(i => `<option value="${i-1}">${i-1}年</option>`).join('');

    return `
      <div class="form-row">
        <div class="form-group">
          <label>間取り（マンション区分）</label>
          <div class="layout-input">
            <div class="layout-rooms">
              <select name="layout_rooms">
                <option value="">部屋数を選択</option>
                ${roomOptions}
              </select>
            </div>
            <div class="layout-type">
              <select name="layout_type">
                <option value="">タイプを選択</option>
                <option value="ワンルーム">ワンルーム</option>
                <option value="K">K</option>
                <option value="DK">DK</option>
                <option value="LK">LK</option>
                <option value="LDK">LDK</option>
                <option value="SK">SK</option>
                <option value="SDK">SDK</option>
                <option value="SLK">SLK</option>
                <option value="SLDK">SLDK</option>
              </select>
            </div>
          </div>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>専有面積</label>
          <div class="unit-toggle">
            <label><input type="radio" name="area_unit" value="㎡" checked> ㎡</label>
            <label><input type="radio" name="area_unit" value="坪"> 坪</label>
          </div>
          <div class="area-input-group">
            <input type="number" name="area"  placeholder="例）80" step="0.1">
            <span class="area-unit">㎡</span>
          </div>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>築年数（経過年数）</label>
          <select name="age">
            <option value="">築年数を選択</option>
            ${ageOptions}
            <option value="31">31年以上・正確に覚えていない</option>
          </select>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
    `;
  }

  generateHouseForm() {
    const roomOptions = utils.range(9).map(i => `<option value="${i}">${i}</option>`).join('');
    const ageOptions = utils.range(31).map(i => `<option value="${i-1}">${i-1}年</option>`).join('');

    return `
      <div class="form-row">
        <div class="form-group">
          <label>間取り（一戸建て）</label>
          <div class="layout-input">
            <div class="layout-rooms">
              <select name="layout_rooms">
                <option value="">部屋数を選択</option>
                ${roomOptions}
              </select>
            </div>
            <div class="layout-type">
              <select name="layout_type">
                <option value="">タイプを選択</option>
                <option value="LDK">LDK</option>
                <option value="DK">DK</option>
                <option value="SLDK">SLDK</option>
                <option value="SDK">SDK</option>
              </select>
            </div>
          </div>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>建物面積</label>
          <div class="unit-toggle">
            <label><input type="radio" name="building_area_unit" value="㎡" checked> ㎡</label>
            <label><input type="radio" name="building_area_unit" value="坪"> 坪</label>
          </div>
          <div class="area-input-group">
            <input type="number" name="building_area" placeholder="例）120" step="0.1">
            <span class="area-unit">㎡</span>
          </div>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>土地面積</label>
          <div class="unit-toggle">
            <label><input type="radio" name="land_area_unit" value="㎡" checked> ㎡</label>
            <label><input type="radio" name="land_area_unit" value="坪"> 坪</label>
          </div>
          <div class="area-input-group">
            <input type="number" name="land_area" placeholder="例）150" step="0.1">
            <span class="area-unit">㎡</span>
          </div>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>築年数（経過年数）</label>
          <select name="age">
            <option value="">築年数を選択</option>
            ${ageOptions}
            <option value="31">31年以上・正確に覚えていない</option>
          </select>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
    `;
  }

  generateLandForm() {
    return `
      <div class="form-row">
        <div class="form-group">
          <label>土地面積</label>
          <div class="unit-toggle">
            <label><input type="radio" name="land_area_unit" value="㎡" checked> ㎡</label>
            <label><input type="radio" name="land_area_unit" value="坪"> 坪</label>
          </div>
          <div class="area-input-group">
            <input type="number" name="land_area"  placeholder="例）200" step="0.1">
            <span class="area-unit">㎡</span>
          </div>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>備考</label>
          <textarea name="land_remarks" rows="3" placeholder="土地の特徴、用途地域、接道状況など"></textarea>
          <div class="note">※任意項目です。</div>
        </div>
      </div>
    `;
  }

  generateBuildingForm() {
    const ageOptions = utils.range(31).map(i => `<option value="${i-1}">${i-1}年</option>`).join('');

    return `
      <div class="form-row">
        <div class="form-group">
          <label>建物面積</label>
          <div class="unit-toggle">
            <label><input type="radio" name="building_area_unit" value="㎡" checked> ㎡</label>
            <label><input type="radio" name="building_area_unit" value="坪"> 坪</label>
          </div>
          <div class="area-input-group">
            <input type="number" name="building_area"  placeholder="例）500" step="0.1">
            <span class="area-unit">㎡</span>
          </div>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>土地面積</label>
          <div class="unit-toggle">
            <label><input type="radio" name="land_area_unit" value="㎡" checked> ㎡</label>
            <label><input type="radio" name="land_area_unit" value="坪"> 坪</label>
          </div>
          <div class="area-input-group">
            <input type="number" name="land_area"  placeholder="例）300" step="0.1">
            <span class="area-unit">㎡</span>
          </div>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>総戸数・室数</label>
          <input type="number" name="total_units"  placeholder="例）10">
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>築年数（経過年数）</label>
          <select name="age">
            <option value="">築年数を選択</option>
            ${ageOptions}
            <option value="31">31年以上・正確に覚えていない</option>
          </select>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
    `;
  }

  generateOtherForm() {
    const ageOptions = utils.range(31).map(i => `<option value="${i-1}">${i-1}年</option>`).join('');

    return `
      <div class="form-row">
        <div class="form-group">
          <label>種類</label>
          <select name="other_type">
            <option value="">--- 選択してください ---</option>
            <option value="ビル（区分）">ビル（区分）</option>
            <option value="店舗">店舗</option>
            <option value="倉庫">倉庫</option>
            <option value="工場">工場</option>
            <option value="その他">その他</option>
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>建物面積</label>
          <div class="unit-toggle">
            <label><input type="radio" name="building_area_unit" value="㎡" checked> ㎡</label>
            <label><input type="radio" name="building_area_unit" value="坪"> 坪</label>
          </div>
          <div class="area-input-group">
            <input type="number" name="building_area"  placeholder="例）200" step="0.1">
            <span class="area-unit">㎡</span>
          </div>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>土地面積</label>
          <div class="unit-toggle">
            <label><input type="radio" name="land_area_unit" value="㎡" checked> ㎡</label>
            <label><input type="radio" name="land_area_unit" value="坪"> 坪</label>
          </div>
          <div class="area-input-group">
            <input type="number" name="land_area" placeholder="例）150" step="0.1">
            <span class="area-unit">㎡</span>
          </div>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>築年数（経過年数）</label>
          <select name="age">
            <option value="">築年数を選択</option>
            ${ageOptions}
            <option value="31">31年以上・正確に覚えていない</option>
          </select>
          <div class="note">※おおよそで結構です。</div>
        </div>
      </div>
    `;
  }

  bindAreaUnitEvents() {
    document.querySelectorAll('input[name$="_unit"]').forEach(radio => {
      radio.addEventListener('change', (e) => {
        const unitSpan = e.target.closest('.form-group').querySelector('.area-unit');
        if (unitSpan) {
          unitSpan.textContent = e.target.value;
        }
      });
    });
  }

  async handleSubmit(e) {
    console.log('フォーム送信処理開始（WordPress版）');
    
    if (!this.validateCurrentStep()) {
      return;
    }
    
    await ajaxSubmitter.submit(e);
  }
}

// 送信成功モーダル管理
const modalManager = {
  show(customerName = '') {
    console.log('モーダル表示:', customerName);
    
    let modal = document.getElementById('thanksModal');
    
    if (!modal) {
      this.create();
      modal = document.getElementById('thanksModal');
    }
    
    if (customerName) {
      const messageEl = modal.querySelector('.thanks-message');
      messageEl.innerHTML = `
        <p><strong>${customerName}様</strong></p>
        <p>査定依頼を受け付けました。<br>
        担当者から<strong>24時間以内</strong>にご連絡いたします。</p>
        <p>しばらくお待ちください。</p>
      `;
    }
    
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
  },

  hide() {
    const modal = document.getElementById('thanksModal');
    if (modal) {
      modal.classList.remove('show');
      document.body.style.overflow = '';
      
      setTimeout(() => modal.remove(), 300);
    }
  },

  create() {
    const modalHtml = `
      <div id="thanksModal" class="thanks-modal">
        <div class="thanks-modal-content">
          <div class="thanks-icon">
            <i class="fas fa-check"></i>
          </div>
          <h2 class="thanks-title">お問い合わせありがとうございます</h2>
          <div class="thanks-message">
            <p>査定依頼を受け付けました。<br>
            担当者から<strong>24時間以内</strong>にご連絡いたします。</p>
            <p>しばらくお待ちください。</p>
          </div>
          <div class="thanks-buttons">
            <a href="<?php echo home_url(); ?>" class="thanks-btn thanks-btn-primary">
              <i class="fas fa-home"></i> ホームに戻る
            </a>
            <button type="button" class="thanks-btn thanks-btn-secondary" onclick="modalManager.hide()">
              <i class="fas fa-times"></i> 閉じる
            </button>
          </div>
        </div>
      </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', modalHtml);
  }
};

// AJAX送信・モーダル管理（WordPress対応版）
const ajaxSubmitter = {
  async submit(event) {
    const { form } = getFormElements();
    if (!form) {
      console.error('フォームが見つかりません');
      return;
    }

    console.log('AJAX送信開始（WordPress環境）');

    // UI状態管理
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn ? submitBtn.textContent : '送信';
    
    form.classList.add('form-sending');
    if (submitBtn) {
      submitBtn.disabled = true;
      submitBtn.textContent = '送信中...';
    }

    try {
      // WordPress AJAX 送信
      const formData = new FormData(form);
      console.log('📤 送信データ:');
      for (let [key, value] of formData.entries()) {
        console.log(`${key}: ${value}`);
      }
      
      console.log('📍 送信先URL:', WP_ADMIN_POST_URL);

      const response = await fetch(WP_ADMIN_POST_URL, {
        method: 'POST',
        body: formData,
        credentials: 'same-origin'
      });

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const responseText = await response.text();
      console.log('サーバーレスポンス:', responseText);
      
      let result;
      try {
        result = JSON.parse(responseText);
      } catch (e) {
        // HTMLレスポンスの場合（リダイレクトなど）
        if (responseText.includes('success') || responseText.includes('完了')) {
          result = { success: true, data: { customer_name: 'お客様' } };
        } else {
          throw new Error('サーバーからの応答が正しくありません');
        }
      }
      
      if (result.success) {
        console.log('✅ 送信成功:', result.data);
        
        const customerName = result.data.customer_name || 'お客様';
        this.handleSuccess(customerName);
      } else {
        throw new Error(result.data?.message || '送信に失敗しました');
      }

    } catch (error) {
      console.error('送信エラー詳細:', error);
      console.error('送信先URL:', WP_ADMIN_POST_URL);
      console.error('フォームデータ:', formData);
      
      let errorMessage = '送信に失敗しました。しばらく時間をおいてお試しください。\n\n';
      errorMessage += `エラー: ${error.message}\n`;
      errorMessage += `送信先: ${WP_ADMIN_POST_URL}`;
      
      alert(errorMessage);
    } finally {
      // UI状態復元
      form.classList.remove('form-sending');
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
      }
    }
  },

  handleSuccess(customerName) {
    console.log('送信成功処理:', customerName);
    
    // フォームリセット
    const { form } = getFormElements();
    if (form) {
      form.reset();
    }
    
    // データクリア
    utils.storage.clear();
    
    // ステップ1に戻る
    if (window.stepFormManager) {
      window.stepFormManager.currentStep = 1;
      window.stepFormManager.updateUI();
    }
    
    // モーダル表示
    modalManager.show(customerName);
  }
};

// グローバルイベントリスナー
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') {
    modalManager.hide();
  }
});

document.addEventListener('click', (e) => {
  if (e.target?.id === 'thanksModal') {
    modalManager.hide();
  }
});

// グローバル関数（テンプレート用）
window.closeThanksModal = () => modalManager.hide();
window.modalManager = modalManager;

// 初期化（WordPress対応）
document.addEventListener('DOMContentLoaded', async () => {
  console.log('🔥 WordPress版リードフォーム初期化開始');
  
  try {
    const { form } = getFormElements();
    
    if (!form) {
      console.error('フォームが見つかりません');
      return;
    }

    // URLパラメータから初期値を設定
    const zip = utils.getUrlParam('zip');
    const propertyType = utils.getUrlParam('property-type');
    
    console.log('URLパラメータ:', { zip, propertyType });

    // 物件種別ラベル変換
    const propertyTypeLabels = {
      'mansion-unit': 'マンション（区分）',
      'house': '一戸建て',
      'land': '土地',
      'mansion-building': 'マンション一棟',
      'building': 'ビル一棟',
      'apartment-building': 'アパート一棟',
      'other': 'その他'
    };

    // 住所取得処理
    if (zip) {
      try {
        const address = await addressApi.fetchAddress(zip);
        addressApi.updateAddressFields(address);
        addressApi.initChomeSelect();
      } catch (error) {
        console.warn('住所取得に失敗しました:', error);
        document.querySelector('.js-pref-display').value = '';
        document.querySelector('.js-city-display').value = '';
        document.querySelector('.js-town-display').value = '';
      }
    }

    // ステップフォーム初期化
    const stepFormManager = new StepFormManager(propertyType || 'mansion-unit');
    window.stepFormManager = stepFormManager;

    console.log('✅ WordPress版リードフォーム初期化完了');
    
  } catch (error) {
    console.error('❌ WordPress版リードフォーム初期化エラー:', error);
  }
});

</script>

<?php wp_footer(); ?>
</body>
</html>