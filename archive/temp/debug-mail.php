<?php
/**
 * メール送信デバッグツール
 */

// WordPress環境をロード
$wp_load_paths = array(
    dirname(__FILE__) . '/../../../wp-load.php',
    dirname(__FILE__) . '/../../../../wp-load.php',
    dirname(__FILE__) . '/../../../../../wp-load.php'
);

foreach ($wp_load_paths as $path) {
    if (file_exists($path)) {
        require_once($path);
        break;
    }
}

// PHPMailerのデバッグを有効化
add_action('phpmailer_init', function($phpmailer) {
    // SMTP Debugを有効化
    $phpmailer->SMTPDebug = 3;
    $phpmailer->Debugoutput = 'html';
});

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>メール送信デバッグ</title>
    <style>
        body { font-family: sans-serif; max-width: 1200px; margin: 20px auto; padding: 20px; }
        .debug-box { background: #f5f5f5; padding: 20px; margin: 20px 0; border-radius: 5px; }
        .success { color: green; }
        .error { color: red; }
        pre { background: #333; color: #fff; padding: 15px; overflow: auto; }
        form { background: #fff; padding: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        input[type="email"] { width: 300px; padding: 10px; }
        button { background: #007cba; color: white; padding: 10px 20px; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h1>リースバック住み続け隊 - メール送信デバッグ</h1>
    
    <div class="debug-box">
        <h2>システム情報</h2>
        <ul>
            <li>PHP Version: <?php echo phpversion(); ?></li>
            <li>WordPress Version: <?php echo get_bloginfo('version'); ?></li>
            <li>Admin Email: <?php echo get_option('admin_email'); ?></li>
            <li>mail()関数: <?php echo function_exists('mail') ? '<span class="success">✓ 利用可能</span>' : '<span class="error">✗ 利用不可</span>'; ?></li>
            <li>wp_mail()関数: <?php echo function_exists('wp_mail') ? '<span class="success">✓ 利用可能</span>' : '<span class="error">✗ 利用不可</span>'; ?></li>
            <li>sendmail_path: <?php echo ini_get('sendmail_path') ?: '未設定'; ?></li>
            <li>SMTP: <?php echo ini_get('SMTP') ?: 'localhost'; ?></li>
            <li>smtp_port: <?php echo ini_get('smtp_port') ?: '25'; ?></li>
        </ul>
    </div>

    <?php
    if (isset($_POST['test_submit'])) {
        $to = sanitize_email($_POST['test_email']);
        $from = sanitize_email($_POST['from_email']);
        
        echo '<div class="debug-box">';
        echo '<h2>メール送信テスト結果</h2>';
        echo '<p>宛先: ' . esc_html($to) . '</p>';
        echo '<p>送信元: ' . esc_html($from) . '</p>';
        
        // テストデータで実際の送信関数を呼び出す
        $test_data = array(
            'name' => 'テスト太郎',
            'email' => $to,
            'tel' => '090-1234-5678',
            'zip' => '123-4567',
            'property-type' => 'mansion-unit',
            'pref' => '東京都',
            'city' => '渋谷区',
            'town' => '渋谷',
            'chome' => '1',
            'banchi' => '1-1',
            'building_name' => 'テストマンション',
            'room_number' => '101',
            'full_address' => '東京都渋谷区渋谷1丁目1-1 テストマンション 101',
            'layout_rooms' => '3',
            'layout_type' => 'LDK',
            'area' => '70',
            'area_unit' => '㎡',
            'age' => '10',
            'remarks' => 'テスト送信です',
            'processed_at' => current_time('Y-m-d H:i:s'),
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'lead_id' => 'TEST-' . time()
        );
        
        echo '<h3>1. 直接wp_mail()テスト</h3>';
        ob_start();
        $direct_result = wp_mail(
            $to,
            'テスト: リースバック査定',
            'これはテストメールです。',
            array(
                'Content-Type: text/html; charset=UTF-8',
                'From: ' . $from
            )
        );
        $debug_output = ob_get_clean();
        
        if ($direct_result) {
            echo '<p class="success">✓ 直接送信成功</p>';
        } else {
            echo '<p class="error">✗ 直接送信失敗</p>';
            global $phpmailer;
            if (isset($phpmailer->ErrorInfo)) {
                echo '<p>エラー: ' . esc_html($phpmailer->ErrorInfo) . '</p>';
            }
        }
        
        if ($debug_output) {
            echo '<pre>' . esc_html($debug_output) . '</pre>';
        }
        
        echo '<h3>2. send_notification_emails()関数テスト</h3>';
        if (function_exists('send_notification_emails')) {
            ob_start();
            $func_result = send_notification_emails($test_data);
            $func_output = ob_get_clean();
            
            if ($func_result) {
                echo '<p class="success">✓ 関数送信成功</p>';
            } else {
                echo '<p class="error">✗ 関数送信失敗</p>';
            }
            
            if ($func_output) {
                echo '<pre>' . esc_html($func_output) . '</pre>';
            }
        } else {
            echo '<p class="error">send_notification_emails()関数が見つかりません</p>';
        }
        
        echo '</div>';
        
        // エラーログを表示
        echo '<div class="debug-box">';
        echo '<h3>エラーログ（最新20件）</h3>';
        echo '<pre>';
        
        if (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG) {
            $log_file = WP_CONTENT_DIR . '/debug.log';
            if (file_exists($log_file)) {
                $lines = file($log_file);
                $recent = array_slice($lines, -20);
                foreach ($recent as $line) {
                    if (stripos($line, 'mail') !== false || stripos($line, '📧') !== false) {
                        echo esc_html($line);
                    }
                }
            }
        } else {
            echo 'デバッグログが有効ではありません';
        }
        echo '</pre>';
        echo '</div>';
    }
    ?>

    <form method="post" action="">
        <h2>メール送信テスト</h2>
        <p>
            <label>宛先メールアドレス:</label><br>
            <input type="email" name="test_email" required value="<?php echo esc_attr(get_option('admin_email')); ?>">
        </p>
        <p>
            <label>送信元メールアドレス:</label><br>
            <input type="email" name="from_email" required value="<?php echo esc_attr(get_option('admin_email')); ?>">
        </p>
        <p>
            <button type="submit" name="test_submit">テスト送信</button>
        </p>
    </form>

    <div class="debug-box">
        <h2>推奨される対処法</h2>
        <ol>
            <li><strong>SMTPプラグインの導入</strong>
                <ul>
                    <li>WP Mail SMTP</li>
                    <li>Post SMTP</li>
                    <li>Easy WP SMTP</li>
                </ul>
            </li>
            <li><strong>サーバー設定の確認</strong>
                <ul>
                    <li>sendmailがインストールされているか</li>
                    <li>ファイアウォール設定（ポート25, 587）</li>
                    <li>SPFレコードの設定</li>
                </ul>
            </li>
            <li><strong>外部SMTPサービスの利用</strong>
                <ul>
                    <li>SendGrid</li>
                    <li>Amazon SES</li>
                    <li>Mailgun</li>
                </ul>
            </li>
        </ol>
    </div>
</body>
</html>