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
                <div style="display: flex; justify-content: space-between; margin: 20px 0;">
                    <div style="flex: 1; text-align: center; padding: 20px; background: #f8faff; border-radius: 10px; margin: 0 10px;">
                        <div style="width: 60px; height: 60px; background: #2c5aa0; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; font-weight: bold; margin: 0 auto 15px;">1</div>
                        <h4 style="color: #2c5aa0; margin: 10px 0;">自宅を売却</h4>
                        <p style="font-size: 14px; margin: 0;">まとまった資金を受け取ります</p>
                    </div>
                    <div style="flex: 1; text-align: center; padding: 20px; background: #f8faff; border-radius: 10px; margin: 0 10px;">
                        <div style="width: 60px; height: 60px; background: #2c5aa0; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; font-weight: bold; margin: 0 auto 15px;">2</div>
                        <h4 style="color: #2c5aa0; margin: 10px 0;">賃貸契約締結</h4>
                        <p style="font-size: 14px; margin: 0;">新たに賃貸借契約を結びます</p>
                    </div>
                    <div style="flex: 1; text-align: center; padding: 20px; background: #f8faff; border-radius: 10px; margin: 0 10px;">
                        <div style="width: 60px; height: 60px; background: #2c5aa0; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; font-weight: bold; margin: 0 auto 15px;">3</div>
                        <h4 style="color: #2c5aa0; margin: 10px 0;">住み続ける</h4>
                        <p style="font-size: 14px; margin: 0;">引っ越し不要で生活を継続</p>
                    </div>
                </div>
            </div>
            
            <div class="info-card">
                <h3>📊 リースバック利用者データ（2024年調査）</h3>
                <div class="two-column">
                    <div class="column">
                        <h4>年代別利用状況</h4>
                        <table style="width: 100%; margin: 10px 0;">
                            <tr>
                                <td style="padding: 8px; border: 1px solid #ddd; background: #f8f9fa;">50代</td>
                                <td style="padding: 8px; border: 1px solid #ddd; width: 60px;">15%</td>
                                <td style="padding: 8px; border: 1px solid #ddd;">
                                    <div style="width: 30px; height: 10px; background: #4a90e2; border-radius: 5px;"></div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #ddd; background: #f8f9fa;">60代</td>
                                <td style="padding: 8px; border: 1px solid #ddd;">35%</td>
                                <td style="padding: 8px; border: 1px solid #ddd;">
                                    <div style="width: 70px; height: 10px; background: #2c5aa0; border-radius: 5px;"></div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #ddd; background: #f8f9fa;">70代</td>
                                <td style="padding: 8px; border: 1px solid #ddd;">40%</td>
                                <td style="padding: 8px; border: 1px solid #ddd;">
                                    <div style="width: 80px; height: 10px; background: #1a3a5f; border-radius: 5px;"></div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; border: 1px solid #ddd; background: #f8f9fa;">80代</td>
                                <td style="padding: 8px; border: 1px solid #ddd;">10%</td>
                                <td style="padding: 8px; border: 1px solid #ddd;">
                                    <div style="width: 20px; height: 10px; background: #6bb6ff; border-radius: 5px;"></div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="column">
                        <h4>利用目的（複数回答）</h4>
                        <ul style="list-style: none; padding: 0;">
                            <li style="padding: 5px 0; border-bottom: 1px solid #eee;">📈 生活資金確保 <span style="float: right; color: #2c5aa0; font-weight: bold;">68%</span></li>
                            <li style="padding: 5px 0; border-bottom: 1px solid #eee;">🏠 住宅ローン返済 <span style="float: right; color: #2c5aa0; font-weight: bold;">45%</span></li>
                            <li style="padding: 5px 0; border-bottom: 1px solid #eee;">💼 事業資金調達 <span style="float: right; color: #2c5aa0; font-weight: bold;">32%</span></li>
                            <li style="padding: 5px 0; border-bottom: 1px solid #eee;">🏥 医療・介護費用 <span style="float: right; color: #2c5aa0; font-weight: bold;">28%</span></li>
                            <li style="padding: 5px 0; border-bottom: 1px solid #eee;">👨‍👩‍👧‍👦 相続対策 <span style="float: right; color: #2c5aa0; font-weight: bold;">22%</span></li>
                        </ul>
                    </div>
                </div>
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
    
    <!-- 成功事例 -->
    <div class="page">
        <div class="content">
            <h2>🎯 リースバック成功事例</h2>
            
            <div class="info-card">
                <h3>Case 1: 老後資金確保（70代夫婦）</h3>
                <div class="two-column">
                    <div class="column">
                        <h4>🏠 物件概要</h4>
                        <ul>
                            <li>戸建て（東京都練馬区）</li>
                            <li>築25年、4LDK</li>
                            <li>売却価格: 2,800万円</li>
                            <li>月額賃料: 15万円</li>
                        </ul>
                    </div>
                    <div class="column">
                        <h4>📊 活用実績</h4>
                        <ul>
                            <li>💰 受取額: 2,100万円</li>
                            <li>💡 活用法: 老後資金 + 介護準備金</li>
                            <li>😊 満足度: ★★★★★</li>
                            <li>💬 コメント: 「住み慣れた家で安心して老後を過ごせています」</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="info-card">
                <h3>Case 2: 事業資金調達（60代男性）</h3>
                <div class="two-column">
                    <div class="column">
                        <h4>🏠 物件概要</h4>
                        <ul>
                            <li>マンション（神奈川県横浜市）</li>
                            <li>築15年、3LDK</li>
                            <li>売却価格: 3,500万円</li>
                            <li>月額賃料: 18万円</li>
                        </ul>
                    </div>
                    <div class="column">
                        <h4>📊 活用実績</h4>
                        <ul>
                            <li>💰 受取額: 2,600万円</li>
                            <li>💡 活用法: 飲食店開業資金</li>
                            <li>😊 満足度: ★★★★☆</li>
                            <li>💬 コメント: 「事業が軌道に乗り、将来的に買い戻しを検討中」</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="info-card">
                <h3>Case 3: 住宅ローン返済（50代夫婦）</h3>
                <div class="two-column">
                    <div class="column">
                        <h4>🏠 物件概要</h4>
                        <ul>
                            <li>戸建て（埼玉県さいたま市）</li>
                            <li>築10年、4LDK</li>
                            <li>売却価格: 4,200万円</li>
                            <li>月額賃料: 22万円</li>
                        </ul>
                    </div>
                    <div class="column">
                        <h4>📊 活用実績</h4>
                        <ul>
                            <li>💰 受取額: 3,100万円</li>
                            <li>💡 活用法: 住宅ローン完済 + 教育費</li>
                            <li>😊 満足度: ★★★★★</li>
                            <li>💬 コメント: 「月々の負担が大幅に軽減され、家計が楽になりました」</li>
                        </ul>
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
                                <table style="width: 100%; margin: 10px 0;">
                                    <tr>
                                        <td style="padding: 8px; border: 1px solid #ddd; background: #f8f9fa;">老後生活費</td>
                                        <td style="padding: 8px; border: 1px solid #ddd; text-align: right;">月額' . number_format(round($receivable_amount / 240)) . '万円×20年</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px; border: 1px solid #ddd; background: #f8f9fa;">医療・介護費用</td>
                                        <td style="padding: 8px; border: 1px solid #ddd; text-align: right;">' . number_format(round($receivable_amount * 0.3)) . '万円</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px; border: 1px solid #ddd; background: #f8f9fa;">緊急時予備費</td>
                                        <td style="padding: 8px; border: 1px solid #ddd; text-align: right;">' . number_format(round($receivable_amount * 0.2)) . '万円</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="column">
                            <div class="info-card">
                                <h3>投資・事業資金として</h3>
                                <table style="width: 100%; margin: 10px 0;">
                                    <tr>
                                        <td style="padding: 8px; border: 1px solid #ddd; background: #f8f9fa;">住宅ローン返済</td>
                                        <td style="padding: 8px; border: 1px solid #ddd; text-align: right;">' . number_format(round($receivable_amount * 0.6)) . '万円</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px; border: 1px solid #ddd; background: #f8f9fa;">事業拡大資金</td>
                                        <td style="padding: 8px; border: 1px solid #ddd; text-align: right;">' . number_format(round($receivable_amount * 0.4)) . '万円</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px; border: 1px solid #ddd; background: #f8f9fa;">子・孫への援助</td>
                                        <td style="padding: 8px; border: 1px solid #ddd; text-align: right;">' . number_format(round($receivable_amount * 0.3)) . '万円</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-card">
                        <h3>📊 他の資金調達方法との比較</h3>
                        <table style="width: 100%; margin: 15px 0;">
                            <tr>
                                <th style="padding: 10px; border: 1px solid #ddd; background: #2c5aa0; color: white;">調達方法</th>
                                <th style="padding: 10px; border: 1px solid #ddd; background: #2c5aa0; color: white;">調達期間</th>
                                <th style="padding: 10px; border: 1px solid #ddd; background: #2c5aa0; color: white;">住み続け</th>
                                <th style="padding: 10px; border: 1px solid #ddd; background: #2c5aa0; color: white;">調達額</th>
                                <th style="padding: 10px; border: 1px solid #ddd; background: #2c5aa0; color: white;">評価</th>
                            </tr>
                            <tr style="background: #f0f8ff;">
                                <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;">リースバック</td>
                                <td style="padding: 10px; border: 1px solid #ddd;">最短2週間</td>
                                <td style="padding: 10px; border: 1px solid #ddd;">⭕ 可能</td>
                                <td style="padding: 10px; border: 1px solid #ddd;">市場価格の70-80%</td>
                                <td style="padding: 10px; border: 1px solid #ddd;">★★★★★</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; border: 1px solid #ddd;">普通売却</td>
                                <td style="padding: 10px; border: 1px solid #ddd;">3-6ヶ月</td>
                                <td style="padding: 10px; border: 1px solid #ddd;">❌ 不可</td>
                                <td style="padding: 10px; border: 1px solid #ddd;">市場価格の90-100%</td>
                                <td style="padding: 10px; border: 1px solid #ddd;">★★★☆☆</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; border: 1px solid #ddd;">リバースモーゲージ</td>
                                <td style="padding: 10px; border: 1px solid #ddd;">1-2ヶ月</td>
                                <td style="padding: 10px; border: 1px solid #ddd;">⭕ 可能</td>
                                <td style="padding: 10px; border: 1px solid #ddd;">評価額の50-70%</td>
                                <td style="padding: 10px; border: 1px solid #ddd;">★★★☆☆</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px; border: 1px solid #ddd;">不動産担保ローン</td>
                                <td style="padding: 10px; border: 1px solid #ddd;">2-4週間</td>
                                <td style="padding: 10px; border: 1px solid #ddd;">⭕ 可能</td>
                                <td style="padding: 10px; border: 1px solid #ddd;">評価額の60-80%</td>
                                <td style="padding: 10px; border: 1px solid #ddd;">★★☆☆☆</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="success-box">
                <h4>💡 ポイント</h4>
                <p>リースバックで得た資金は非課税です。有効に活用することで、より豊かな生活を実現できます。</p>
            </div>
        </div>
    </div>
    
    <!-- チェックリスト -->
    <div class="page">
        <div class="content">
            <h2>✅ リースバック成功のチェックリスト</h2>
            
            <div class="info-card">
                <h3>🔍 事前準備チェック</h3>
                <div class="two-column">
                    <div class="column">
                        <h4>書類準備</h4>
                        <ul style="list-style: none; padding: 0;">
                            <li style="padding: 8px 0;"><input type="checkbox" style="margin-right: 10px;"> 登記済権利証または登記識別情報</li>
                            <li style="padding: 8px 0;"><input type="checkbox" style="margin-right: 10px;"> 固定資産税納税通知書</li>
                            <li style="padding: 8px 0;"><input type="checkbox" style="margin-right: 10px;"> 住民票・印鑑証明書</li>
                            <li style="padding: 8px 0;"><input type="checkbox" style="margin-right: 10px;"> 建築確認済証・検査済証</li>
                            <li style="padding: 8px 0;"><input type="checkbox" style="margin-right: 10px;"> 住宅ローン残高証明書</li>
                        </ul>
                    </div>
                    <div class="column">
                        <h4>物件確認</h4>
                        <ul style="list-style: none; padding: 0;">
                            <li style="padding: 8px 0;"><input type="checkbox" style="margin-right: 10px;"> 建物の構造・築年数の確認</li>
                            <li style="padding: 8px 0;"><input type="checkbox" style="margin-right: 10px;"> 周辺環境・交通アクセス</li>
                            <li style="padding: 8px 0;"><input type="checkbox" style="margin-right: 10px;"> 修繕履歴・現在の状態</li>
                            <li style="padding: 8px 0;"><input type="checkbox" style="margin-right: 10px;"> 近隣の相場調査</li>
                            <li style="padding: 8px 0;"><input type="checkbox" style="margin-right: 10px;"> 将来の買い戻し可能性</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="info-card">
                <h3>💰 契約内容チェック</h3>
                <div class="two-column">
                    <div class="column">
                        <h4>売買条件</h4>
                        <ul style="list-style: none; padding: 0;">
                            <li style="padding: 8px 0;"><input type="checkbox" style="margin-right: 10px;"> 売却価格の妥当性</li>
                            <li style="padding: 8px 0;"><input type="checkbox" style="margin-right: 10px;"> 諸費用の内訳確認</li>
                            <li style="padding: 8px 0;"><input type="checkbox" style="margin-right: 10px;"> 引き渡し時期の調整</li>
                            <li style="padding: 8px 0;"><input type="checkbox" style="margin-right: 10px;"> 特約事項の確認</li>
                        </ul>
                    </div>
                    <div class="column">
                        <h4>賃貸条件</h4>
                        <ul style="list-style: none; padding: 0;">
                            <li style="padding: 8px 0;"><input type="checkbox" style="margin-right: 10px;"> 月額賃料の妥当性</li>
                            <li style="padding: 8px 0;"><input type="checkbox" style="margin-right: 10px;"> 契約期間・更新条件</li>
                            <li style="padding: 8px 0;"><input type="checkbox" style="margin-right: 10px;"> 敷金・礼金の有無</li>
                            <li style="padding: 8px 0;"><input type="checkbox" style="margin-right: 10px;"> 修繕責任の範囲</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="warning-box">
                <h4>🚨 失敗を避けるための注意点</h4>
                <ul style="margin: 15px 0;">
                    <li><strong>複数社比較は必須</strong> - 1社だけでなく、必ず複数社で査定・条件を比較</li>
                    <li><strong>契約内容は隅々まで確認</strong> - 特に更新条件や修繕責任について</li>
                    <li><strong>感情的な判断は禁物</strong> - 冷静に数字と条件を検討</li>
                    <li><strong>専門家への相談</strong> - 不動産・税務・法務の専門家に事前相談</li>
                    <li><strong>家族との十分な話し合い</strong> - 将来の生活設計を含めて検討</li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- よくある質問 -->
    <div class="page">
        <div class="content">
            <h2>❓ よくあるご質問</h2>
            
            <div class="info-card">
                <h3>Q1. 何歳まで住み続けられますか？</h3>
                <p><strong>A.</strong> 年齢制限はありません。健康である限り、ずっとお住まいいただけます。契約は定期借家契約が一般的ですが、更新により長期居住が可能です。</p>
            </div>
            
            <div class="info-card">
                <h3>Q2. 家族も一緒に住めますか？</h3>
                <p><strong>A.</strong> もちろん可能です。ご家族皆様でこれまで通りお住まいいただけます。ただし、契約時に同居家族全員の記載が必要です。</p>
            </div>
            
            <div class="info-card">
                <h3>Q3. ペットは飼えますか？</h3>
                <p><strong>A.</strong> 現在飼われているペットは、そのまま飼い続けることができます。新たにペットを飼う場合は、事前に相談が必要です。</p>
            </div>
            
            <div class="info-card">
                <h3>Q4. 賃料はどのくらいになりますか？</h3>
                <p><strong>A.</strong> 一般的に売却価格の月額0.5〜0.8%程度です。あなたの場合、約' . number_format($monthly_rent) . '万円が目安です。周辺相場も考慮して決定されます。</p>
            </div>
            
            <div class="info-card">
                <h3>Q5. 査定や相談は無料ですか？</h3>
                <p><strong>A.</strong> はい、査定・ご相談は完全無料です。お気軽にお問い合わせください。契約に至らない場合でも、費用は一切かかりません。</p>
            </div>
            
            <div class="info-card">
                <h3>Q6. 将来買い戻しできますか？</h3>
                <p><strong>A.</strong> 多くの場合、買い戻し特約を付けることができます。買い戻し価格や期間は契約時に取り決めます。</p>
            </div>
            
            <div class="info-card">
                <h3>Q7. 税金はどうなりますか？</h3>
                <p><strong>A.</strong> 売却益には譲渡所得税がかかる場合があります。ただし、居住用財産の特例により最大3,000万円まで非課税となる可能性があります。</p>
            </div>
            
            <div class="info-card">
                <h3>Q8. 近所に知られませんか？</h3>
                <p><strong>A.</strong> 外見上の変化はなく、通常は近隣に知られることはありません。プライバシーは十分に保護されます。</p>
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