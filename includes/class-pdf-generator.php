<?php
/**
 * Enhanced PDF Generator Class
 * 
 * プロフェッショナルなデザインのリースバック活用ガイドPDFを生成するクラス
 */

class Leaseback_PDF_Generator {
    
    private $assessment_data;
    private $pdf_template_path;
    private $generated_path;
    
    public function __construct($assessment_data) {
        $this->assessment_data = $assessment_data;
        $this->pdf_template_path = get_template_directory() . '/pdfs/templates/';
        $this->generated_path = get_template_directory() . '/pdfs/generated/';
    }
    
    /**
     * PDFを生成して一時URLを返す
     */
    public function generate() {
        // 一意のファイル名を生成
        $filename = $this->create_filename();
        
        // HTML版のPDFコンテンツを生成
        $html_content = $this->generate_html_content();
        
        // HTMLをファイルとして保存
        $html_file = $this->generated_path . $filename . '.html';
        file_put_contents($html_file, $html_content);
        
        // セキュアなダウンロードURLを生成
        $download_url = $this->create_secure_download_url($filename);
        
        return array(
            'filename' => $filename,
            'download_url' => $download_url,
            'expires_at' => time() + (24 * 60 * 60) // 24時間後
        );
    }
    
    /**
     * プロフェッショナルなHTMLコンテンツを生成
     */
    private function generate_html_content() {
        $data = $this->assessment_data;
        
        // 賃料目安計算（査定額の0.6%）
        $monthly_rent = round($data['estimated_price'] * 0.006);
        
        // 受取可能額（査定額の75%）
        $receivable_amount = round($data['estimated_price'] * 0.75);
        
        $html = '<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>リースバック活用ガイド</title>
    <style>
        @page { 
            size: A4; 
            margin: 15mm; 
            @top-center { content: "リースバック活用ガイド"; }
        }
        
        * {
            box-sizing: border-box;
        }
        
        body { 
            font-family: "游ゴシック", "Yu Gothic", "Hiragino Kaku Gothic ProN", "メイリオ", sans-serif; 
            line-height: 1.7;
            color: #2c3e50;
            margin: 0;
            padding: 0;
            background: #f8f9fa;
        }
        
        .page { 
            page-break-after: always; 
            min-height: 100vh;
            padding: 30px;
            background: white;
            margin: 10px;
            border-radius: 10px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }
        
        .page::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: linear-gradient(45deg, rgba(44,90,160,0.1) 0%, rgba(44,90,160,0.05) 100%);
            border-radius: 50%;
            transform: translate(50%, -50%);
            z-index: 0;
        }
        
        .content {
            position: relative;
            z-index: 1;
        }
        
        /* 表紙デザイン */
        .cover { 
            text-align: center; 
            padding: 80px 30px 60px 30px;
            background: linear-gradient(135deg, #2c5aa0 0%, #1a3a5f 100%);
            color: white;
            border-radius: 15px;
            margin: -30px -30px 30px -30px;
            position: relative;
            overflow: hidden;
        }
        
        .cover::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: repeating-linear-gradient(
                45deg,
                rgba(255,255,255,0.05) 0px,
                rgba(255,255,255,0.05) 1px,
                transparent 1px,
                transparent 20px
            );
            animation: float 20s infinite linear;
        }
        
        @keyframes float {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .cover h1 { 
            font-size: 36px; 
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            position: relative;
            z-index: 1;
        }
        
        .cover .subtitle { 
            font-size: 20px; 
            margin-bottom: 40px;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }
        
        .cover .logo {
            font-size: 24px;
            margin-top: 40px;
            padding: 15px 30px;
            background: rgba(255,255,255,0.1);
            border-radius: 30px;
            display: inline-block;
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 1;
        }
        
        /* 査定結果ボックス */
        .assessment-box {
            background: linear-gradient(135deg, #f8faff 0%, #e8f4f8 100%);
            border: 3px solid #2c5aa0;
            border-radius: 20px;
            padding: 40px;
            margin: 40px 0;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(44,90,160,0.15);
        }
        
        .assessment-box::before {
            content: "";
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(44,90,160,0.1) 0%, transparent 50%);
            border-radius: 50%;
            z-index: 0;
        }
        
        .assessment-box .content {
            position: relative;
            z-index: 1;
        }
        
        .price-display {
            text-align: center;
            margin: 30px 0;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .price-main {
            font-size: 56px;
            color: #2c5aa0;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
            margin: 10px 0;
            position: relative;
        }
        
        .price-main::after {
            content: "";
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, #2c5aa0, #4a90e2);
            border-radius: 2px;
        }
        
        .price-range {
            font-size: 18px;
            color: #666;
            margin-top: 15px;
        }
        
        .price-label {
            font-size: 16px;
            color: #888;
            margin-bottom: 5px;
        }
        
        /* 見出しスタイル */
        h2 {
            color: #2c5aa0;
            border-bottom: 4px solid #2c5aa0;
            padding-bottom: 15px;
            margin-top: 50px;
            font-size: 28px;
            position: relative;
            padding-left: 20px;
        }
        
        h2::before {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 8px;
            height: 30px;
            background: linear-gradient(135deg, #2c5aa0, #4a90e2);
            border-radius: 4px;
        }
        
        h3 {
            color: #2c5aa0;
            font-size: 22px;
            margin-top: 30px;
            margin-bottom: 15px;
            position: relative;
            padding-left: 30px;
        }
        
        h3::before {
            content: "▶";
            position: absolute;
            left: 0;
            color: #2c5aa0;
            font-size: 16px;
        }
        
        /* カード風デザイン */
        .info-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin: 20px 0;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            border-left: 6px solid #2c5aa0;
        }
        
        .info-card h3 {
            margin-top: 0;
            color: #2c5aa0;
        }
        
        .info-card h3::before {
            display: none;
        }
        
        /* 特徴リスト */
        .feature-list {
            list-style: none;
            padding: 0;
        }
        
        .feature-list li {
            padding: 20px 0;
            border-bottom: 1px solid #e0e0e0;
            position: relative;
            padding-left: 50px;
        }
        
        .feature-list li:last-child {
            border-bottom: none;
        }
        
        .feature-list li::before {
            content: "✓";
            position: absolute;
            left: 0;
            top: 20px;
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, #2c5aa0, #4a90e2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 16px;
            box-shadow: 0 3px 10px rgba(44,90,160,0.3);
        }
        
        /* テーブルスタイル */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        table th, table td {
            padding: 20px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        table th {
            background: linear-gradient(135deg, #f8faff 0%, #e8f4f8 100%);
            color: #2c5aa0;
            font-weight: bold;
        }
        
        table tr:hover {
            background: #f8faff;
        }
        
        /* CTA ボックス */
        .cta-box {
            background: linear-gradient(135deg, #2c5aa0 0%, #1a3a5f 100%);
            color: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            margin: 50px 0;
            box-shadow: 0 10px 30px rgba(44,90,160,0.3);
            position: relative;
            overflow: hidden;
        }
        
        .cta-box::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: repeating-linear-gradient(
                45deg,
                rgba(255,255,255,0.05) 0px,
                rgba(255,255,255,0.05) 1px,
                transparent 1px,
                transparent 20px
            );
        }
        
        .cta-box h3 {
            margin: 0 0 20px 0;
            font-size: 28px;
            position: relative;
            z-index: 1;
        }
        
        .cta-box h3::before {
            display: none;
        }
        
        .contact-info {
            font-size: 22px;
            margin: 15px 0;
            padding: 15px;
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            position: relative;
            z-index: 1;
        }
        
        /* 2カラムレイアウト */
        .two-column {
            display: flex;
            gap: 40px;
            margin: 30px 0;
        }
        
        .column {
            flex: 1;
        }
        
        /* 警告ボックス */
        .warning-box {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border: 2px solid #f39c12;
            border-radius: 15px;
            padding: 30px;
            margin: 30px 0;
            position: relative;
        }
        
        .warning-box::before {
            content: "⚠️";
            font-size: 24px;
            position: absolute;
            top: -12px;
            left: 20px;
            background: #f39c12;
            color: white;
            padding: 5px 10px;
            border-radius: 50%;
        }
        
        .warning-box h4 {
            color: #d35400;
            margin-top: 0;
            font-size: 20px;
        }
        
        /* 成功ボックス */
        .success-box {
            background: linear-gradient(135deg, #d4edda 0%, #a8d8a8 100%);
            border: 2px solid #28a745;
            border-radius: 15px;
            padding: 30px;
            margin: 30px 0;
            position: relative;
        }
        
        .success-box::before {
            content: "💡";
            font-size: 24px;
            position: absolute;
            top: -12px;
            left: 20px;
            background: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 50%;
        }
        
        .success-box h4 {
            color: #155724;
            margin-top: 0;
            font-size: 20px;
        }
        
        /* フッター */
        .footer {
            text-align: center;
            margin-top: 50px;
            padding: 30px;
            background: #f8f9fa;
            border-radius: 15px;
            color: #666;
        }
        
        .footer .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #2c5aa0;
            margin-bottom: 10px;
        }
        
        /* 印刷用最適化 */
        @media print {
            body {
                background: white;
            }
            
            .page {
                margin: 0;
                box-shadow: none;
            }
            
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- 表紙 -->
    <div class="page">
        <div class="content">
            <div class="cover">
                <h1>あなたの家の未来を守る<br>リースバック活用ガイド</h1>
                <p class="subtitle">住み続けながら、まとまった資金を手に入れる方法</p>
                <div class="logo">リースバック住み続け隊</div>
            </div>
            
            <div class="assessment-box">
                <div class="content">
                    <h2>お客様専用 AI査定結果</h2>
                    <p>査定ID: AI-' . $data['id'] . '</p>
                    <p>査定日: ' . date('Y年m月d日') . '</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- 査定結果ページ -->
    <div class="page">
        <div class="content">
            <h2>💰 AI査定結果サマリー</h2>
            
            <div class="assessment-box">
                <div class="content">
                    <h3>あなたの物件の推定価格</h3>
                    <div class="price-display">
                        <div class="price-label">推定査定価格</div>
                        <div class="price-main">' . number_format($data['estimated_price']) . '万円</div>
                        <div class="price-range">想定範囲: ' . number_format($data['estimated_low']) . '万円 〜 ' . number_format($data['estimated_high']) . '万円</div>
                    </div>
                    
                    <div class="two-column">
                        <div class="column">
                            <div class="info-card">
                                <h3>物件情報</h3>
                                <table>
                                    <tr>
                                        <th>項目</th>
                                        <th>詳細</th>
                                    </tr>
                                    <tr>
                                        <td>物件種別</td>
                                        <td>' . $data['property_type'] . '</td>
                                    </tr>
                                    <tr>
                                        <td>エリア</td>
                                        <td>' . $data['area'] . '</td>
                                    </tr>
                                    <tr>
                                        <td>築年数</td>
                                        <td>' . $data['age'] . '</td>
                                    </tr>
                                    <tr>
                                        <td>駅距離</td>
                                        <td>' . $data['station'] . '</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="column">
                            <div class="info-card">
                                <h3>リースバック試算</h3>
                                <table>
                                    <tr>
                                        <th>項目</th>
                                        <th>金額</th>
                                    </tr>
                                    <tr>
                                        <td>月額賃料目安</td>
                                        <td>' . number_format($monthly_rent) . '万円</td>
                                    </tr>
                                    <tr>
                                        <td>受取可能額目安</td>
                                        <td style="color: #2c5aa0; font-weight: bold;">' . number_format($receivable_amount) . '万円</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="warning-box">
                        <h4>重要なお知らせ</h4>
                        <p>こちらは概算価格です。実際の査定額は物件の詳細調査により変動します。より正確な査定をご希望の場合は、無料相談をご利用ください。</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- リースバック解説 -->
    <div class="page">
        <div class="content">
            <h2>🏠 リースバックとは？</h2>
            <p>リースバックは、ご自宅を売却した後も、賃貸として住み続けることができる画期的なサービスです。</p>
            
            <div class="info-card">
                <h3>リースバックの3ステップ</h3>
                <ol style="font-size: 18px; line-height: 2;">
                    <li><strong>自宅を売却</strong> - まとまった資金を受け取ります</li>
                    <li><strong>賃貸契約を締結</strong> - 新たに賃貸借契約を結びます</li>
                    <li><strong>そのまま住み続ける</strong> - 引っ越し不要で生活を継続</li>
                </ol>
            </div>
            
            <div class="info-card">
                <h3>こんな方におすすめです</h3>
                <ul class="feature-list">
                    <li>老後の生活資金を確保したい方</li>
                    <li>住宅ローンの返済にお困りの方</li>
                    <li>相続対策をお考えの方</li>
                    <li>事業資金が必要な方</li>
                    <li>医療費・介護費用が必要な方</li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- メリット・デメリット -->
    <div class="page">
        <div class="content">
            <h2>📊 メリット・デメリット</h2>
            
            <div class="two-column">
                <div class="column">
                    <div class="success-box">
                        <h4>5つのメリット</h4>
                        <ul class="feature-list">
                            <li>即座に現金化（最短2週間）</li>
                            <li>住み慣れた家に住み続けられる</li>
                            <li>周囲に知られない</li>
                            <li>維持費の負担から解放</li>
                            <li>将来的な買い戻しも可能</li>
                        </ul>
                    </div>
                </div>
                <div class="column">
                    <div class="warning-box">
                        <h4>3つの注意点</h4>
                        <ul>
                            <li>売却価格が市場価格より低い（70-80%程度）</li>
                            <li>賃料の支払いが必要</li>
                            <li>所有権を失う</li>
                        </ul>
                        <p style="margin-top: 20px; font-size: 14px;">
                            <strong>対策：</strong> 事前に十分な説明を受け、納得した上でご契約いただくことが重要です。
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- 資金活用プラン -->
    <div class="page">
        <div class="content">
            <h2>💰 受取資金の活用プラン例</h2>
            
            <div class="assessment-box">
                <div class="content">
                    <h3>あなたの場合: ' . number_format($receivable_amount) . '万円の活用例</h3>
                    
                    <div class="two-column">
                        <div class="column">
                            <div class="info-card">
                                <h3>生活資金として</h3>
                                <ul>
                                    <li>老後の生活費: 月額' . number_format(round($receivable_amount / 240)) . '万円×20年</li>
                                    <li>医療・介護費用の備え</li>
                                    <li>ゆとりある生活の実現</li>
                                </ul>
                            </div>
                        </div>
                        <div class="column">
                            <div class="info-card">
                                <h3>投資・事業資金として</h3>
                                <ul>
                                    <li>住宅ローン一括返済</li>
                                    <li>事業拡大・新規投資</li>
                                    <li>お子様・お孫様への援助</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="success-box">
                <h4>💡 ポイント</h4>
                <p>リースバックで得た資金は非課税です。有効に活用することで、より豊かな生活を実現できます。</p>
            </div>
        </div>
    </div>
    
    <!-- よくある質問 -->
    <div class="page">
        <div class="content">
            <h2>❓ よくあるご質問</h2>
            
            <div class="info-card">
                <h3>Q1. 何歳まで住み続けられますか？</h3>
                <p><strong>A.</strong> 年齢制限はありません。健康である限り、ずっとお住まいいただけます。</p>
            </div>
            
            <div class="info-card">
                <h3>Q2. 家族も一緒に住めますか？</h3>
                <p><strong>A.</strong> もちろん可能です。ご家族皆様でこれまで通りお住まいいただけます。</p>
            </div>
            
            <div class="info-card">
                <h3>Q3. ペットは飼えますか？</h3>
                <p><strong>A.</strong> 現在飼われているペットは、そのまま飼い続けることができます。</p>
            </div>
            
            <div class="info-card">
                <h3>Q4. 賃料はどのくらいになりますか？</h3>
                <p><strong>A.</strong> 一般的に売却価格の月額0.5〜0.8%程度です。あなたの場合、約' . number_format($monthly_rent) . '万円が目安です。</p>
            </div>
            
            <div class="info-card">
                <h3>Q5. 査定や相談は無料ですか？</h3>
                <p><strong>A.</strong> はい、査定・ご相談は完全無料です。お気軽にお問い合わせください。</p>
            </div>
        </div>
    </div>
    
    <!-- 次のステップ -->
    <div class="page">
        <div class="content">
            <h2>🚀 無料相談で不安を解消しましょう</h2>
            
            <p>AI査定はあくまで概算です。より正確な査定と、あなたに最適なプランをご提案するため、ぜひ一度ご相談ください。</p>
            
            <div class="cta-box">
                <h3>3つの相談方法をご用意</h3>
                
                <div class="contact-info">📱 LINE相談: @377sitjf</div>
                <div class="contact-info">📞 お電話: 050-5810-5875</div>
                <div class="contact-info">🏢 対面相談: 予約制</div>
                
                <p style="margin-top: 30px;">平日9:00〜18:00 / 土日祝も対応可能</p>
            </div>
            
            <div class="info-card">
                <h3>安心のお約束</h3>
                <ul class="feature-list">
                    <li>強引な営業は一切いたしません</li>
                    <li>個人情報は厳重に管理します</li>
                    <li>相談後のしつこい連絡はありません</li>
                    <li>納得いくまで何度でもご相談可能</li>
                </ul>
            </div>
            
            <div class="footer">
                <div class="company-name">リースバック住み続け隊</div>
                <p>代表取締役 黒江 貴裕</p>
                <p>📞 050-5810-5875 | 💬 LINE: @377sitjf</p>
            </div>
        </div>
    </div>
</body>
</html>';
        
        return $html;
    }
    
    /**
     * 一意のファイル名を生成
     */
    private function create_filename() {
        return 'leaseback_guide_' . $this->assessment_data['id'] . '_' . time();
    }
    
    /**
     * セキュアなダウンロードURLを生成
     */
    private function create_secure_download_url($filename) {
        $assessment_id = $this->assessment_data['id'];
        $timestamp = time();
        $expires = $timestamp + (24 * 60 * 60); // 24時間後
        
        // ハッシュ値生成（セキュリティ用）
        $hash = hash_hmac('sha256', $assessment_id . $filename . $expires, SECURE_AUTH_KEY);
        
        $download_url = add_query_arg(array(
            'action' => 'download_assessment_pdf',
            'aid' => $assessment_id,
            'file' => $filename,
            'expires' => $expires,
            'token' => $hash
        ), admin_url('admin-ajax.php'));
        
        return $download_url;
    }
}