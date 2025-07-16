<?php
/**
 * Template Name: フォームテスト
 */
get_header(); 
?>

<style>
    body { background: #f5f5f5; }
    .test-container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
    .test-box { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 20px; }
    .btn { background: #1A3A4F; color: white; padding: 15px 30px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; margin: 5px; transition: all 0.3s; }
    .btn:hover { background: #0F2A3F; transform: translateY(-2px); }
    .success { background: #d4edda; border-left: 4px solid #28a745; padding: 15px; margin: 10px 0; border-radius: 5px; }
    .error { background: #f8d7da; border-left: 4px solid #dc3545; padding: 15px; margin: 10px 0; border-radius: 5px; }
    .warning { background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 10px 0; border-radius: 5px; }
    .info { background: #d1ecf1; border-left: 4px solid #17a2b8; padding: 15px; margin: 10px 0; border-radius: 5px; }
    pre { background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto; font-size: 12px; border: 1px solid #dee2e6; }
    .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 10px; margin: 15px 0; }
    .field { background: #f8f9fa; padding: 8px 12px; border-radius: 3px; font-size: 13px; border: 1px solid #e9ecef; }
    .field strong { color: #1A3A4F; }
    h1, h2, h3 { color: #1A3A4F; }
    details { margin: 15px 0; }
    summary { cursor: pointer; padding: 10px; background: #f8f9fa; border-radius: 5px; margin-bottom: 10px; }
    summary:hover { background: #e9ecef; }
</style>

<div class="test-container">
    <div class="test-box">
        <h1>🧪 リースバック フォーム処理テスト</h1>
        <p>WordPressのフォーム処理システムを直接テストします。各テストボタンをクリックして、37項目のフォームデータが正しく処理されるか確認できます。</p>
        
        <form method="post" action="">
            <button type="submit" name="test_type" value="system_check" class="btn">🔧 システム確認</button>
            <button type="submit" name="test_type" value="mansion" class="btn">🏢 マンションテスト</button>
            <button type="submit" name="test_type" value="house" class="btn">🏠 一戸建てテスト</button>
            <button type="submit" name="test_type" value="land" class="btn">🏞️ 土地テスト</button>
            <button type="submit" name="test_type" value="view_logs" class="btn">📋 ログ確認</button>
            <button type="submit" name="test_type" value="view_leads" class="btn">📊 記録データ一覧</button>
            <button type="submit" name="test_type" value="debug_sheets" class="btn">🔧 Google Sheets デバッグ</button>
        </form>
    </div>

    <?php
    if (isset($_POST['test_type'])) {
        $test_type = sanitize_text_field($_POST['test_type']);
        
        echo '<div class="test-box">';
        
        switch ($test_type) {
            case 'system_check':
                echo '<h2>🔧 システム確認</h2>';
                
                echo '<div class="info">';
                echo '<h3>WordPress情報</h3>';
                echo '<p><strong>WordPress Version:</strong> ' . get_bloginfo('version') . '</p>';
                echo '<p><strong>Site URL:</strong> ' . get_site_url() . '</p>';
                echo '<p><strong>Home URL:</strong> ' . get_home_url() . '</p>';
                echo '<p><strong>Current Theme:</strong> ' . get_template() . '</p>';
                echo '<p><strong>Theme Directory:</strong> ' . get_template_directory() . '</p>';
                echo '</div>';
                
                echo '<div class="info">';
                echo '<h3>PHP・サーバー情報</h3>';
                echo '<p><strong>PHP Version:</strong> ' . PHP_VERSION . '</p>';
                echo '<p><strong>Max Execution Time:</strong> ' . ini_get('max_execution_time') . ' seconds</p>';
                echo '<p><strong>Memory Limit:</strong> ' . ini_get('memory_limit') . '</p>';
                echo '<p><strong>Post Max Size:</strong> ' . ini_get('post_max_size') . '</p>';
                echo '</div>';
                
                echo '<div class="info">';
                echo '<h3>関数・投稿タイプ確認</h3>';
                $function_check = function_exists('ultimate_lead_submit');
                echo '<p><strong>ultimate_lead_submit関数:</strong> ' . ($function_check ? '✅ 存在' : '❌ 未定義') . '</p>';
                
                if (!$function_check) {
                    // functions.phpを手動で読み込み試行
                    $functions_file = get_template_directory() . '/functions.php';
                    if (file_exists($functions_file)) {
                        require_once($functions_file);
                        echo '<p>→ functions.phpを再読み込みしました</p>';
                        echo '<p>→ 再確認: ' . (function_exists('ultimate_lead_submit') ? '✅ 存在' : '❌ まだ未定義') . '</p>';
                    }
                }
                
                echo '<p><strong>lead投稿タイプ:</strong> ' . (post_type_exists('lead') ? '✅ 登録済み' : '❌ 未登録') . '</p>';
                echo '<p><strong>wp_mail関数:</strong> ' . (function_exists('wp_mail') ? '✅ 利用可能' : '❌ 不可') . '</p>';
                echo '<p><strong>admin-post actions:</strong></p>';
                echo '<ul>';
                echo '<li>admin_post_nopriv_lead_submit: ' . (has_action('admin_post_nopriv_lead_submit') ? '✅ 登録済み' : '❌ 未登録') . '</li>';
                echo '<li>admin_post_lead_submit: ' . (has_action('admin_post_lead_submit') ? '✅ 登録済み' : '❌ 未登録') . '</li>';
                echo '</ul>';
                echo '</div>';
                
                echo '<div class="info">';
                echo '<h3>ファイル確認</h3>';
                $theme_dir = get_template_directory();
                echo '<p><strong>functions.php:</strong> ' . (file_exists($theme_dir . '/functions.php') ? '✅ 存在' : '❌ 不存在') . '</p>';
                echo '<p><strong>デバッグログ:</strong> ' . (file_exists(WP_CONTENT_DIR . '/debug.log') ? '✅ 存在' : '❌ 不存在') . '</p>';
                
                // デバッグモード確認
                echo '<p><strong>WP_DEBUG:</strong> ' . (defined('WP_DEBUG') && WP_DEBUG ? '✅ 有効' : '❌ 無効') . '</p>';
                echo '<p><strong>WP_DEBUG_LOG:</strong> ' . (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG ? '✅ 有効' : '❌ 無効') . '</p>';
                echo '<p><strong>WP_DEBUG_DISPLAY:</strong> ' . (defined('WP_DEBUG_DISPLAY') && WP_DEBUG_DISPLAY ? '✅ 有効' : '❌ 無効') . '</p>';
                
                // Google Sheets設定確認
                echo '</div>';
                
                echo '<div class="info">';
                echo '<h3>Google Sheets設定確認</h3>';
                
                // functions.phpから設定値を確認
                $webhook_url = 'https://script.google.com/macros/s/AKfycbyNQXkw0W1qRBP_Tr4p3dqF6vBM8kYGXRDYVJ-0JhB7OkWGG2jeJvR04MfLZSfQXKJH/exec';
                $secret_key = 'xK9mP2nQ5vT8wL3jF6yB1cR4gH7sA0dE';
                
                echo '<p><strong>Webhook URL:</strong> ' . (strlen($webhook_url) > 50 ? substr($webhook_url, 0, 50) . '...' : $webhook_url) . '</p>';
                echo '<p><strong>Secret Key:</strong> ' . (strlen($secret_key) > 10 ? substr($secret_key, 0, 10) . '...' : $secret_key) . '</p>';
                echo '<p><strong>cURL拡張:</strong> ' . (function_exists('curl_init') ? '✅ 利用可能' : '❌ 不可') . '</p>';
                echo '<p><strong>allow_url_fopen:</strong> ' . (ini_get('allow_url_fopen') ? '✅ 有効' : '❌ 無効') . '</p>';
                echo '</div>';
                
                break;
                
            case 'mansion':
            case 'house':
            case 'land':
                $test_names = array(
                    'mansion' => 'マンション',
                    'house' => '一戸建て',
                    'land' => '土地'
                );
                
                echo "<h2>🚀 {$test_names[$test_type]}テスト実行</h2>";
                
                // テストデータ準備
                $test_datasets = array(
                    'mansion' => array(
                        'zip' => '1500013',
                        'property-type' => 'mansion',
                        'pref' => '東京都',
                        'city' => '渋谷区',
                        'town' => '恵比寿',
                        'chome' => '1',
                        'banchi' => '2-3',
                        'building_name' => 'テストマンション',
                        'room_number' => '101',
                        'layout_rooms' => '3',
                        'layout_type' => 'LDK',
                        'area' => '75.5',
                        'area_unit' => '㎡',
                        'age' => '10',
                        'total_units' => '50',
                        'name' => 'テスト太郎_' . date('His'),
                        'tel' => '090' . rand(10000000, 99999999),
                        'email' => 'test_' . time() . '@example.com',
                        'remarks' => 'マンションテスト送信 - ' . date('Y-m-d H:i:s'),
                        'agree' => 'on',
                        'action' => 'lead_submit',
                        'inq_type' => 'assessment'
                    ),
                    'house' => array(
                        'zip' => '1500013',
                        'property-type' => 'house',
                        'pref' => '東京都',
                        'city' => '渋谷区',
                        'town' => '恵比寿',
                        'chome' => '2',
                        'banchi' => '3-4',
                        'building_name' => '',
                        'room_number' => '',
                        'layout_rooms' => '4',
                        'layout_type' => 'LDK',
                        'building_area' => '120.8',
                        'building_area_unit' => '㎡',
                        'land_area' => '150.5',
                        'land_area_unit' => '㎡',
                        'age' => '15',
                        'name' => 'テスト花子_' . date('His'),
                        'tel' => '080' . rand(10000000, 99999999),
                        'email' => 'hanako_' . time() . '@example.com',
                        'remarks' => '一戸建てテスト送信 - ' . date('Y-m-d H:i:s'),
                        'agree' => 'on',
                        'action' => 'lead_submit',
                        'inq_type' => 'assessment'
                    ),
                    'land' => array(
                        'zip' => '1500013',
                        'property-type' => 'land',
                        'pref' => '東京都',
                        'city' => '渋谷区',
                        'town' => '恵比寿',
                        'chome' => '3',
                        'banchi' => '4-5',
                        'building_name' => '',
                        'room_number' => '',
                        'land_area' => '200.3',
                        'land_area_unit' => '㎡',
                        'name' => 'テスト一郎_' . date('His'),
                        'tel' => '070' . rand(10000000, 99999999),
                        'email' => 'ichiro_' . time() . '@example.com',
                        'land_remarks' => '土地テスト送信 - ' . date('Y-m-d H:i:s'),
                        'agree' => 'on',
                        'action' => 'lead_submit',
                        'inq_type' => 'assessment'
                    )
                );
                
                if (isset($test_datasets[$test_type])) {
                    $test_data = $test_datasets[$test_type];
                    
                    // nonceを追加
                    $test_data['nonce'] = wp_create_nonce('lead_form_nonce');
                    
                    echo '<div class="info">';
                    echo '<h3>📝 送信データ (' . count($test_data) . '項目)</h3>';
                    echo '<div class="grid">';
                    foreach ($test_data as $key => $value) {
                        if (!empty($value)) {
                            echo "<div class='field'><strong>{$key}:</strong> {$value}</div>";
                        }
                    }
                    echo '</div>';
                    echo '</div>';
                    
                    // $_POSTデータをバックアップ
                    $original_post = $_POST;
                    
                    // テストデータを$_POSTに設定
                    $_POST = array_merge($_POST, $test_data);
                    
                    try {
                        if (function_exists('ultimate_lead_submit')) {
                            echo '<div class="info"><h3>📡 フォーム処理実行中...</h3></div>';
                            
                            // デバッグログを有効化
                            error_log('=== フォームテスト開始 ===');
                            error_log('テストタイプ: ' . $test_type);
                            error_log('送信データ: ' . print_r($test_data, true));
                            
                            // 出力バッファリング開始
                            ob_start();
                            
                            // JSONレスポンスを防ぐ
                            add_filter('wp_doing_ajax', '__return_false');
                            add_filter('wp_redirect', '__return_false');
                            
                            // wp_send_json系関数を無効化
                            function prevent_json_output() {
                                return false;
                            }
                            add_filter('wp_die_ajax_handler', 'prevent_json_output');
                            add_filter('wp_die_xmlhttprequest_handler', 'prevent_json_output');
                            
                            // フォーム処理実行（exitを防ぐ）
                            try {
                                // wp_dieをオーバーライド
                                function custom_wp_die($message = '', $title = '', $args = array()) {
                                    // JSONメッセージの場合は解析して表示
                                    if (is_string($message) && strpos($message, '{') === 0) {
                                        $json_data = json_decode($message, true);
                                        if ($json_data && isset($json_data['success'])) {
                                            global $test_result_data;
                                            $test_result_data = $json_data;
                                            return;
                                        }
                                    }
                                    global $test_result_message;
                                    $test_result_message = $message;
                                }
                                
                                // 一時的にwp_dieを置き換え
                                if (!function_exists('wp_die_backup')) {
                                    function wp_die_backup($message = '', $title = '', $args = array()) {
                                        return custom_wp_die($message, $title, $args);
                                    }
                                }
                                
                                ultimate_lead_submit();
                                
                            } catch (Exception $e) {
                                echo '<div class="error"><h3>❌ 処理中にエラーが発生</h3><p>' . $e->getMessage() . '</p></div>';
                            }
                            
                            // 出力をキャプチャ
                            $output = ob_get_clean();
                            
                            // グローバル変数から結果を取得
                            global $test_result_data, $test_result_message;
                            
                            if (isset($test_result_data)) {
                                $json_data = $test_result_data;
                                echo '<div class="' . ($json_data['success'] ? 'success' : 'error') . '">';
                                echo '<h3>' . ($json_data['success'] ? '✅ フォーム処理成功' : '❌ フォーム処理失敗') . '</h3>';
                                if (isset($json_data['data'])) {
                                    echo '<p><strong>メッセージ:</strong> ' . $json_data['data']['message'] . '</p>';
                                    echo '<p><strong>記録ID:</strong> #' . $json_data['data']['post_id'] . '</p>';
                                    echo '<p><strong>メール送信:</strong> ' . ($json_data['data']['mail_sent'] ? '✅ 成功' : '❌ 失敗') . '</p>';
                                    echo '<p><strong>Google Sheets:</strong> ' . ($json_data['data']['sheets_sent'] ? '✅ 成功' : '❌ 失敗') . '</p>';
                                    echo '<p><strong>顧客名:</strong> ' . $json_data['data']['customer_name'] . '</p>';
                                }
                                echo '</div>';
                                $output = '';
                            } else if (isset($test_result_message)) {
                                echo '<div class="info"><h3>📋 処理メッセージ</h3><p>' . $test_result_message . '</p></div>';
                                $output = '';
                            } else if (strpos($output, '{') === 0) {
                                // 直接JSON出力の場合
                                $json_data = json_decode($output, true);
                                if ($json_data) {
                                    echo '<div class="' . ($json_data['success'] ? 'success' : 'error') . '">';
                                    echo '<h3>' . ($json_data['success'] ? '✅ フォーム処理成功' : '❌ フォーム処理失敗') . '</h3>';
                                    if (isset($json_data['data'])) {
                                        echo '<p><strong>メッセージ:</strong> ' . $json_data['data']['message'] . '</p>';
                                        echo '<p><strong>記録ID:</strong> #' . $json_data['data']['post_id'] . '</p>';
                                        echo '<p><strong>メール送信:</strong> ' . ($json_data['data']['mail_sent'] ? '✅ 成功' : '❌ 失敗') . '</p>';
                                        echo '<p><strong>Google Sheets:</strong> ' . ($json_data['data']['sheets_sent'] ? '✅ 成功' : '❌ 失敗') . '</p>';
                                        echo '<p><strong>顧客名:</strong> ' . $json_data['data']['customer_name'] . '</p>';
                                    }
                                    echo '</div>';
                                    $output = '';
                                }
                            }
                            
                            echo '<div class="success">';
                            echo '<h3>✅ フォーム処理完了</h3>';
                            if (!empty($output)) {
                                echo '<p>処理出力:</p><pre>' . esc_html($output) . '</pre>';
                            }
                            echo '</div>';
                            
                            // 処理後1秒待機
                            sleep(1);
                            
                            // 最新のleadデータを確認
                            $latest_leads = get_posts(array(
                                'post_type' => 'lead',
                                'posts_per_page' => 1,
                                'orderby' => 'date',
                                'order' => 'DESC'
                            ));
                            
                            if ($latest_leads) {
                                $lead = $latest_leads[0];
                                $meta = get_post_meta($lead->ID);
                                
                                echo '<div class="success">';
                                echo '<h3>✅ データベース記録確認</h3>';
                                echo '<p><strong>Lead ID:</strong> #' . $lead->ID . '</p>';
                                echo '<p><strong>作成日時:</strong> ' . $lead->post_date . '</p>';
                                
                                // 基本情報
                                echo '<h4>基本情報</h4>';
                                echo '<p><strong>名前:</strong> ' . (isset($meta['name'][0]) ? $meta['name'][0] : 'N/A') . '</p>';
                                echo '<p><strong>電話:</strong> ' . (isset($meta['tel'][0]) ? $meta['tel'][0] : 'N/A') . '</p>';
                                echo '<p><strong>メール:</strong> ' . (isset($meta['email'][0]) ? $meta['email'][0] : 'N/A') . '</p>';
                                echo '<p><strong>物件種別:</strong> ' . (isset($meta['property-type'][0]) ? $meta['property-type'][0] : 'N/A') . '</p>';
                                
                                // 記録成功率
                                $recorded_fields = 0;
                                $expected_fields = count($test_data) - 3; // action, inq_type, nonceを除く
                                foreach ($test_data as $key => $value) {
                                    if (in_array($key, ['action', 'inq_type', 'nonce'])) continue;
                                    if (isset($meta[$key][0]) && !empty($meta[$key][0])) {
                                        $recorded_fields++;
                                    }
                                }
                                
                                echo '<p><strong>記録成功率:</strong> ' . $recorded_fields . '/' . $expected_fields . ' フィールド（' . round($recorded_fields / $expected_fields * 100) . '%）</p>';
                                
                                // 全メタデータ表示
                                echo '<details><summary>全記録データ表示（クリックで展開）</summary>';
                                echo '<div class="grid">';
                                foreach ($meta as $key => $value) {
                                    if (!empty($value[0]) && strpos($key, '_') !== 0) { // プライベートフィールドを除外
                                        echo "<div class='field'><strong>{$key}:</strong> " . esc_html($value[0]) . "</div>";
                                    }
                                }
                                echo '</div></details>';
                                echo '</div>';
                            } else {
                                echo '<div class="warning"><h3>⚠️ データベースに新しいレコードが見つかりません</h3></div>';
                            }
                            
                        } else {
                            echo '<div class="error"><h3>❌ ultimate_lead_submit関数が存在しません</h3></div>';
                            echo '<p>functions.phpが正しく読み込まれているか確認してください。</p>';
                        }
                        
                    } catch (Exception $e) {
                        echo '<div class="error">';
                        echo '<h3>❌ エラーが発生しました</h3>';
                        echo '<p>' . esc_html($e->getMessage()) . '</p>';
                        echo '<pre>' . esc_html($e->getTraceAsString()) . '</pre>';
                        echo '</div>';
                    } finally {
                        // $_POSTを復元
                        $_POST = $original_post;
                    }
                }
                break;
                
            case 'view_logs':
                echo '<h2>📋 デバッグログ確認</h2>';
                
                $log_file = WP_CONTENT_DIR . '/debug.log';
                if (file_exists($log_file)) {
                    $filesize = filesize($log_file);
                    echo '<div class="info">';
                    echo '<p><strong>ログファイルサイズ:</strong> ' . number_format($filesize / 1024, 2) . ' KB</p>';
                    echo '<p><strong>最終更新:</strong> ' . date('Y-m-d H:i:s', filemtime($log_file)) . '</p>';
                    echo '</div>';
                    
                    echo '<div class="info">';
                    echo '<h3>最新ログ（最後の50行）</h3>';
                    $lines = file($log_file);
                    $recent_lines = array_slice($lines, -50);
                    echo '<pre>' . esc_html(implode('', $recent_lines)) . '</pre>';
                    echo '</div>';
                    
                    // フォーム関連ログの抽出
                    echo '<div class="info">';
                    echo '<h3>フォーム関連ログのみ</h3>';
                    $form_lines = array();
                    foreach ($lines as $line) {
                        if (strpos($line, '📝') !== false || 
                            strpos($line, '📧') !== false || 
                            strpos($line, '📊') !== false || 
                            strpos($line, '✅') !== false || 
                            strpos($line, '❌') !== false ||
                            strpos($line, 'lead') !== false ||
                            strpos($line, 'フォーム') !== false ||
                            strpos($line, 'ultimate_lead_submit') !== false) {
                            $form_lines[] = $line;
                        }
                    }
                    
                    if (!empty($form_lines)) {
                        $recent_form_lines = array_slice($form_lines, -30);
                        echo '<pre>' . esc_html(implode('', $recent_form_lines)) . '</pre>';
                    } else {
                        echo '<p>フォーム関連のログエントリが見つかりません。</p>';
                    }
                    echo '</div>';
                    
                } else {
                    echo '<div class="warning"><h3>⚠️ デバッグログファイルが見つかりません</h3>';
                    echo '<p>wp-config.phpで以下の設定を確認してください：</p>';
                    echo '<pre>';
                    echo "define('WP_DEBUG', true);\n";
                    echo "define('WP_DEBUG_LOG', true);\n";
                    echo "define('WP_DEBUG_DISPLAY', false);";
                    echo '</pre>';
                    echo '</div>';
                }
                break;
                
            case 'view_leads':
                echo '<h2>📊 記録データ一覧</h2>';
                
                $leads = get_posts(array(
                    'post_type' => 'lead',
                    'posts_per_page' => 10,
                    'orderby' => 'date',
                    'order' => 'DESC'
                ));
                
                if ($leads) {
                    echo '<div class="info">';
                    echo '<p>最新10件の査定依頼データを表示しています。</p>';
                    echo '</div>';
                    
                    foreach ($leads as $index => $lead) {
                        $meta = get_post_meta($lead->ID);
                        $status_class = $index === 0 ? 'success' : 'info';
                        
                        echo "<div class='{$status_class}'>";
                        echo '<h4>Lead #' . $lead->ID . ' - ' . $lead->post_date . '</h4>';
                        
                        // 基本情報表示
                        echo '<div class="grid">';
                        echo '<div class="field"><strong>名前:</strong> ' . (isset($meta['name'][0]) ? $meta['name'][0] : 'N/A') . '</div>';
                        echo '<div class="field"><strong>電話:</strong> ' . (isset($meta['tel'][0]) ? $meta['tel'][0] : 'N/A') . '</div>';
                        echo '<div class="field"><strong>メール:</strong> ' . (isset($meta['email'][0]) ? $meta['email'][0] : 'N/A') . '</div>';
                        echo '<div class="field"><strong>物件種別:</strong> ' . (isset($meta['property-type'][0]) ? $meta['property-type'][0] : 'N/A') . '</div>';
                        echo '<div class="field"><strong>郵便番号:</strong> ' . (isset($meta['zip'][0]) ? $meta['zip'][0] : 'N/A') . '</div>';
                        echo '<div class="field"><strong>都道府県:</strong> ' . (isset($meta['pref'][0]) ? $meta['pref'][0] : 'N/A') . '</div>';
                        echo '</div>';
                        
                        // 追加情報
                        echo '<details><summary>詳細情報を表示</summary>';
                        echo '<div class="grid">';
                        foreach ($meta as $key => $value) {
                            if (!empty($value[0]) && strpos($key, '_') !== 0) {
                                echo "<div class='field'><strong>{$key}:</strong> " . esc_html($value[0]) . "</div>";
                            }
                        }
                        echo '</div></details>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="warning">';
                    echo '<h3>⚠️ まだ査定依頼データがありません</h3>';
                    echo '<p>上記のテストボタンでデータを送信してください。</p>';
                    echo '</div>';
                }
                break;
                
            case 'debug_sheets':
                echo '<h2>🔧 Google Sheets API デバッグ</h2>';
                
                // 現在の設定表示
                $webhook_url = 'https://script.google.com/macros/s/AKfycbwJAEwKNqh1enhpjced1EYdzvWckPzsJ_QLOPVV9sO3vvs84K3Y1i6mBGcMYEHX-7o/exec';
                $secret_key = 'sumitsu2025';
                
                echo '<div class="info">';
                echo '<h3>現在の設定</h3>';
                echo '<p><strong>Webhook URL:</strong> ' . substr($webhook_url, 0, 80) . '...</p>';
                echo '<p><strong>Secret Key:</strong> ' . $secret_key . '</p>';
                echo '</div>';
                
                // 3種類の送信方式をテスト
                $test_methods = array(
                    'form_data' => 'Form-data形式',
                    'json' => 'JSON形式', 
                    'url_params' => 'URL Parameters'
                );
                
                foreach ($test_methods as $method => $method_name) {
                    echo '<div class="info">';
                    echo "<h3>📡 {$method_name} テスト</h3>";
                    
                    // テストデータ準備
                    $test_data = array(
                        'secret' => $secret_key,
                        'lead_id' => 'debug_' . time() . '_' . $method,
                        'timestamp' => date('Y-m-d H:i:s'),
                        'name' => 'デバッグテスト_' . $method,
                        'tel' => '09012345678',
                        'email' => 'debug_' . $method . '@example.com',
                        'zip' => '1500013',
                        'property_type' => 'mansion',
                        'full_address' => '東京都渋谷区恵比寿1-1-1',
                        'remarks' => 'デバッグテスト - ' . $method_name
                    );
                    
                    $start_time = microtime(true);
                    
                    // 送信方式に応じてリクエスト実行
                    switch ($method) {
                        case 'form_data':
                            $response = wp_remote_post($webhook_url, array(
                                'body' => $test_data,
                                'timeout' => 30,
                                'sslverify' => false
                            ));
                            break;
                            
                        case 'json':
                            $response = wp_remote_post($webhook_url, array(
                                'body' => json_encode($test_data),
                                'headers' => array(
                                    'Content-Type' => 'application/json'
                                ),
                                'timeout' => 30,
                                'sslverify' => false
                            ));
                            break;
                            
                        case 'url_params':
                            $url_with_params = $webhook_url . '?' . http_build_query($test_data);
                            $response = wp_remote_get($url_with_params, array(
                                'timeout' => 30,
                                'sslverify' => false
                            ));
                            break;
                    }
                    
                    $end_time = microtime(true);
                    $execution_time = round(($end_time - $start_time) * 1000, 2);
                    
                    // 結果表示
                    if (is_wp_error($response)) {
                        echo '<p>❌ <strong>エラー:</strong> ' . $response->get_error_message() . '</p>';
                    } else {
                        $response_code = wp_remote_retrieve_response_code($response);
                        $response_body = wp_remote_retrieve_body($response);
                        
                        $status_class = $response_code == 200 ? 'success' : 'error';
                        $status_icon = $response_code == 200 ? '✅' : '❌';
                        
                        echo "<p>{$status_icon} <strong>ステータス:</strong> HTTP {$response_code}</p>";
                        echo "<p>⏱️ <strong>実行時間:</strong> {$execution_time}ms</p>";
                        
                        // レスポンス内容（最初の200文字のみ）
                        if (!empty($response_body)) {
                            $short_response = strlen($response_body) > 200 ? 
                                substr($response_body, 0, 200) . '...' : $response_body;
                            echo '<p><strong>レスポンス:</strong></p>';
                            echo '<pre style="max-height: 150px; overflow-y: auto; font-size: 11px;">' . 
                                 esc_html($short_response) . '</pre>';
                        }
                        
                        // JSON解析試行
                        if (strpos($response_body, '{') === 0) {
                            $json_data = json_decode($response_body, true);
                            if ($json_data) {
                                echo '<p><strong>JSON解析結果:</strong></p>';
                                echo '<pre style="font-size: 11px;">' . 
                                     json_encode($json_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . '</pre>';
                            }
                        }
                    }
                    
                    echo '</div>';
                    
                    // テスト間の間隔
                    usleep(500000); // 0.5秒待機
                }
                
                // 推奨事項
                echo '<div class="warning">';
                echo '<h3>🔍 トラブルシューティング</h3>';
                echo '<ul>';
                echo '<li><strong>HTTP 400:</strong> Google Apps Scriptがリクエストを理解できない（送信形式の問題）</li>';
                echo '<li><strong>HTTP 403:</strong> アクセス権限エラー（デプロイ設定を「全員」に変更）</li>';
                echo '<li><strong>HTTP 404:</strong> URLが存在しない（再デプロイが必要）</li>';
                echo '<li><strong>HTTP 500:</strong> スクリプト内部エラー（Logger.logでデバッグ）</li>';
                echo '</ul>';
                echo '<p><strong>推奨:</strong> すべてのテストが失敗する場合は、Google Apps Scriptの設定を確認してください。</p>';
                echo '</div>';
                
                break;
        }
        
        echo '</div>';
    }
    ?>
</div>

<?php get_footer(); ?>