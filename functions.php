<?php
/**
 * RealEstate Leaseback Pro - functions.php
 * 不動産リースバック査定専用ランディングページテーマ
 * Version: 2.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// テーマ設定
define('LEASEBACK_THEME_VERSION', '2.0.0');
define('LEASEBACK_THEME_NAME', 'RealEstate Leaseback Pro');

// 基本設定（カスタマイズ可能）
if (!defined('LEASEBACK_ADMIN_EMAIL')) {
    define('LEASEBACK_ADMIN_EMAIL', 'info@sumitsuzuke-tai.jp');
}
if (!defined('LEASEBACK_PHONE_NUMBER')) {
    define('LEASEBACK_PHONE_NUMBER', '050-5810-5875');
}
if (!defined('LEASEBACK_COMPANY_NAME')) {
    define('LEASEBACK_COMPANY_NAME', 'リースバック住み続け隊');
}

// テーマサポート
function leaseback_pro_theme_support() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
}
add_action('after_setup_theme', 'leaseback_pro_theme_support');

// ブログ名を動的に変更
function leaseback_custom_blogname($name) {
    return 'リースバック住み続け隊';
}
add_filter('bloginfo_url', 'leaseback_custom_blogname');
add_filter('bloginfo', 'leaseback_custom_blogname');

// カスタム投稿タイプ「lead」を登録
function leaseback_pro_register_lead_post_type() {
    register_post_type('lead', array(
        'labels' => array(
            'name' => '査定依頼',
            'singular_name' => '査定依頼',
            'add_new' => '新規追加',
            'add_new_item' => '新しい査定依頼を追加',
            'edit_item' => '査定依頼を編集',
            'new_item' => '新しい査定依頼',
            'view_item' => '査定依頼を表示',
            'search_items' => '査定依頼を検索',
            'not_found' => '査定依頼が見つかりませんでした',
            'not_found_in_trash' => 'ゴミ箱に査定依頼は見つかりませんでした'
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-clipboard',
        'supports' => array('title', 'custom-fields'),
        'hierarchical' => false,
        'rewrite' => false,
        'query_var' => false
    ));
}
add_action('init', 'leaseback_pro_register_lead_post_type');

// 新しいモジュールを読み込み
require_once get_template_directory() . '/includes/class-cta-manager.php';

// LINE IDの設定（カスタマイズ必要）
add_action('init', 'leaseback_pro_setup_line_cta_system');
function leaseback_pro_setup_line_cta_system() {
    // 実際のLINE IDに変更してください
    // LINE IDは @ から始まるIDを設定します（例: @abc123def）
    $line_id = get_option('leaseback_line_id', '@377sitjf'); // 公式LINE ID設定済み
    if (class_exists('CTAManager')) {
        CTAManager::set_line_id($line_id);
    }
}

// スタイルとスクリプトの読み込み
function leaseback_enqueue_scripts() {
    // Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&family=Noto+Serif+JP:wght@500;700&display=swap', array(), null);
    
    // Font Awesome (最新版)
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');
    
    // 新しいCTA統合システム
    wp_enqueue_style('cta-system', get_template_directory_uri() . '/assets/css/cta-system.css', array(), '1.0.0');
    wp_enqueue_script('cta-system', get_template_directory_uri() . '/assets/js/cta-system.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'leaseback_enqueue_scripts');

// headタグ内にFont Awesomeを直接追加（バックアップ）
add_action('wp_head', 'leaseback_add_fontawesome');
function leaseback_add_fontawesome() {
    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">';
}

// WordPress管理画面にデバッグログ表示ページを追加

// AJAX ハンドラー（完全修正版）
add_action('admin_post_nopriv_lead_submit', 'ultimate_lead_submit');
add_action('admin_post_lead_submit', 'ultimate_lead_submit');

// AI査定専用AJAXハンドラー
add_action('wp_ajax_nopriv_ai_assessment_submit', 'handle_ai_assessment_submit');
add_action('wp_ajax_ai_assessment_submit', 'handle_ai_assessment_submit');

// AI査定テーブル作成
register_activation_hook(__FILE__, 'create_ai_assessment_table');
function create_ai_assessment_table() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'ai_assessments';
    
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(255) DEFAULT '匿名',
        email varchar(255) NOT NULL,
        property_type varchar(50) NOT NULL,
        area varchar(50) NOT NULL,
        age varchar(20) NOT NULL,
        size int(11) NOT NULL,
        station varchar(20) NOT NULL,
        estimated_price int(11) NOT NULL,
        estimated_low int(11) NOT NULL,
        estimated_high int(11) NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        ip_address varchar(45) NOT NULL,
        user_agent text,
        PRIMARY KEY (id)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    
    // nameカラムが存在しない場合は追加
    $column_exists = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'name'");
    if (empty($column_exists)) {
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN name varchar(255) DEFAULT '匿名' AFTER id");
    }
}

// 手動でテーブルを更新する関数
function update_ai_assessment_table() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'ai_assessments';
    
    // テーブルが存在しない場合は作成
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        create_ai_assessment_table();
        return;
    }
    
    // nameカラムが存在しない場合は追加
    $column_exists = $wpdb->get_results("SHOW COLUMNS FROM $table_name LIKE 'name'");
    if (empty($column_exists)) {
        $result = $wpdb->query("ALTER TABLE $table_name ADD COLUMN name varchar(255) DEFAULT '匿名' AFTER id");
        if ($result === false) {
            error_log('nameカラム追加エラー: ' . $wpdb->last_error);
        } else {
            error_log('nameカラム追加成功');
        }
    }
}

// テーブルを削除して再作成する関数（デバッグ用）
function recreate_ai_assessment_table() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'ai_assessments';
    
    // テーブルを削除
    $wpdb->query("DROP TABLE IF EXISTS $table_name");
    
    // テーブルを再作成
    create_ai_assessment_table();
    
    error_log('AI査定テーブルを再作成しました');
}

// URL経由でテーブルを再作成できるようにする（デバッグ用）
add_action('wp_ajax_recreate_ai_table', 'recreate_ai_assessment_table');
add_action('wp_ajax_nopriv_recreate_ai_table', 'recreate_ai_assessment_table');

// AI査定専用処理関数
function handle_ai_assessment_submit() {
    global $wpdb;
    
    try {
        // テーブル構造を確認・更新
        update_ai_assessment_table();
        
        // nonceチェック
        if (!wp_verify_nonce($_POST['nonce'], 'ai_assessment_nonce')) {
            wp_die('セキュリティエラーが発生しました。', 'セキュリティエラー', array('response' => 403));
        }
        
        // データ取得・検証
        $name = '匿名'; // 名前フィールドを削除したため固定値
        $email = sanitize_email($_POST['email']);
        $property_type = sanitize_text_field($_POST['property_type']);
        $area = sanitize_text_field($_POST['area']);
        $age = sanitize_text_field($_POST['age']);
        $size = intval($_POST['size']);
        $station = sanitize_text_field($_POST['station']);
        $estimated_price = intval($_POST['estimated_price']);
        $estimated_low = intval($_POST['estimated_low']);
        $estimated_high = intval($_POST['estimated_high']);
        
        // 必須項目チェック
        if (empty($email) || empty($property_type) || empty($area)) {
            wp_send_json_error('必須項目が入力されていません。');
            return;
        }
        
        // IPアドレスとユーザーエージェント取得
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        
        // データベースに保存
        $table_name = $wpdb->prefix . 'ai_assessments';
        $result = $wpdb->insert(
            $table_name,
            array(
                'name' => $name,
                'email' => $email,
                'property_type' => $property_type,
                'area' => $area,
                'age' => $age,
                'size' => $size,
                'station' => $station,
                'estimated_price' => $estimated_price,
                'estimated_low' => $estimated_low,
                'estimated_high' => $estimated_high,
                'ip_address' => $ip_address,
                'user_agent' => $user_agent
            ),
            array('%s', '%s', '%s', '%s', '%s', '%d', '%s', '%d', '%d', '%d', '%s', '%s')
        );
        
        if ($result === false) {
            error_log('AI査定データベース保存エラー: ' . $wpdb->last_error);
            error_log('保存データ: ' . print_r(array(
                'name' => $name,
                'email' => $email,
                'property_type' => $property_type,
                'area' => $area,
                'age' => $age,
                'size' => $size,
                'station' => $station,
                'estimated_price' => $estimated_price,
                'estimated_low' => $estimated_low,
                'estimated_high' => $estimated_high,
                'ip_address' => $ip_address,
                'user_agent' => $user_agent
            ), true));
            wp_send_json_error('データ保存に失敗しました。詳細: ' . $wpdb->last_error);
            return;
        }
        
        $assessment_id = $wpdb->insert_id;
        
        // 査定データ構造体作成
        $assessment_data = array(
            'id' => $assessment_id,
            'name' => $name,
            'email' => $email,
            'property_type' => $property_type,
            'area' => $area,
            'age' => $age,
            'size' => $size,
            'station' => $station,
            'estimated_price' => $estimated_price,
            'estimated_low' => $estimated_low,
            'estimated_high' => $estimated_high,
            'created_at' => current_time('mysql'),
            'ip_address' => $ip_address
        );
        
        // PDF生成を先に実行
        require_once get_template_directory() . '/includes/class-pdf-generator.php';
        $pdf_generator = new Leaseback_PDF_Generator($assessment_data);
        $pdf_result = $pdf_generator->generate();
        
        // PDFダウンロード情報を保存
        update_option('pdf_download_' . $assessment_id, array(
            'filename' => $pdf_result['filename'],
            'expires_at' => $pdf_result['expires_at']
        ));
        
        // 自動返信メール送信（PDFリンク付き）
        $mail_sent = send_ai_assessment_email($assessment_data, $pdf_result['download_url']);
        
        // Google Sheets送信
        $sheets_sent = send_ai_assessment_to_sheets($assessment_data);
        
        // 成功レスポンス
        wp_send_json_success(array(
            'assessment_id' => $assessment_id,
            'mail_sent' => $mail_sent,
            'sheets_sent' => $sheets_sent,
            'pdf_url' => $pdf_result['download_url'],
            'message' => 'AI査定結果をメールで送信しました。'
        ));
        
    } catch (Exception $e) {
        error_log('AI査定処理エラー: ' . $e->getMessage());
        wp_send_json_error('処理中にエラーが発生しました。');
    }
}

// AI査定メール送信
function send_ai_assessment_email($data, $pdf_url = '') {
    $customer_email = $data['email'];
    $admin_email = get_option('admin_email');
    
    // PDFダウンロードURLを追加
    $data['pdf_url'] = $pdf_url;
    
    // 顧客向けメール
    $customer_subject = 'リースバック活用ガイド（無料）をお送りします';
    $customer_message = build_ai_assessment_customer_email($data);
    
    $customer_mail_sent = wp_mail($customer_email, $customer_subject, $customer_message, [
        'Content-Type: text/html; charset=UTF-8',
        'From: リースバック住み続け隊 <' . $admin_email . '>'
    ]);
    
    if (!$customer_mail_sent) {
        error_log('顧客向けメール送信失敗: ' . $customer_email);
    }
    
    // 管理者向けメール
    $admin_subject = '【新規】AI査定申し込み - AI-' . $data['id'];
    $admin_message = build_ai_assessment_admin_email($data);
    
    $admin_mail_sent = wp_mail($admin_email, $admin_subject, $admin_message, [
        'Content-Type: text/html; charset=UTF-8'
    ]);
    
    if (!$admin_mail_sent) {
        error_log('管理者向けメール送信失敗: ' . $admin_email);
    }
    
    return $customer_mail_sent;
}

// 顧客向けメール内容
function build_ai_assessment_customer_email($data) {
    $assessment_id = $data['id'];
    $estimated_price = number_format($data['estimated_price']);
    $estimated_low = number_format($data['estimated_low']);
    $estimated_high = number_format($data['estimated_high']);
    
    return "
    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
        <h2 style='color: #2c5aa0; border-bottom: 2px solid #2c5aa0; padding-bottom: 10px;'>
            📊 リースバック活用ガイドをお送りします
        </h2>
        
        <p>お客様</p>
        
        <p>この度は、AI査定サービスをご利用いただき、ありがとうございます。</p>
        
        <div style='background-color: #f0f8ff; padding: 20px; border-radius: 8px; margin: 20px 0; border: 1px solid #2c5aa0;'>
            <h3 style='color: #2c5aa0; margin-top: 0;'>💰 AI査定結果</h3>
            <div style='background-color: #fff; padding: 15px; border-radius: 5px; text-align: center;'>
                <p style='margin: 0; color: #666; font-size: 14px;'>推定査定価格</p>
                <p style='margin: 10px 0; font-size: 24px; font-weight: bold; color: #2c5aa0;'>{$estimated_price}万円</p>
                <p style='margin: 0; color: #666; font-size: 12px;'>想定範囲: {$estimated_low}万円 〜 {$estimated_high}万円</p>
            </div>
            <p style='margin: 15px 0 0 0; font-size: 12px; color: #666;'>※ こちらは概算価格です。実際の査定額は物件の詳細によって変動します。</p>
        </div>
        
        <div style='background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;'>
            <h3 style='color: #2c5aa0; margin-top: 0;'>🎁 無料特典のご案内</h3>
            <p>査定結果と併せて、<strong>「リースバック活用ガイド」</strong>をプレゼントいたします。</p>
            <p>このガイドには、リースバック成功のポイントや注意点をまとめています。</p>
            
            " . (!empty($data['pdf_url']) ? "
            <div style='text-align: center; margin: 20px 0;'>
                <a href='{$data['pdf_url']}' style='display: inline-block; background: #2c5aa0; color: white; padding: 15px 30px; border-radius: 5px; text-decoration: none; font-size: 16px; font-weight: bold;'>
                    📥 活用ガイドをダウンロード
                </a>
                <p style='margin: 10px 0 0 0; font-size: 12px; color: #666;'>※ リンクは24時間有効です</p>
            </div>
            " : "") . "
            
            <div style='background-color: #fff; padding: 15px; border-radius: 5px; margin: 15px 0;'>
                <p style='margin: 0;'><strong>査定ID:</strong> AI-{$assessment_id}</p>
                <p style='margin: 5px 0 0 0;'><strong>申込日時:</strong> " . date('Y年m月d日 H:i') . "</p>
            </div>
        </div>
        
        <div style='background-color: #e8f4f8; padding: 20px; border-radius: 8px; margin: 20px 0;'>
            <h3 style='color: #2c5aa0; margin-top: 0;'>📞 さらに詳しい査定をご希望の場合</h3>
            <p>AI査定はあくまで概算です。より詳細な査定をご希望の場合は、お気軽にご連絡ください。</p>
            
            <div style='margin: 15px 0;'>
                <p style='margin: 5px 0;'><strong>📞 電話:</strong> 050-5810-5875</p>
                <p style='margin: 5px 0;'><strong>💬 LINE:</strong> @377sitjf</p>
            </div>
        </div>
        
        <div style='background-color: #fff3cd; padding: 15px; border-radius: 8px; margin: 20px 0;'>
            <h4 style='color: #856404; margin-top: 0;'>💡 リースバック成功のポイント</h4>
            <ul style='color: #856404; margin: 10px 0;'>
                <li>早めの相談で選択肢を広げる</li>
                <li>複数の条件を比較検討する</li>
                <li>契約内容をしっかり理解する</li>
            </ul>
        </div>
        
        <hr style='margin: 30px 0; border: none; border-top: 1px solid #ddd;'>
        
        <div style='font-size: 12px; color: #666; line-height: 1.6;'>
            <p><strong>リースバック住み続け隊</strong></p>
            <p>代表取締役　黒江 貴裕</p>
            <p>📞 050-5810-5875　💬 LINE: @377sitjf</p>
            <p>本メールは自動送信です。ご不明な点がございましたら、上記連絡先までお問い合わせください。</p>
        </div>
    </div>
    ";
}

// 管理者向けメール内容
function build_ai_assessment_admin_email($data) {
    return "
    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
        <h2 style='color: #dc3545; border-bottom: 2px solid #dc3545; padding-bottom: 10px;'>
            【新規】AI査定申し込み
        </h2>
        
        <table style='width: 100%; border-collapse: collapse; margin: 20px 0;'>
            <tr>
                <td style='padding: 10px; background-color: #f8f9fa; border: 1px solid #ddd; width: 120px;'><strong>申込日時</strong></td>
                <td style='padding: 10px; border: 1px solid #ddd;'>" . date('Y年m月d日 H:i:s') . "</td>
            </tr>
            <tr>
                <td style='padding: 10px; background-color: #f8f9fa; border: 1px solid #ddd;'><strong>査定ID</strong></td>
                <td style='padding: 10px; border: 1px solid #ddd;'>AI-{$data['id']}</td>
            </tr>
            <tr>
                <td style='padding: 10px; background-color: #f8f9fa; border: 1px solid #ddd;'><strong>名前</strong></td>
                <td style='padding: 10px; border: 1px solid #ddd;'>{$data['name']}</td>
            </tr>
            <tr>
                <td style='padding: 10px; background-color: #f8f9fa; border: 1px solid #ddd;'><strong>メールアドレス</strong></td>
                <td style='padding: 10px; border: 1px solid #ddd;'>{$data['email']}</td>
            </tr>
            <tr>
                <td style='padding: 10px; background-color: #f8f9fa; border: 1px solid #ddd;'><strong>物件種別</strong></td>
                <td style='padding: 10px; border: 1px solid #ddd;'>{$data['property_type']}</td>
            </tr>
            <tr>
                <td style='padding: 10px; background-color: #f8f9fa; border: 1px solid #ddd;'><strong>面積</strong></td>
                <td style='padding: 10px; border: 1px solid #ddd;'>{$data['area']}</td>
            </tr>
            <tr>
                <td style='padding: 10px; background-color: #f8f9fa; border: 1px solid #ddd;'><strong>築年数</strong></td>
                <td style='padding: 10px; border: 1px solid #ddd;'>{$data['age']}</td>
            </tr>
            <tr>
                <td style='padding: 10px; background-color: #f8f9fa; border: 1px solid #ddd;'><strong>サイズ</strong></td>
                <td style='padding: 10px; border: 1px solid #ddd;'>{$data['size']}</td>
            </tr>
            <tr>
                <td style='padding: 10px; background-color: #f8f9fa; border: 1px solid #ddd;'><strong>駅距離</strong></td>
                <td style='padding: 10px; border: 1px solid #ddd;'>{$data['station']}</td>
            </tr>
            <tr style='background-color: #f0f8ff;'>
                <td style='padding: 10px; background-color: #e8f4f8; border: 1px solid #ddd; font-weight: bold;'><strong>推定査定価格</strong></td>
                <td style='padding: 10px; border: 1px solid #ddd; font-weight: bold; color: #2c5aa0;'>" . number_format($data['estimated_price']) . "万円</td>
            </tr>
            <tr>
                <td style='padding: 10px; background-color: #f8f9fa; border: 1px solid #ddd;'><strong>想定範囲</strong></td>
                <td style='padding: 10px; border: 1px solid #ddd;'>" . number_format($data['estimated_low']) . "万円 〜 " . number_format($data['estimated_high']) . "万円</td>
            </tr>
            <tr>
                <td style='padding: 10px; background-color: #f8f9fa; border: 1px solid #ddd;'><strong>IPアドレス</strong></td>
                <td style='padding: 10px; border: 1px solid #ddd;'>{$data['ip_address']}</td>
            </tr>
        </table>
        
        <div style='background-color: #fff3cd; padding: 15px; border-radius: 8px; margin: 20px 0;'>
            <h4 style='color: #856404; margin-top: 0;'>📋 対応必要事項</h4>
            <ul style='color: #856404;'>
                <li>顧客への活用ガイド送付確認</li>
                <li>必要に応じて詳細査定の案内</li>
                <li>フォローアップ実施</li>
            </ul>
        </div>
    </div>
    ";
}

// Google Sheets送信（既存シートの別タブに統一）
function send_ai_assessment_to_sheets($data) {
    // 通常フォームと同じWebhook URLを使用
    $webhook_url = 'https://script.google.com/macros/s/AKfycbwJAEwKNqh1enhpjced1EYdzvWckPzsJ_QLOPVV9sO3vvs84K3Y1i6mBGcMYEHX-7o/exec';
    
    // 認証キーを追加
    $secret_key = 'sumitsu2025';
    
    // URLパラメータ形式で送信データを準備
    $sheets_data = array(
        'secret' => $secret_key,
        'sheet_name' => 'AI査定', // 別タブに記録
        'type' => 'ai_assessment',
        'lead_id' => 'AI-' . $data['id'],
        'timestamp' => date('Y-m-d H:i:s'),
        'assessment_id' => 'AI-' . $data['id'],
        'name' => $data['name'],
        'email' => $data['email'],
        'property_type' => $data['property_type'],
        'area' => $data['area'],
        'age' => $data['age'],
        'size' => $data['size'],
        'station' => $data['station'],
        'estimated_price' => $data['estimated_price'],
        'estimated_low' => $data['estimated_low'],
        'estimated_high' => $data['estimated_high'],
        'ip_address' => $data['ip_address']
    );
    
    // URLパラメータ形式でGET送信（通常フォームと同じ形式）
    $url_with_params = $webhook_url . '?' . http_build_query($sheets_data);
    
    $args = [
        'method' => 'GET',
        'timeout' => 30
    ];
    
    $response = wp_remote_get($url_with_params, $args);
    
    if (is_wp_error($response)) {
        error_log('Google Sheets送信エラー: ' . $response->get_error_message());
        return false;
    }
    
    $body = wp_remote_retrieve_body($response);
    $status_code = wp_remote_retrieve_response_code($response);
    
    if ($status_code !== 200) {
        error_log('Google Sheets送信エラー (HTTP ' . $status_code . '): ' . $body);
        return false;
    }
    
    error_log('Google Sheets送信成功: ' . $body);
    return true;
}

// PDFダウンロード処理
add_action('wp_ajax_download_assessment_pdf', 'handle_pdf_download');
add_action('wp_ajax_nopriv_download_assessment_pdf', 'handle_pdf_download');

function handle_pdf_download() {
    // パラメータ取得
    $assessment_id = isset($_GET['aid']) ? intval($_GET['aid']) : 0;
    $filename = isset($_GET['file']) ? sanitize_text_field($_GET['file']) : '';
    $expires = isset($_GET['expires']) ? intval($_GET['expires']) : 0;
    $token = isset($_GET['token']) ? sanitize_text_field($_GET['token']) : '';
    
    // 有効期限チェック
    if (time() > $expires) {
        wp_die('このリンクは有効期限が切れています。', 'エラー', array('response' => 403));
    }
    
    // トークン検証
    $expected_token = hash_hmac('sha256', $assessment_id . $filename . $expires, SECURE_AUTH_KEY);
    if (!hash_equals($expected_token, $token)) {
        wp_die('無効なリクエストです。', 'エラー', array('response' => 403));
    }
    
    // 保存されたPDF情報を確認
    $pdf_info = get_option('pdf_download_' . $assessment_id);
    if (!$pdf_info || $pdf_info['filename'] !== $filename) {
        wp_die('ファイルが見つかりません。', 'エラー', array('response' => 404));
    }
    
    // HTMLファイルのパス
    $html_file = get_template_directory() . '/pdfs/generated/' . $filename . '.html';
    
    if (!file_exists($html_file)) {
        wp_die('ファイルが見つかりません。', 'エラー', array('response' => 404));
    }
    
    // HTMLコンテンツを読み込む
    $html_content = file_get_contents($html_file);
    
    // ブラウザでHTMLとして表示（PDFとして印刷可能）
    header('Content-Type: text/html; charset=UTF-8');
    header('Content-Disposition: inline; filename="leaseback_guide.html"');
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    // 印刷用スタイルを追加
    $html_content = str_replace('</head>', '
    <style media="print">
        @page { size: A4; margin: 10mm; }
        .page { page-break-after: always; }
        .no-print { display: none; }
    </style>
    <script>
        // 自動で印刷ダイアログを開く
        window.onload = function() {
            setTimeout(function() {
                if (confirm("PDFとして保存しますか？\\n\\n「OK」をクリックして、印刷ダイアログで「PDFとして保存」を選択してください。")) {
                    window.print();
                }
            }, 1000);
        };
    </script>
    </head>', $html_content);
    
    // 操作ガイドを追加
    $guide = '<div class="no-print" style="background: #f0f0f0; padding: 20px; margin-bottom: 20px; text-align: center;">
        <h3>📄 PDFとして保存する方法</h3>
        <p>1. ブラウザの印刷機能（Ctrl+P または Cmd+P）を開く<br>
        2. 送信先で「PDFとして保存」を選択<br>
        3. 「保存」ボタンをクリック</p>
    </div>';
    
    $html_content = str_replace('<body>', '<body>' . $guide, $html_content);
    
    echo $html_content;
    
    // アクセスログ
    error_log('PDF downloaded - Assessment ID: ' . $assessment_id . ', IP: ' . $_SERVER['REMOTE_ADDR']);
    
    exit;
}

function ultimate_lead_submit() {
    try {
        // フォーム送信処理開始
        
        // nonceチェック（エラーでも処理続行）
        $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
        if (empty($nonce)) {
            error_log('⚠️ nonce未設定');
        } elseif (!wp_verify_nonce($nonce, 'lead_form_nonce')) {
            error_log('❌ nonce検証失敗: ' . $nonce);
        }
        
        // 完全フィールド定義（37項目）
        $all_fields = array(
            // 基本情報
            'zip', 'property-type', 'pref', 'city', 'town', 'chome', 
            'banchi', 'building_name', 'room_number',
            
            // 物件詳細
            'layout_rooms', 'layout_type', 
            'area', 'area_unit', 'building_area', 'building_area_unit', 
            'land_area', 'land_area_unit', 'age', 'other_type', 'total_units',
            
            // お客様情報
            'name', 'tel', 'email',
            
            // 備考・同意
            'remarks', 'land_remarks', 'agree',
            
            // 技術系
            'action', 'inq_type'
        );
        
        // 確実なデータ収集
        $collected_data = array();
        
        foreach ($all_fields as $field_name) {
            $value = '';
            
            if (isset($_POST[$field_name])) {
                $raw_value = wp_unslash($_POST[$field_name]);
                if (is_string($raw_value)) {
                    $value = sanitize_text_field($raw_value);
                } elseif (is_bool($raw_value) || $raw_value === 'on') {
                    $value = $raw_value ? '1' : '0'; // チェックボックス対応
                }
            } elseif (isset($_GET[$field_name])) {
                $raw_value = wp_unslash($_GET[$field_name]);
                $value = is_string($raw_value) ? sanitize_text_field($raw_value) : '';
            }
            
            $collected_data[$field_name] = $value;
            error_log("📝 [{$field_name}]: '{$value}'" . (empty($value) ? ' (空)' : ''));
        }
        
        // システム情報の自動追加
        $collected_data['processed_at'] = current_time('Y-m-d H:i:s');
        $collected_data['ip_address'] = $_SERVER['REMOTE_ADDR'] ?? '';
        $collected_data['user_agent'] = $_SERVER['HTTP_USER_AGENT'] ?? '';
        
        // 必須チェック（詳細版）
        $required_fields = ['name', 'tel', 'email', 'banchi'];
        $missing_fields = array();
        
        foreach ($required_fields as $required_field) {
            if (empty($collected_data[$required_field])) {
                $missing_fields[] = $required_field;
            }
        }
        
        if (!empty($missing_fields)) {
            throw new Exception('必須項目未入力: ' . implode(', ', $missing_fields));
        }
        
        // 完全住所生成
        $address_parts = array(
            $collected_data['pref'],
            $collected_data['city'], 
            $collected_data['town'],
            $collected_data['chome'] ? $collected_data['chome'] . '丁目' : '',
            $collected_data['banchi'],
            $collected_data['building_name'],
            $collected_data['room_number']
        );
        $collected_data['full_address'] = trim(implode(' ', array_filter($address_parts)));
        
        // カスタム投稿タイプ「lead」として保存
        $post_data = array(
            'post_title'   => $collected_data['name'] . ' - ' . current_time('Y-m-d H:i:s'),
            'post_content' => '',
            'post_status'  => 'publish',
            'post_type'    => 'lead',
            'meta_input'   => $collected_data
        );
        
        $post_id = wp_insert_post($post_data);
        
        if (is_wp_error($post_id)) {
            error_log('❌ WordPress投稿保存エラー: ' . $post_id->get_error_message());
        } else {
            error_log('✅ WordPress投稿保存成功: ID ' . $post_id);
            
            // カスタムフィールドに全データ保存
            foreach ($collected_data as $key => $value) {
                add_post_meta($post_id, $key, $value);
            }
        }
        
        // Google Sheets送信
        $sheets_success = send_to_google_sheets($collected_data);
        
        // メール送信
        $mail_success = send_notification_emails($collected_data);
        
        // 成功レスポンス
        wp_send_json_success(array(
            'message' => '査定依頼を受け付けました',
            'post_id' => $post_id,
            'sheets_sent' => $sheets_success,
            'mail_sent' => $mail_success,
            'customer_name' => $collected_data['name']
        ));
        
    } catch (Exception $e) {
        error_log('❌ 送信処理エラー: ' . $e->getMessage());
        wp_send_json_error(array(
            'message' => $e->getMessage()
        ));
    }
}

// Google Sheets送信機能
function send_to_google_sheets($data) {
    try {
        // Google Sheets Webhook URL
        $webhook_url = 'https://script.google.com/macros/s/AKfycbwJAEwKNqh1enhpjced1EYdzvWckPzsJ_QLOPVV9sO3vvs84K3Y1i6mBGcMYEHX-7o/exec';
        
        // Secret key for authentication
        $secret_key = 'sumitsu2025';
        
        // 送信データ準備
        $sheets_data = array(
            'secret' => $secret_key,
            'lead_id' => isset($data['lead_id']) ? $data['lead_id'] : uniqid(),
            'timestamp' => $data['processed_at'],
            'name' => $data['name'],
            'tel' => $data['tel'],
            'email' => $data['email'],
            'zip' => $data['zip'],
            'property_type' => $data['property-type'],
            'pref' => $data['pref'],
            'city' => $data['city'],
            'town' => $data['town'],
            'chome' => $data['chome'],
            'banchi' => $data['banchi'],
            'building_name' => $data['building_name'],
            'room_number' => $data['room_number'],
            'full_address' => $data['full_address'],
            'layout_rooms' => $data['layout_rooms'],
            'layout_type' => $data['layout_type'],
            'area' => $data['area'],
            'area_unit' => $data['area_unit'],
            'building_area' => $data['building_area'],
            'building_area_unit' => $data['building_area_unit'],
            'land_area' => $data['land_area'],
            'land_area_unit' => $data['land_area_unit'],
            'age' => $data['age'],
            'other_type' => $data['other_type'],
            'total_units' => $data['total_units'],
            'remarks' => $data['remarks'],
            'land_remarks' => $data['land_remarks'],
            'ip_address' => $data['ip_address']
        );
        
        // POST送信 (form-data形式で送信)
        error_log('📊 Google Sheets送信試行: ' . $webhook_url);
        
        // URL Parametersとして送信
        $url_with_params = $webhook_url . '?' . http_build_query($sheets_data);
        
        $response = wp_remote_get($url_with_params, array(
            'timeout' => 30,
            'sslverify' => false
        ));
        
        if (is_wp_error($response)) {
            error_log('❌ Google Sheets送信エラー: ' . $response->get_error_message());
            return false;
        }
        
        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);
        error_log('📊 Google Sheets レスポンス: HTTP ' . $response_code);
        
        if ($response_code === 200) {
            error_log('✅ Google Sheets送信成功');
            return true;
        } else {
            error_log('❌ Google Sheets送信失敗: HTTP ' . $response_code);
            return false;
        }
        
    } catch (Exception $e) {
        error_log('❌ Google Sheets送信例外: ' . $e->getMessage());
        return false;
    }
}

// メール送信機能
function send_notification_emails($data) {
    try {
        // デバッグ情報追加
        error_log('📧 メール送信開始 - send_notification_emails');
        error_log('📧 お客様名: ' . $data['name'] . ', Email: ' . $data['email']);
        
        // WordPress メール機能確認
        if (!function_exists('wp_mail')) {
            error_log('❌ wp_mail関数が利用できません');
            return false;
        }
        
        // SMTP設定確認
        $customer_name = $data['name'];
        $customer_email = $data['email'];
        $admin_email = 'info@sumitsuzuke-tai.jp';
        
        // 管理者向けメール
        $lead_id = isset($data['lead_id']) ? $data['lead_id'] : 'N/A';
        $admin_subject = '【株式会社クロフネチンタイ管理】新しい査定依頼 #' . $lead_id;
        $admin_message = build_admin_email_body($data, $lead_id);
        
        error_log('📧 管理者メール送信試行: ' . $admin_email);
        error_log('📧 管理者メール件名: ' . $admin_subject);
        
        $admin_sent = wp_mail($admin_email, $admin_subject, $admin_message, array(
            'Content-Type: text/html; charset=UTF-8'
        ));
        error_log('📧 管理者メール送信結果: ' . ($admin_sent ? '成功' : '失敗'));
        
        // wp_mailエラーを取得
        if (!$admin_sent) {
            global $phpmailer;
            if (isset($phpmailer) && is_object($phpmailer) && property_exists($phpmailer, 'ErrorInfo')) {
                error_log('📧 PHPMailerエラー: ' . $phpmailer->ErrorInfo);
            }
        }
        
        // お客様向け自動返信メール
        $customer_subject = '【株式会社クロフネチンタイ管理】査定依頼を受け付けました';
        $customer_message = build_customer_email_body($data);
        
        error_log('📧 お客様メール送信試行: ' . $customer_email);
        error_log('📧 お客様メール件名: ' . $customer_subject);
        
        $customer_sent = wp_mail($customer_email, $customer_subject, $customer_message, array(
            'Content-Type: text/html; charset=UTF-8'
        ));
        error_log('📧 お客様メール送信結果: ' . ($customer_sent ? '成功' : '失敗'));
        
        // wp_mailエラーを取得
        if (!$customer_sent) {
            global $phpmailer;
            if (isset($phpmailer) && is_object($phpmailer) && property_exists($phpmailer, 'ErrorInfo')) {
                error_log('📧 PHPMailerエラー: ' . $phpmailer->ErrorInfo);
            }
        }
        
        if ($admin_sent && $customer_sent) {
            error_log('✅ メール送信成功（管理者・お客様両方）');
            return true;
        } else {
            error_log('⚠️ メール送信一部失敗 - 管理者:' . ($admin_sent ? 'OK' : 'NG') . ' お客様:' . ($customer_sent ? 'OK' : 'NG'));
            return false;
        }
        
    } catch (Exception $e) {
        error_log('❌ メール送信例外: ' . $e->getMessage());
        return false;
    }
}

// 管理者向けメール本文生成
function build_admin_email_body($data, $lead_id = null) {
    $property_types = array(
        'mansion-unit' => 'マンション（区分）',
        'house' => '一戸建て',
        'land' => '土地',
        'mansion-building' => 'マンション一棟',
        'building' => 'ビル一棟',
        'apartment-building' => 'アパート一棟',
        'other' => 'その他'
    );
    
    $property_type_label = $property_types[$data['property-type']] ?? $data['property-type'];
    
    $message = '<html><body>';
    $message .= '<h2>査定依頼が届きました</h2>';
    $message .= '<h3>■ お客様情報</h3>';
    $message .= '<table border="1" cellpadding="5" cellspacing="0">';
    $message .= '<tr><td>お名前</td><td>' . esc_html($data['name']) . '</td></tr>';
    $message .= '<tr><td>電話番号</td><td>' . esc_html($data['tel']) . '</td></tr>';
    $message .= '<tr><td>メールアドレス</td><td>' . esc_html($data['email']) . '</td></tr>';
    $message .= '</table>';
    
    $message .= '<h3>■ 物件情報</h3>';
    $message .= '<table border="1" cellpadding="5" cellspacing="0">';
    $message .= '<tr><td>物件種別</td><td>' . esc_html($property_type_label) . '</td></tr>';
    $message .= '<tr><td>所在地</td><td>' . esc_html($data['full_address']) . '</td></tr>';
    $message .= '<tr><td>郵便番号</td><td>' . esc_html($data['zip']) . '</td></tr>';
    
    if (!empty($data['layout_rooms']) || !empty($data['layout_type'])) {
        $layout = $data['layout_rooms'] . $data['layout_type'];
        $message .= '<tr><td>間取り</td><td>' . esc_html($layout) . '</td></tr>';
    }
    
    if (!empty($data['area'])) {
        $message .= '<tr><td>専有面積</td><td>' . esc_html($data['area']) . esc_html($data['area_unit']) . '</td></tr>';
    }
    
    if (!empty($data['building_area'])) {
        $message .= '<tr><td>建物面積</td><td>' . esc_html($data['building_area']) . esc_html($data['building_area_unit']) . '</td></tr>';
    }
    
    if (!empty($data['land_area'])) {
        $message .= '<tr><td>土地面積</td><td>' . esc_html($data['land_area']) . esc_html($data['land_area_unit']) . '</td></tr>';
    }
    
    if (!empty($data['age'])) {
        $message .= '<tr><td>築年数</td><td>' . esc_html($data['age']) . '年</td></tr>';
    }
    
    if (!empty($data['total_units'])) {
        $message .= '<tr><td>総戸数</td><td>' . esc_html($data['total_units']) . '</td></tr>';
    }
    
    if (!empty($data['other_type'])) {
        $message .= '<tr><td>種類</td><td>' . esc_html($data['other_type']) . '</td></tr>';
    }
    
    $message .= '</table>';
    
    if (!empty($data['remarks'])) {
        $message .= '<h3>■ ご質問・ご要望</h3>';
        $message .= '<p>' . nl2br(esc_html($data['remarks'])) . '</p>';
    }
    
    if (!empty($data['land_remarks'])) {
        $message .= '<h3>■ 土地備考</h3>';
        $message .= '<p>' . nl2br(esc_html($data['land_remarks'])) . '</p>';
    }
    
    $message .= '<h3>■ システム情報</h3>';
    $message .= '<table border="1" cellpadding="5" cellspacing="0">';
    if ($lead_id) {
        $message .= '<tr><td>査定ID</td><td>' . esc_html($lead_id) . '</td></tr>';
        $message .= '<tr><td>管理画面</td><td><a href="' . admin_url("post.php?post={$lead_id}&action=edit") . '">編集ページを開く</a></td></tr>';
    }
    $message .= '<tr><td>送信日時</td><td>' . esc_html($data['processed_at']) . '</td></tr>';
    $message .= '<tr><td>IPアドレス</td><td>' . esc_html($data['ip_address']) . '</td></tr>';
    if (!empty($data['user_agent'])) {
        $message .= '<tr><td>ブラウザ情報</td><td>' . esc_html(substr($data['user_agent'], 0, 100)) . '</td></tr>';
    }
    $message .= '<tr><td>同意確認</td><td>' . (isset($data['agree']) && $data['agree'] === '1' ? '同意済み' : '未確認') . '</td></tr>';
    $message .= '</table>';
    
    $message .= '</body></html>';
    
    return $message;
}

// お客様向けメール本文生成
function build_customer_email_body($data) {
    $message = '<html><body>';
    $message .= '<h2>' . esc_html($data['name']) . '様</h2>';
    $message .= '<p>この度は、査定依頼をいただき誠にありがとうございます。</p>';
    $message .= '<p>ご依頼内容を確認いたしました。担当者より<strong>24時間以内</strong>にご連絡させていただきます。</p>';
    $message .= '<p>しばらくお待ちください。</p>';
    
    $message .= '<hr>';
    $message .= '<h3>■ ご依頼内容</h3>';
    $message .= '<p><strong>物件種別:</strong> ' . esc_html($data['property-type']) . '</p>';
    $message .= '<p><strong>所在地:</strong> ' . esc_html($data['full_address']) . '</p>';
    
    $message .= '<hr>';
    $message .= '<p><strong>株式会社クロフネチンタイ管理</strong><br>';
    $message .= 'TEL: 050-5810-5875<br>';
    $message .= '受付時間: 9:00〜19:00（年中無休）</p>';
    
    $message .= '</body></html>';
    
    return $message;
}

// WordPress管理画面カスタマイズ
function leaseback_admin_menu() {
    add_menu_page(
        '査定依頼一覧',
        '査定依頼',
        'manage_options',
        'leaseback-leads',
        'leaseback_leads_page',
        'dashicons-clipboard',
        25
    );
    
    // リライトルール設定ページも追加
    add_options_page(
        'リースバック設定',
        'リースバック設定', 
        'manage_options',
        'leaseback-settings',
        'leaseback_admin_page'
    );
}
add_action('admin_menu', 'leaseback_admin_menu');

// 投稿詳細ページに査定依頼詳細メタボックスを追加
add_action('add_meta_boxes', 'add_lead_details_meta_box');

function add_lead_details_meta_box() {
    add_meta_box(
        'lead_details',
        '査定依頼詳細（全37フィールド対応）',
        'lead_details_meta_box_callback',
        'lead',
        'normal',
        'high'
    );
}

function lead_details_meta_box_callback($post) {
    // 投稿のメタデータを取得
    $meta = get_post_meta($post->ID);
    
    // 査定依頼データがない場合は表示しない
    if (!isset($meta['zip']) && !isset($meta['property-type'])) {
        echo '<p>この投稿は査定依頼データではありません。</p>';
        return;
    }
    
    echo '<style>
    .lead-details-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    .lead-details-table th { background: #f9f9f9; font-weight: bold; width: 150px; padding: 8px; border: 1px solid #ddd; }
    .lead-details-table td { padding: 8px; border: 1px solid #ddd; }
    .section-header { background: #e8f4fd; font-weight: bold; text-align: center; }
    .empty-value { color: #999; font-style: italic; }
    </style>';
    
    echo '<table class="lead-details-table">';
    
    // 基本情報
    echo '<tr class="section-header"><th colspan="2">📍 基本情報</th></tr>';
    $basic_fields = array(
        'zip' => '郵便番号',
        'property-type' => '物件種別',
        'full_address' => '住所'
    );
    
    foreach ($basic_fields as $key => $label) {
        $value = isset($meta[$key][0]) ? $meta[$key][0] : '';
        if ($key === 'property-type' && $value) {
            $property_types = array(
                'mansion-unit' => 'マンション（区分）',
                'house' => '一戸建て',
                'land' => '土地',
                'mansion-building' => 'マンション一棟',
                'building' => 'ビル一棟',
                'apartment-building' => 'アパート一棟',
                'other' => 'その他'
            );
            $value = $property_types[$value] ?? $value;
        }
        $display_value = !empty($value) ? esc_html($value) : '<span class="empty-value">未入力</span>';
        echo "<tr><th>{$label}</th><td>{$display_value}</td></tr>";
    }
    
    // お客様情報
    echo '<tr class="section-header"><th colspan="2">👤 お客様情報</th></tr>';
    $customer_fields = array(
        'name' => 'お名前',
        'tel' => '電話番号',
        'email' => 'メールアドレス'
    );
    
    foreach ($customer_fields as $key => $label) {
        $value = isset($meta[$key][0]) ? $meta[$key][0] : '';
        $display_value = !empty($value) ? esc_html($value) : '<span class="empty-value">未入力</span>';
        echo "<tr><th>{$label}</th><td>{$display_value}</td></tr>";
    }
    
    // 物件詳細
    echo '<tr class="section-header"><th colspan="2">🏢 物件詳細</th></tr>';
    $property_fields = array(
        'layout_rooms' => '間取り（部屋数）',
        'layout_type' => '間取り（タイプ）',
        'area' => '専有面積',
        'building_area' => '建物面積',
        'land_area' => '土地面積',
        'age' => '築年数'
    );
    
    foreach ($property_fields as $key => $label) {
        $value = isset($meta[$key][0]) ? $meta[$key][0] : '';
        if ($key === 'age' && $value === '31') {
            $value = '31年以上・正確に覚えていない';
        } elseif (in_array($key, ['area', 'building_area', 'land_area']) && $value) {
            $unit_key = $key . '_unit';
            $unit = isset($meta[$unit_key][0]) ? $meta[$unit_key][0] : '㎡';
            $value = $value . $unit;
        } elseif ($key === 'age' && $value) {
            $value = $value . '年';
        }
        $display_value = !empty($value) ? esc_html($value) : '<span class="empty-value">未入力</span>';
        echo "<tr><th>{$label}</th><td>{$display_value}</td></tr>";
    }
    
    // システム情報
    echo '<tr class="section-header"><th colspan="2">🔧 システム情報</th></tr>';
    $system_fields = array(
        'processed_at' => '送信日時',
        'ip_address' => 'IPアドレス',
        'user_agent' => 'ブラウザ情報'
    );
    
    foreach ($system_fields as $key => $label) {
        $value = isset($meta[$key][0]) ? $meta[$key][0] : '';
        if ($key === 'user_agent' && $value) {
            $value = substr($value, 0, 100) . '...';
        }
        $display_value = !empty($value) ? esc_html($value) : '<span class="empty-value">未取得</span>';
        echo "<tr><th>{$label}</th><td>{$display_value}</td></tr>";
    }
    
    echo '</table>';
}

function leaseback_leads_page() {
    echo '<div class="wrap">';
    echo '<h1>査定依頼一覧</h1>';
    echo '<p>査定依頼は投稿として保存されています。詳細は「投稿 > 投稿一覧」からご確認ください。</p>';
    echo '</div>';
}

// カスタムページテンプレートのURLルーティング設定
add_action('init', 'leaseback_custom_rewrite_rules');
add_filter('query_vars', 'leaseback_add_query_vars');
add_action('template_redirect', 'leaseback_template_redirect');

function leaseback_custom_rewrite_rules() {
    // 下層ページのURL設定
    add_rewrite_rule('^company/?$', 'index.php?page_template=company', 'top');
    add_rewrite_rule('^privacy/?$', 'index.php?page_template=privacy', 'top');
    add_rewrite_rule('^terms/?$', 'index.php?page_template=terms', 'top');
    add_rewrite_rule('^lead-step2/?$', 'index.php?page_template=lead-step2', 'top');
}

// テーマ有効化時にリライトルールをフラッシュ
add_action('after_switch_theme', 'leaseback_flush_rewrite_rules');
add_action('init', 'leaseback_force_flush_rewrite_rules');

function leaseback_flush_rewrite_rules() {
    leaseback_custom_rewrite_rules();
    flush_rewrite_rules();
}

// 強制的にリライトルールを再登録（テーマ更新時）
function leaseback_force_flush_rewrite_rules() {
    // Version 1.7用に強制フラッシュ
    if (!get_option('leaseback_rewrite_flushed_v1.7')) {
        leaseback_custom_rewrite_rules();
        flush_rewrite_rules();
        update_option('leaseback_rewrite_flushed_v1.7', true);
        
        // 古いバージョンのオプションも削除
        delete_option('leaseback_rewrite_flushed_v1.5');
        delete_option('leaseback_rewrite_flushed_v1.6');
    }
}

function leaseback_add_query_vars($vars) {
    $vars[] = 'page_template';
    return $vars;
}

function leaseback_template_redirect() {
    $page_template = get_query_var('page_template');
    
    if (!$page_template) return;
    
    $template_path = get_template_directory() . '/page-' . $page_template . '.php';
    
    if (file_exists($template_path)) {
        include $template_path;
        exit;
    }
}

// 管理画面のカスタマイズ - カスタム投稿タイプ「lead」のカラム設定
add_filter('manage_lead_posts_columns', 'custom_lead_columns');
function custom_lead_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = '顧客名';
    $new_columns['lead_id'] = 'Lead ID';
    $new_columns['property_type'] = '物件種別';
    $new_columns['address'] = '住所';
    $new_columns['contact'] = '連絡先';
    $new_columns['date'] = '受付日時';
    return $new_columns;
}

add_action('manage_lead_posts_custom_column', 'custom_lead_column_data', 10, 2);
function custom_lead_column_data($column, $post_id) {
    $meta = get_post_meta($post_id);
    
    switch ($column) {
        case 'lead_id':
            echo $post_id;
            break;
        case 'property_type':
            $type = isset($meta['property-type'][0]) ? $meta['property-type'][0] : '';
            $types = array(
                'mansion-unit' => 'マンション（区分）',
                'house' => '一戸建て',
                'land' => '土地',
                'mansion-building' => 'マンション一棟',
                'building' => 'ビル一棟',
                'apartment-building' => 'アパート一棟',
                'other' => 'その他'
            );
            echo $types[$type] ?? $type;
            break;
        case 'address':
            $address = isset($meta['full_address'][0]) ? $meta['full_address'][0] : '';
            if (!$address) {
                $pref = isset($meta['pref'][0]) ? $meta['pref'][0] : '';
                $city = isset($meta['city'][0]) ? $meta['city'][0] : '';
                $address = $pref . ' ' . $city;
            }
            echo esc_html(substr($address, 0, 30) . (strlen($address) > 30 ? '...' : ''));
            break;
        case 'contact':
            $tel = isset($meta['tel'][0]) ? $meta['tel'][0] : '';
            $email = isset($meta['email'][0]) ? $meta['email'][0] : '';
            if ($tel) echo '<div>📞 ' . esc_html($tel) . '</div>';
            if ($email) echo '<div>✉️ ' . esc_html($email) . '</div>';
            break;
    }
}

// リライトルール設定ページの表示関数
function leaseback_admin_page() {
    if (isset($_POST['flush_rewrite_rules'])) {
        leaseback_custom_rewrite_rules();
        flush_rewrite_rules();
        delete_option('leaseback_rewrite_flushed_v1.7');
        echo '<div class="notice notice-success"><p>リライトルールを更新しました！</p></div>';
    }
    
    echo '<div class="wrap">';
    echo '<h1>リースバック設定</h1>';
    echo '<form method="post">';
    echo '<h2>URL設定</h2>';
    echo '<p>以下のURLが正常に動作するか確認してください：</p>';
    echo '<ul>';
    echo '<li><a href="' . home_url('/lead-step2/') . '" target="_blank">' . home_url('/lead-step2/') . '</a></li>';
    echo '<li><a href="' . home_url('/company/') . '" target="_blank">' . home_url('/company/') . '</a></li>';
    echo '<li><a href="' . home_url('/privacy/') . '" target="_blank">' . home_url('/privacy/') . '</a></li>';
    echo '<li><a href="' . home_url('/terms/') . '" target="_blank">' . home_url('/terms/') . '</a></li>';
    echo '</ul>';
    echo '<p><button type="submit" name="flush_rewrite_rules" class="button button-primary">リライトルールを強制更新</button></p>';
    echo '</form>';
    
    echo '<h2>デバッグ情報</h2>';
    echo '<h3>メール機能テスト</h3>';
    echo '<p>wp_mail関数: ' . (function_exists('wp_mail') ? '✅ 利用可能' : '❌ 利用不可') . '</p>';
    echo '<p>PHP mail関数: ' . (function_exists('mail') ? '✅ 利用可能' : '❌ 利用不可') . '</p>';
    
    echo '<h3>WordPress設定確認</h3>';
    echo '<p>WP_DEBUG: ' . (defined('WP_DEBUG') && WP_DEBUG ? '✅ 有効' : '❌ 無効') . '</p>';
    echo '<p>WP_DEBUG_LOG: ' . (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG ? '✅ 有効' : '❌ 無効') . '</p>';
    
    echo '<h3>wp-config.php に追加すべき設定</h3>';
    echo '<pre>define("WP_DEBUG", true);
define("WP_DEBUG_LOG", true);
define("WP_DEBUG_DISPLAY", false);</pre>';
    
    echo '<h3>エラーログ確認</h3>';
    $log_file = WP_CONTENT_DIR . '/debug.log';
    if (file_exists($log_file)) {
        $log_content = file_get_contents($log_file);
        $recent_logs = array_slice(explode("\n", $log_content), -50); // 最新50行
        echo '<textarea rows="10" cols="100" readonly>' . esc_textarea(implode("\n", $recent_logs)) . '</textarea>';
    } else {
        echo '<p>デバッグログファイルが見つかりません: ' . $log_file . '</p>';
        echo '<p>wp-config.php でデバッグログを有効にしてください。</p>';
    }
    
    echo '</div>';
}
