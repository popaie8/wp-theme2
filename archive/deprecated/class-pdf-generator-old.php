<?php
/**
 * PDF Generator Class
 * 
 * リースバック活用ガイドPDFを生成するクラス
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
        
        // HTMLをファイルとして保存（簡易実装）
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
     * HTMLコンテンツを生成
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
        @page { size: A4; margin: 20mm; }
        body { 
            font-family: "游ゴシック", "Yu Gothic", "メイリオ", sans-serif; 
            line-height: 1.8;
            color: #333;
        }
        .page { 
            page-break-after: always; 
            min-height: 100vh;
            padding: 40px;
        }
        .cover { 
            text-align: center; 
            padding-top: 100px;
        }
        .cover h1 { 
            font-size: 32px; 
            color: #2c5aa0;
            margin-bottom: 20px;
        }
        .cover .subtitle { 
            font-size: 18px; 
            color: #666;
            margin-bottom: 50px;
        }
        .assessment-box {
            background: #f0f8ff;
            border: 2px solid #2c5aa0;
            border-radius: 10px;
            padding: 30px;
            margin: 30px 0;
        }
        .price-display {
            text-align: center;
            margin: 20px 0;
        }
        .price-main {
            font-size: 48px;
            color: #2c5aa0;
            font-weight: bold;
        }
        .price-range {
            font-size: 16px;
            color: #666;
        }
        h2 {
            color: #2c5aa0;
            border-bottom: 3px solid #2c5aa0;
            padding-bottom: 10px;
            margin-top: 40px;
        }
        .feature-list {
            list-style: none;
            padding: 0;
        }
        .feature-list li {
            padding: 15px 0;
            border-bottom: 1px solid #ddd;
        }
        .feature-list li:before {
            content: "✓";
            color: #2c5aa0;
            font-weight: bold;
            margin-right: 10px;
        }
        .cta-box {
            background: #2c5aa0;
            color: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            margin: 40px 0;
        }
        .cta-box h3 {
            margin: 0 0 20px 0;
            font-size: 24px;
        }
        .contact-info {
            font-size: 20px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <!-- 表紙 -->
    <div class="page cover">
        <h1>あなたの家の未来を守る<br>リースバック活用ガイド</h1>
        <p class="subtitle">住み続けながら、まとまった資金を手に入れる方法</p>
        
        <div class="assessment-box">
            <h2 style="border: none; margin-top: 0;">お客様専用 AI査定結果</h2>
            <p>査定ID: AI-' . $data['id'] . '</p>
            <p>査定日: ' . date('Y年m月d日') . '</p>
        </div>
        
        <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjUwIiB2aWV3Qm94PSIwIDAgMjAwIDUwIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgogICAgPHRleHQgeD0iMTAwIiB5PSIzMCIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZm9udC1zaXplPSIxOCIgZmlsbD0iIzJjNWFhMCI+44Oq44O844K544OQ44OD44Kv5L2P44G/57aa44GR6ZqKPC90ZXh0Pgo8L3N2Zz4=" alt="リースバック住み続け隊">
    </div>
    
    <!-- 査定結果ページ -->
    <div class="page">
        <h2>AI査定結果サマリー</h2>
        
        <div class="assessment-box">
            <h3>あなたの物件の推定価格</h3>
            <div class="price-display">
                <div class="price-main">' . number_format($data['estimated_price']) . '万円</div>
                <div class="price-range">想定範囲: ' . number_format($data['estimated_low']) . '万円 〜 ' . number_format($data['estimated_high']) . '万円</div>
            </div>
            
            <table style="width: 100%; margin-top: 30px; border-collapse: collapse;">
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd; background: #f8f9fa;">物件種別</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">' . $data['property_type'] . '</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd; background: #f8f9fa;">エリア</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">' . $data['area'] . '</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd; background: #f8f9fa;">築年数</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">' . $data['age'] . '</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd; background: #f8f9fa;">月額賃料目安</td>
                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;">' . number_format($monthly_rent) . '万円</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd; background: #f8f9fa;">受取可能額目安</td>
                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; color: #2c5aa0;">' . number_format($receivable_amount) . '万円</td>
                </tr>
            </table>
            
            <p style="margin-top: 20px; font-size: 14px; color: #666;">
                ※ こちらは概算価格です。実際の査定額は物件の詳細調査により変動します。
            </p>
        </div>
    </div>
    
    <!-- リースバックとは -->
    <div class="page">
        <h2>リースバックとは？</h2>
        <p>リースバックは、ご自宅を売却した後も、賃貸として住み続けることができる画期的なサービスです。</p>
        
        <h3>リースバックの3ステップ</h3>
        <ol style="font-size: 18px; line-height: 2;">
            <li><strong>自宅を売却</strong> - まとまった資金を受け取ります</li>
            <li><strong>賃貸契約を締結</strong> - 新たに賃貸借契約を結びます</li>
            <li><strong>そのまま住み続ける</strong> - 引っ越し不要で生活を継続</li>
        </ol>
        
        <h3>こんな方におすすめです</h3>
        <ul class="feature-list">
            <li>老後の生活資金を確保したい方</li>
            <li>住宅ローンの返済にお困りの方</li>
            <li>相続対策をお考えの方</li>
            <li>事業資金が必要な方</li>
            <li>医療費・介護費用が必要な方</li>
        </ul>
    </div>
    
    <!-- メリット -->
    <div class="page">
        <h2>リースバックが選ばれる5つの理由</h2>
        
        <div style="margin: 30px 0;">
            <h3>1. 即座に現金化</h3>
            <p>最短2週間でまとまった資金を手にすることができます。急な資金需要にも対応可能です。</p>
            
            <h3>2. 住み慣れた家に住み続けられる</h3>
            <p>引っ越しの必要がなく、お子様の学区も変わりません。思い出の詰まった家で暮らし続けられます。</p>
            
            <h3>3. 周囲に知られない</h3>
            <p>売却したことが近所に知られることはありません。プライバシーが守られます。</p>
            
            <h3>4. 維持費の負担から解放</h3>
            <p>固定資産税や修繕費用の負担がなくなり、家計に余裕が生まれます。</p>
            
            <h3>5. 将来的な買い戻しも可能</h3>
            <p>経済状況が改善した際には、優先的に買い戻すオプションもあります。</p>
        </div>
    </div>
    
    <!-- 資金活用プラン -->
    <div class="page">
        <h2>受取資金の活用プラン例</h2>
        
        <div class="assessment-box">
            <h3>あなたの場合: ' . number_format($receivable_amount) . '万円の活用例</h3>
            
            <table style="width: 100%; margin-top: 20px;">
                <tr>
                    <td style="padding: 15px; background: #f8f9fa;">老後の生活資金として</td>
                    <td style="padding: 15px; text-align: right; font-weight: bold;">月額' . number_format(round($receivable_amount / 240)) . '万円×20年</td>
                </tr>
                <tr>
                    <td style="padding: 15px; background: #f8f9fa;">住宅ローン完済</td>
                    <td style="padding: 15px; text-align: right; font-weight: bold;">残債を一括返済</td>
                </tr>
                <tr>
                    <td style="padding: 15px; background: #f8f9fa;">医療・介護費用</td>
                    <td style="padding: 15px; text-align: right; font-weight: bold;">安心の備え</td>
                </tr>
                <tr>
                    <td style="padding: 15px; background: #f8f9fa;">お子様・お孫様への援助</td>
                    <td style="padding: 15px; text-align: right; font-weight: bold;">教育資金や独立支援</td>
                </tr>
            </table>
        </div>
        
        <p style="margin-top: 30px; padding: 20px; background: #fff3cd; border-radius: 10px;">
            <strong>💡 ポイント</strong><br>
            リースバックで得た資金は非課税です。有効に活用することで、より豊かな生活を実現できます。
        </p>
    </div>
    
    <!-- よくある質問 -->
    <div class="page">
        <h2>よくあるご質問</h2>
        
        <div style="margin: 20px 0;">
            <h4>Q1. 何歳まで住み続けられますか？</h4>
            <p>A. 年齢制限はありません。健康である限り、ずっとお住まいいただけます。</p>
            
            <h4>Q2. 家族も一緒に住めますか？</h4>
            <p>A. もちろん可能です。ご家族皆様でこれまで通りお住まいいただけます。</p>
            
            <h4>Q3. ペットは飼えますか？</h4>
            <p>A. 現在飼われているペットは、そのまま飼い続けることができます。</p>
            
            <h4>Q4. 賃料はどのくらいになりますか？</h4>
            <p>A. 一般的に売却価格の月額0.5〜0.8%程度です。あなたの場合、約' . number_format($monthly_rent) . '万円が目安です。</p>
            
            <h4>Q5. 査定や相談は無料ですか？</h4>
            <p>A. はい、査定・ご相談は完全無料です。お気軽にお問い合わせください。</p>
        </div>
    </div>
    
    <!-- 次のステップ -->
    <div class="page">
        <h2>無料相談で不安を解消しましょう</h2>
        
        <p>AI査定はあくまで概算です。より正確な査定と、あなたに最適なプランをご提案するため、ぜひ一度ご相談ください。</p>
        
        <div class="cta-box">
            <h3>3つの相談方法をご用意</h3>
            
            <div style="margin: 20px 0;">
                <div class="contact-info">📱 LINE相談: @377sitjf</div>
                <div class="contact-info">📞 お電話: 050-5810-5875</div>
                <div class="contact-info">🏢 対面相談: 予約制</div>
            </div>
            
            <p style="margin-top: 30px;">平日9:00〜18:00 / 土日祝も対応可能</p>
        </div>
        
        <div style="margin-top: 40px; padding: 20px; background: #f8f9fa; border-radius: 10px;">
            <h3>安心のお約束</h3>
            <ul class="feature-list">
                <li>強引な営業は一切いたしません</li>
                <li>個人情報は厳重に管理します</li>
                <li>相談後のしつこい連絡はありません</li>
                <li>納得いくまで何度でもご相談可能</li>
            </ul>
        </div>
        
        <p style="text-align: center; margin-top: 40px; color: #666;">
            リースバック住み続け隊<br>
            代表取締役 黒江 貴裕
        </p>
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