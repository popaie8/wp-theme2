<?php
/*
Template Name: メールテスト
*/

// WordPress環境をロード
$wp_load_paths = array(
    dirname(__FILE__) . '/../../../wp-load.php',
    dirname(__FILE__) . '/../../../../wp-load.php',
    dirname(__FILE__) . '/../../../../../wp-load.php'
);

$wp_loaded = false;
foreach ($wp_load_paths as $path) {
    if (file_exists($path)) {
        require_once($path);
        $wp_loaded = true;
        break;
    }
}

if (!$wp_loaded) {
    die('WordPress環境をロードできません');
}

$test_result = '';

if (isset($_POST['test_email'])) {
    $test_email = sanitize_email($_POST['test_email']);
    
    if ($test_email) {
        // テストデータ
        $test_data = array(
            'id' => 999,
            'name' => 'テストユーザー',
            'email' => $test_email,
            'property_type' => 'マンション',
            'area' => '東京都',
            'age' => '10年以内',
            'size' => 70,
            'station' => '5分以内',
            'estimated_price' => 3000,
            'estimated_low' => 2700,
            'estimated_high' => 3300,
            'ip_address' => '127.0.0.1'
        );
        
        // PDFテストURL
        $test_pdf_url = home_url('/test-pdf');
        
        // メール送信テスト
        $result = send_ai_assessment_email($test_data, $test_pdf_url);
        
        if ($result) {
            $test_result = '<div style="color: green;">✅ メール送信成功！' . $test_email . 'に送信しました。</div>';
        } else {
            $test_result = '<div style="color: red;">❌ メール送信失敗</div>';
        }
    }
}

get_header();
?>

<div style="max-width: 800px; margin: 50px auto; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
    <h1>AI査定メール送信テスト</h1>
    
    <div style="background: #f0f0f0; padding: 20px; margin: 20px 0; border-radius: 5px;">
        <h3>システム状態</h3>
        <p>WordPress Email: <?php echo get_option('admin_email'); ?></p>
        <p>wp_mail関数: <?php echo function_exists('wp_mail') ? '✅ 利用可能' : '❌ 利用不可'; ?></p>
        <p>SMTP設定: <?php echo defined('SMTP_HOST') ? '✅ 設定済み' : '⚠️ デフォルト（PHP mail）'; ?></p>
    </div>
    
    <?php if ($test_result): ?>
        <div style="padding: 20px; margin: 20px 0;">
            <?php echo $test_result; ?>
        </div>
    <?php endif; ?>
    
    <form method="post" style="margin: 20px 0;">
        <h3>テストメール送信</h3>
        <p>
            <label>送信先メールアドレス:</label><br>
            <input type="email" name="test_email" style="width: 300px; padding: 10px;" required>
        </p>
        <p>
            <button type="submit" style="background: #2c5aa0; color: white; padding: 10px 30px; border: none; border-radius: 5px; cursor: pointer;">
                テスト送信
            </button>
        </p>
    </form>
    
    <div style="background: #fff3cd; padding: 20px; margin: 20px 0; border-radius: 5px;">
        <h3>⚠️ メールが届かない場合</h3>
        <ul>
            <li>迷惑メールフォルダを確認</li>
            <li>サーバーのメール送信設定を確認</li>
            <li>SMTPプラグインの導入を検討</li>
        </ul>
    </div>
    
    <div style="margin-top: 30px;">
        <h3>最近のエラーログ</h3>
        <pre style="background: #f0f0f0; padding: 10px; overflow: auto; max-height: 200px;">
<?php
$error_log = error_get_last();
if ($error_log) {
    print_r($error_log);
}

// WordPressのデバッグログを確認
if (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG) {
    $debug_log = WP_CONTENT_DIR . '/debug.log';
    if (file_exists($debug_log)) {
        $lines = file($debug_log);
        $recent_lines = array_slice($lines, -20);
        foreach ($recent_lines as $line) {
            if (strpos($line, 'mail') !== false) {
                echo htmlspecialchars($line);
            }
        }
    }
}
?>
        </pre>
    </div>
</div>

<?php get_footer(); ?>