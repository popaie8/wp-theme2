<!-- AI査定フォーム -->
<div class="super-simple-form">
    <div class="form-header">
        <h3>🤖 AI即時査定システム</h3>
        <p class="no-info-required">※個人情報不要・匿名OK・精度95%</p>
        <div class="progress-bar">
            <div class="progress-fill" id="progressBar"></div>
        </div>
    </div>
    
    <div class="two-step-form">
        <!-- Step 1: 物件タイプ選択 -->
        <div class="form-step active" id="step1">
            <h4>物件の種類は？</h4>
            <div class="choice-buttons">
                <button class="choice-btn" data-value="house" data-next="step2">
                    <i class="fas fa-home"></i>
                    <span>一戸建て</span>
                </button>
                <button class="choice-btn" data-value="mansion" data-next="step2">
                    <i class="fas fa-building"></i>
                    <span>マンション</span>
                </button>
                <button class="choice-btn" data-value="land" data-next="step2">
                    <i class="fas fa-map"></i>
                    <span>土地</span>
                </button>
                <button class="choice-btn" data-value="other" data-next="step2">
                    <i class="fas fa-question"></i>
                    <span>その他</span>
                </button>
            </div>
        </div>
        
        <!-- Step 2: エリア選択 -->
        <div class="form-step" id="step2">
            <h4>お住まいの地域は？</h4>
            <div class="choice-buttons">
                <button class="choice-btn" data-value="tokyo23" data-next="step3">
                    <i class="fas fa-city"></i>
                    <span>東京23区</span>
                </button>
                <button class="choice-btn" data-value="tokyo-other" data-next="step3">
                    <i class="fas fa-train"></i>
                    <span>東京その他</span>
                </button>
                <button class="choice-btn" data-value="kanagawa" data-next="step3">
                    <i class="fas fa-mountain"></i>
                    <span>神奈川県</span>
                </button>
                <button class="choice-btn" data-value="other-area" data-next="step3">
                    <i class="fas fa-globe"></i>
                    <span>その他の地域</span>
                </button>
            </div>
            <button class="back-btn" onclick="goToStep('step1')">← 戻る</button>
        </div>
        
        <!-- Step 3: 物件詳細 -->
        <div class="form-step" id="step3">
            <h4>物件の詳細を教えてください</h4>
            
            <div class="detail-inputs">
                <div class="detail-group">
                    <label>築年数</label>
                    <div class="quick-select" data-type="age">
                        <button class="quick-btn" data-value="0-5">5年以内</button>
                        <button class="quick-btn" data-value="6-10">6-10年</button>
                        <button class="quick-btn" data-value="11-20">11-20年</button>
                        <button class="quick-btn" data-value="21+">21年以上</button>
                    </div>
                </div>
                
                <div class="detail-group" id="sizeGroup">
                    <label><span id="sizeLabel">広さ</span></label>
                    <div class="size-input">
                        <input type="range" id="sizeRange" min="20" max="200" value="70" step="5">
                        <span class="size-display"><span id="sizeValue">70</span><span id="sizeUnit">㎡</span></span>
                    </div>
                </div>
                
                <div class="detail-group">
                    <label>駅からの距離</label>
                    <div class="quick-select" data-type="station">
                        <button class="quick-btn" data-value="0-5">徒歩5分以内</button>
                        <button class="quick-btn" data-value="6-10">徒歩10分以内</button>
                        <button class="quick-btn" data-value="11-15">徒歩15分以内</button>
                        <button class="quick-btn" data-value="16+">それ以上</button>
                    </div>
                </div>
            </div>
            
            <button class="next-btn" onclick="calculateAndShowResult()" disabled>査定結果を見る</button>
            <button class="back-btn" onclick="goToStep('step2')">← 戻る</button>
        </div>
        
        <!-- Step 4: 査定結果＋メール入力 -->
        <div class="form-step" id="step4" style="position: relative;">
            <!-- 統合された査定結果セクション -->
            <div class="estimate-result blurred" id="estimateResult">
                <h4>🎯 AI査定が完了しました</h4>
                <div class="estimate-amount">
                    <div class="price-animation">
                        <span class="currency">¥</span>
                        <span class="amount-main" id="mainAmount">0</span>
                        <span class="amount-sub">万円</span>
                    </div>
                    <div class="price-range">
                        <span class="range-low" id="rangeLow">0</span>万円 〜 
                        <span class="range-high" id="rangeHigh">0</span>万円
                    </div>
                    <p class="estimate-note">※AI分析による推定価格（誤差±5%）</p>
                </div>
                
                <!-- ぼかしオーバーレイ（モーダルが出るので不要） -->
                <div class="blur-overlay" style="display: none;">
                    <div class="blur-message">
                        <h6>🔒 査定結果を確認</h6>
                        <p>メールアドレスを入力すると<br>詳細な査定結果PDFをお送りします</p>
                    </div>
                </div>
                
                <!-- メール入力モーダル -->
                <div class="email-modal" id="emailModal">
                <div class="email-modal-content">
                    <div class="modal-header">
                        <h5>査定結果を受け取る</h5>
                        <p>詳細な査定レポートPDFをメールでお送りします</p>
                    </div>
                    
                    <div class="modal-body">
                        <input type="email" id="modalEmail" placeholder="メールアドレスを入力" required>
                        <button type="submit" class="modal-submit-btn" onclick="submitEmail()">
                            <i class="fas fa-envelope"></i>
                            査定結果を受け取る
                        </button>
                    </div>
                    
                    <div class="privacy-note">
                        <i class="fas fa-lock"></i>
                        <span>営業電話は一切ありません・匿名査定OK</span>
                    </div>
                </div>
            </div>
            </div>
            
            <!-- 隠しメール入力（既存の処理用） -->
            <input type="email" id="email" style="display:none;">
            
            <!-- PDF査定書サンプルセクション -->
            <div class="pdf-sample-section">
                <h5>📊 プロ仕様の査定結果PDFをお届け</h5>
                <div class="pdf-sample-image">
                    <div class="pdf-mockup">
                        <div class="pdf-header">
                            <i class="fas fa-file-pdf"></i>
                            <span>リースバック査定書</span>
                        </div>
                        <div class="pdf-content">
                            <div class="pdf-section">
                                <h6>📈 査定価格詳細</h6>
                                <div class="pdf-detail">
                                    <span class="detail-label">推定売却価格</span>
                                    <span class="detail-value">¥****万円</span>
                                </div>
                                <div class="pdf-detail">
                                    <span class="detail-label">リースバック賃料</span>
                                    <span class="detail-value">月額**万円</span>
                                </div>
                                <div class="pdf-detail">
                                    <span class="detail-label">買戻し価格目安</span>
                                    <span class="detail-value">¥****万円</span>
                                </div>
                            </div>
                            
                            <div class="pdf-section">
                                <h6>📊 市場分析レポート</h6>
                                <ul class="pdf-list">
                                    <li>周辺相場との比較グラフ</li>
                                    <li>過去3年間の価格推移</li>
                                    <li>エリア別ランキング</li>
                                </ul>
                            </div>
                            
                            <div class="pdf-section">
                                <h6>📚 20ページの活用ガイド</h6>
                                <ul class="pdf-list">
                                    <li>リースバック成功事例15選</li>
                                    <li>税金対策の具体例</li>
                                    <li>よくある失敗と回避方法</li>
                                </ul>
                            </div>
                            
                            <div class="pdf-bonus">
                                <span class="bonus-badge">特典付き</span>
                                <p>業者選定チェックリスト・契約書サンプル・無料相談クーポン</p>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="pdf-features">
                    <span><i class="fas fa-check-circle"></i> 詳細な価格分析</span>
                    <span><i class="fas fa-check-circle"></i> 市場データ比較</span>
                    <span><i class="fas fa-check-circle"></i> リースバック活用ガイド付</span>
                </p>
            </div>
            
            <button class="back-btn" onclick="goToStep('step2')">← 戻る</button>
        </div>
        
        <!-- Step 5: サンクスページ -->
        <div class="form-step" id="step5">
            <div class="thank-you-page">
                <div class="success-icon">✅</div>
                <h3>査定結果PDFをメールで送信しました</h3>
                <div class="pdf-sample-preview">
                    <i class="fas fa-file-pdf"></i>
                    <p>プロ仕様の詳細な査定レポートをお送りしました</p>
                </div>
                <p class="email-notice">数分以内に詳細な査定金額が記載されたPDFが届きます。<br>迷惑メールフォルダもご確認ください。</p>
                
                <div class="next-steps">
                    <h4>📋 より正確な査定をご希望の場合</h4>
                    <p>郵便番号から住所を自動取得し、専門家が精密な査定を行います</p>
                    <a href="#assessment-form" class="detailed-form-link">
                        <i class="fas fa-calculator"></i>
                        正式査定フォームへ進む
                    </a>
                </div>
                
                <div class="contact-info">
                    <h4>📞 お急ぎの場合</h4>
                    <p>TEL: <a href="tel:050-5810-5875">050-5810-5875</a>（9:00〜19:00 年中無休）</p>
                    <p class="contact-note">営業電話は一切ありません</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.super-simple-form {
    max-width: 800px;
    margin: 0 auto;
    padding: clamp(2rem, 5vw, 3rem);
    background: #f8f9fa;
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    position: relative;
    overflow: hidden;
}

/* PC表示での最適化 */
@media (min-width: 768px) {
    .super-simple-form {
        padding: 3rem 4rem;
    }
    
    .form-header h3 {
        font-size: 1.8rem;
    }
    
    .no-info-required {
        font-size: 1.1rem;
    }
}

.super-simple-form::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #1A3A4F, #B98D4A, #1A3A4F);
    z-index: 1;
}

.form-header {
    text-align: center;
    margin-bottom: 30px;
    position: relative;
    z-index: 2;
}

.progress-bar {
    width: 100%;
    height: 6px;
    background: #e0e0e0;
    border-radius: 3px;
    margin-top: 15px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #1A3A4F, #B98D4A);
    border-radius: 3px;
    width: 0%;
    transition: width 0.6s ease;
}

.form-header h3 {
    color: var(--color-primary);
    margin-bottom: 8px;
    font-size: 1.4rem;
}

.no-info-required {
    color: #00AA00;
    font-weight: 600;
    font-size: 0.9rem;
    margin: 0;
}

.form-step {
    display: none;
    animation: fadeIn 0.3s ease-in;
}

.form-step.active {
    display: block;
}

.form-step h4 {
    text-align: center;
    color: var(--color-primary);
    margin-bottom: 24px;
    font-size: 1.2rem;
}

.choice-buttons {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: clamp(0.5rem, 2vw, 0.75rem);
    margin-bottom: var(--spacing-md, 1.5rem);
}

/* PC表示でのボタン配置最適化 */
@media (min-width: 768px) {
    .choice-buttons {
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
}

@media (min-width: 768px) and (max-width: 900px) {
    .choice-buttons {
        grid-template-columns: repeat(2, 1fr);
    }
}

.choice-btn {
    padding: clamp(1rem, 2.5vw, 1.25rem);
    border: 2px solid var(--color-accent);
    border-radius: 12px;
    background: #fff;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    font-size: clamp(0.85rem, 1.5vw, 0.95rem);
    font-weight: 600;
    min-height: 80px;
    justify-content: center;
    position: relative;
}

/* PC表示でのボタンサイズ調整 */
@media (min-width: 768px) {
    .choice-btn {
        padding: 1.5rem 1rem;
        min-height: 120px;
        font-size: 1rem;
    }
    
    .choice-btn i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }
    
    .choice-btn span {
        font-size: 1rem;
    }
}


.choice-btn:hover {
    border-color: var(--color-accent);
    background: #f8f6f3;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.choice-btn.selected {
    border-color: #1A3A4F;
    background: #f0f7ff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(26, 58, 79, 0.2);
}

.choice-btn i {
    font-size: 1.5rem;
    color: var(--color-accent);
}

.estimate-result {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    padding: 25px;
    border-radius: 12px;
    text-align: center;
    margin-bottom: 25px;
    border: 2px solid #28a745;
    position: relative;
    overflow: visible;
}

/* ぼかしオーバーレイ */
.estimate-result.blurred .estimate-amount {
    filter: blur(5px);
    user-select: none;
    pointer-events: none;
}

.blur-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(2px);
    border-radius: 12px;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.estimate-result.blurred .blur-overlay {
    opacity: 1;
    visibility: visible;
}

.blur-message {
    background: white;
    padding: 20px 30px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    text-align: center;
    max-width: 300px;
}

.blur-message h6 {
    color: var(--color-primary);
    font-size: 1.1rem;
    margin-bottom: 10px;
    font-weight: 600;
}

.blur-message p {
    color: #666;
    font-size: 0.9rem;
    margin: 0 0 15px 0;
    line-height: 1.4;
}


.estimate-amount {
    margin-top: 10px;
}

.amount-range {
    font-size: 1.8rem;
    font-weight: 700;
    color: #28a745;
    display: block;
}

.estimate-note {
    font-size: 0.8rem;
    color: #666;
    margin-top: 5px;
}

/* Premium Offer Styles */
.premium-offer {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    padding: 25px;
    border-radius: 15px;
    margin-bottom: 20px;
    border: 2px solid #28a745;
    position: relative;
    overflow: hidden;
}

.premium-offer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #28a745, #20c997, #28a745);
}

.offer-header {
    text-align: center;
    margin-bottom: 20px;
}

.offer-header h5 {
    color: var(--color-primary);
    font-size: 1.2rem;
    margin-bottom: 10px;
    font-weight: 600;
}

.offer-header p {
    color: #666;
    font-size: 0.9rem;
    line-height: 1.5;
    margin: 0;
}

.pdf-features {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
}

.pdf-features span {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #28a745;
    font-weight: 500;
}

.pdf-features i {
    font-size: 0.9em;
}

.offer-benefits {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 20px;
    padding: 15px;
    background: rgba(255, 255, 255, 0.7);
    border-radius: 8px;
}

.benefit-item {
    color: #28a745;
    font-size: 0.9rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
}

.get-guide-btn {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: #fff;
    border: none;
    padding: 15px 20px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

@media (min-width: 600px) {
    .get-guide-btn {
        width: auto;
    }
}

.get-guide-btn:hover {
    background: linear-gradient(135deg, #218838, #1e7e34);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(40, 167, 69, 0.4);
}

.get-guide-btn i {
    margin-right: 8px;
    font-size: 1.1em;
}

/* Thank You Page Styles */
.thank-you-page {
    text-align: center;
    padding: 30px 20px;
}

.success-icon {
    font-size: 4rem;
    margin-bottom: 20px;
    color: #28a745;
}

.thank-you-page h3 {
    color: var(--color-primary);
    font-size: 1.5rem;
    margin-bottom: 15px;
    font-weight: 600;
}

.thank-you-page > p {
    color: #666;
    margin-bottom: 30px;
    line-height: 1.6;
}

.pdf-sample-preview {
    background: linear-gradient(135deg, #fef3f3, #fce4e4);
    padding: 20px;
    border-radius: 12px;
    margin: 20px auto;
    max-width: 400px;
    border: 2px solid #dc3545;
}

.pdf-sample-preview i {
    font-size: 3rem;
    color: #dc3545;
    margin-bottom: 10px;
}

.pdf-sample-preview p {
    margin: 0;
    font-weight: 600;
    color: #dc3545;
}

.email-notice {
    color: #666;
    margin: 20px 0 30px;
    line-height: 1.6;
}

/* メール入力モーダル */
.email-modal {
    position: absolute;
    top: 40%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 100;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    width: 85%;
    max-width: 320px;
}

/* 背景のブラックアウト削除 */

.email-modal.show {
    opacity: 1;
    visibility: visible;
}

.email-modal-content {
    background: white;
    padding: 25px;
    border-radius: 12px;
    width: 100%;
    transform: scale(0.9);
    transition: transform 0.3s ease;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    border: 2px solid var(--color-accent);
}

.email-modal.show .email-modal-content {
    transform: scale(1);
}

.modal-header {
    text-align: center;
    margin-bottom: 30px;
}

.modal-header h5 {
    color: var(--color-primary);
    font-size: 1.5rem;
    margin-bottom: 8px;
}

.modal-header p {
    color: #666;
    font-size: 1rem;
}

.modal-body {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.modal-body input {
    padding: 15px;
    border: 2px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
    width: 100%;
    box-sizing: border-box;
}

.modal-body input:focus {
    border-color: var(--color-accent);
    outline: none;
    box-shadow: 0 0 0 3px rgba(185, 141, 74, 0.1);
}

.modal-submit-btn {
    background: linear-gradient(135deg, var(--color-accent), var(--color-primary));
    color: white;
    border: none;
    padding: 15px 30px;
    border-radius: 8px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.modal-submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(185, 141, 74, 0.4);
}

/* PDF査定書サンプルセクション */
.pdf-sample-section {
    background: white;
    padding: 30px;
    border-radius: 15px;
    margin-top: 25px;
    text-align: center;
    border: 2px solid #e9ecef;
}

.pdf-sample-section h5 {
    color: var(--color-primary);
    font-size: 1.3rem;
    margin-bottom: 20px;
}

.pdf-sample-image {
    margin: 20px 0;
}

.pdf-mockup {
    max-width: 350px;
    margin: 0 auto;
    background: white;
    border: 2px solid #dc3545;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    transform: perspective(1000px) rotateX(5deg);
    transition: transform 0.3s ease;
}

.pdf-mockup:hover {
    transform: perspective(1000px) rotateX(0deg) scale(1.05);
}

.pdf-header {
    background: #dc3545;
    color: white;
    padding: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    font-weight: 600;
}

.pdf-header i {
    font-size: 1.5rem;
}

.pdf-content {
    padding: 20px;
}

.pdf-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    border-bottom: 1px dashed #e9ecef;
}

.pdf-item:last-child {
    border-bottom: none;
}

.pdf-item .label {
    color: #666;
    font-size: 0.9rem;
}

.pdf-item .value {
    font-weight: 600;
    color: var(--color-primary);
    font-size: 1rem;
}

/* PDF詳細コンテンツスタイル */
.pdf-section {
    margin-bottom: 20px;
    text-align: left;
}

.pdf-section h6 {
    color: var(--color-primary);
    font-size: 1rem;
    margin-bottom: 10px;
    font-weight: 600;
}

.pdf-detail {
    display: flex;
    justify-content: space-between;
    padding: 8px 12px;
    background: #f8f9fa;
    margin-bottom: 5px;
    border-radius: 4px;
}

.detail-label {
    color: #666;
    font-size: 0.85rem;
}

.detail-value {
    font-weight: 600;
    color: var(--color-accent);
    font-size: 0.9rem;
}

.pdf-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.pdf-list li {
    padding: 6px 12px;
    background: #f8f9fa;
    margin-bottom: 5px;
    border-radius: 4px;
    font-size: 0.85rem;
    color: #666;
    position: relative;
    padding-left: 28px;
}

.pdf-list li::before {
    content: "✓";
    position: absolute;
    left: 12px;
    color: #28a745;
    font-weight: 600;
}

.pdf-bonus {
    background: linear-gradient(135deg, #fff3cd, #ffeaa7);
    padding: 15px;
    border-radius: 8px;
    text-align: center;
    margin-top: 15px;
    border: 2px solid #ffc107;
}

.bonus-badge {
    background: #ffc107;
    color: #856404;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-block;
    margin-bottom: 8px;
}

.pdf-bonus p {
    margin: 0;
    font-size: 0.85rem;
    color: #856404;
    font-weight: 500;
}

.next-steps {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    padding: 25px;
    border-radius: 12px;
    margin-bottom: 25px;
    border: 2px solid #007bff;
    position: relative;
}

.next-steps::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #007bff, #0056b3, #007bff);
}

.next-steps h4 {
    color: var(--color-primary);
    margin-bottom: 10px;
    font-size: 1.2rem;
}

.next-steps p {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 20px;
    line-height: 1.5;
}

.detailed-form-link {
    display: inline-block;
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: #fff;
    padding: 12px 24px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
}

.detailed-form-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 123, 255, 0.4);
    color: #fff;
    text-decoration: none;
}

.detailed-form-link i {
    margin-right: 8px;
}

.contact-info {
    background: rgba(255, 255, 255, 0.8);
    padding: 20px;
    border-radius: 12px;
    border: 1px solid #e0e0e0;
}

.contact-info h4 {
    color: var(--color-primary);
    margin-bottom: 10px;
    font-size: 1.1rem;
}

.contact-info p {
    margin-bottom: 5px;
    color: #666;
}

.contact-info a {
    color: var(--color-primary);
    text-decoration: none;
    font-weight: 600;
}

.contact-info a:hover {
    color: var(--color-accent);
}

.contact-note {
    font-size: 0.85rem;
    color: #28a745;
    font-weight: 500;
}

.email-section h5 {
    color: var(--color-primary);
    margin-bottom: 15px;
    font-size: 1rem;
}

.email-input-group {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
    flex-direction: column;
}

@media (min-width: 600px) {
    .email-input-group {
        flex-direction: row;
    }
}

.email-input-group input {
    flex: 1;
    padding: 15px;
    border: 2px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
}

.final-submit-btn {
    background: var(--color-accent);
    color: #fff;
    border: none;
    padding: 15px 20px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.final-submit-btn:hover {
    background: #A67C42;
    transform: translateY(-1px);
}

.privacy-note {
    text-align: center;
    font-size: 0.8rem;
    color: #28a745;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
}

/* 詳細入力スタイル */
.detail-inputs {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.detail-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.detail-group label {
    font-weight: 600;
    color: #1A3A4F;
    font-size: 0.9rem;
}

.quick-select {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
    gap: 0.5rem;
}

.quick-btn {
    padding: 0.5rem;
    border: 2px solid var(--color-accent);
    border-radius: 8px;
    background: #fff;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.8rem;
    font-weight: 500;
}

.quick-btn:hover {
    border-color: #B98D4A;
    background: #faf8f5;
}

.quick-btn.selected {
    border-color: #1A3A4F;
    background: #1A3A4F;
    color: white;
}

.size-input {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.size-input input[type="range"] {
    flex: 1;
    height: 8px;
    background: #e0e0e0;
    border-radius: 4px;
    outline: none;
    -webkit-appearance: none;
}

.size-input input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 20px;
    height: 20px;
    background: #1A3A4F;
    border-radius: 50%;
    cursor: pointer;
}

.size-input input[type="range"]::-moz-range-thumb {
    width: 20px;
    height: 20px;
    background: #1A3A4F;
    border-radius: 50%;
    cursor: pointer;
    border: none;
}

.size-display {
    font-weight: 600;
    color: #1A3A4F;
    font-size: 1.1rem;
    min-width: 80px;
    text-align: center;
}

.next-btn {
    padding: 1rem 2rem;
    background: linear-gradient(135deg, #1A3A4F, #0F2A3F);
    color: white;
    border: none;
    border-radius: 25px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 1rem;
}

.next-btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(26, 58, 79, 0.3);
}

.next-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* 査定結果スタイル */
.price-animation {
    display: flex;
    align-items: baseline;
    justify-content: center;
    gap: 0.25rem;
    margin: 1rem 0;
}

.currency {
    font-size: 1.2rem;
    color: #666;
}

.amount-main {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1A3A4F;
    animation: countUp 2s ease-out;
}

.amount-sub {
    font-size: 1.2rem;
    color: #666;
}

.price-range {
    text-align: center;
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.assessment-confidence {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    padding: 1rem;
    border-radius: 8px;
    margin-top: 1rem;
    text-align: center;
}

.confidence-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: #28a745;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.confidence-badge i {
    font-size: 1em;
}

.confidence-text {
    margin: 0;
    font-size: 0.8rem;
    color: #666;
    line-height: 1.4;
}

@keyframes countUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ぼかし状態でもアニメーションが見える */
.estimate-result.blurred .price-animation {
    animation: pulseBlurred 2s ease-out;
}

@keyframes pulseBlurred {
    0% {
        transform: scale(0.8);
        opacity: 0.5;
    }
    50% {
        transform: scale(1.1);
        opacity: 0.8;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.back-btn {
    background: transparent;
    border: none;
    color: #666;
    cursor: pointer;
    font-size: 0.9rem;
    margin-top: 10px;
}

/* PC表示での詳細入力最適化 */
@media (min-width: 768px) {
    .detail-inputs {
        gap: 2rem;
    }
    
    .detail-group label {
        font-size: 1rem;
        margin-bottom: 0.75rem;
    }
    
    .quick-select {
        gap: 1rem;
    }
    
    .quick-btn {
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
    }
    
    .size-input {
        gap: 1.5rem;
    }
    
    .size-display {
        font-size: 1.3rem;
    }
    
    .next-btn {
        padding: 1.25rem 3rem;
        font-size: 1.1rem;
        margin-top: 2rem;
    }
}

@media (max-width: 600px) {
    .choice-buttons {
        grid-template-columns: 1fr 1fr;
    }
    
    .email-modal {
        width: 90%;
        max-width: 300px;
    }
    
    .email-modal-content {
        padding: 20px;
    }
}

@media (max-width: 400px) {
    .super-simple-form {
        padding: 1rem;
        border-radius: 0;
        box-shadow: none;
    }
    
    .choice-buttons {
        grid-template-columns: 1fr;
    }
    
    .final-submit-btn {
        width: 100%;
    }
    
    .quick-select {
        grid-template-columns: 1fr 1fr;
    }
    
    .size-input {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .size-display {
        order: -1;
    }
    
    .detail-inputs {
        gap: 1rem;
    }
    
    .price-animation {
        flex-direction: column;
        gap: 0;
    }
    
    .amount-main {
        font-size: 2rem;
    }
    
    .premium-offer {
        padding: 20px;
        margin-bottom: 15px;
    }
    
    .offer-header h5 {
        font-size: 1.1rem;
    }
    
    .offer-header p {
        font-size: 0.85rem;
    }
    
    .offer-benefits {
        padding: 12px;
    }
    
    .benefit-item {
        font-size: 0.85rem;
    }
}
</style>

<script>
// グローバル変数
let formData = {};
let currentStep = 1;

// ステップ移動関数（グローバル）
function goToStep(stepId) {
    document.querySelectorAll('.form-step').forEach(step => {
        step.classList.remove('active');
    });
    document.getElementById(stepId).classList.add('active');
    
    // プログレスバー更新
    const stepNumber = parseInt(stepId.replace('step', ''));
    currentStep = stepNumber;
    updateProgress();
}

// プログレスバー更新
function updateProgress() {
    const progress = (currentStep / 5) * 100;
    document.getElementById('progressBar').style.width = progress + '%';
}

// 詳細選択の検証
function validateStep3() {
    const hasAge = formData.age !== undefined;
    const hasSize = formData.size !== undefined;
    const hasStation = formData.station !== undefined;
    
    const nextBtn = document.querySelector('.next-btn');
    if (hasAge && hasSize && hasStation) {
        nextBtn.disabled = false;
    } else {
        nextBtn.disabled = true;
    }
}

// 高度な査定計算
function calculateAdvancedEstimate() {
    // 基準価格設定
    const basePrice = {
        'house': {
            'tokyo23': 4000,
            'tokyo-other': 3200,
            'kanagawa': 2800,
            'other-area': 2200
        },
        'mansion': {
            'tokyo23': 4500,
            'tokyo-other': 3600,
            'kanagawa': 3200,
            'other-area': 2600
        },
        'land': {
            'tokyo23': 6000,
            'tokyo-other': 4000,
            'kanagawa': 3200,
            'other-area': 2400
        },
        'other': {
            'tokyo23': 3000,
            'tokyo-other': 2400,
            'kanagawa': 2000,
            'other-area': 1600
        }
    };
    
    let price = basePrice[formData.propertyType][formData.area];
    let factors = [];
    
    // 築年数補正
    const ageMultiplier = {
        '0-5': 1.15,
        '6-10': 1.05,
        '11-20': 0.95,
        '21+': 0.85
    };
    const ageEffect = ageMultiplier[formData.age];
    price *= ageEffect;
    factors.push({
        name: '築年数',
        value: formData.age.replace('-', '〜') + '年',
        effect: ageEffect > 1 ? '+' + Math.round((ageEffect - 1) * 100) + '%' : Math.round((ageEffect - 1) * 100) + '%'
    });
    
    // 広さ補正
    const size = formData.size;
    let sizeMultiplier = 1;
    if (formData.propertyType === 'land') {
        sizeMultiplier = size < 50 ? 0.9 : size > 150 ? 1.1 : 1.0;
    } else {
        sizeMultiplier = size < 50 ? 0.9 : size > 100 ? 1.1 : 1.0;
    }
    price *= sizeMultiplier;
    factors.push({
        name: '広さ',
        value: size + (formData.propertyType === 'land' ? '㎡' : '㎡'),
        effect: sizeMultiplier > 1 ? '+' + Math.round((sizeMultiplier - 1) * 100) + '%' : sizeMultiplier < 1 ? Math.round((sizeMultiplier - 1) * 100) + '%' : '標準'
    });
    
    // 駅距離補正
    const stationMultiplier = {
        '0-5': 1.1,
        '6-10': 1.0,
        '11-15': 0.95,
        '16+': 0.9
    };
    const stationEffect = stationMultiplier[formData.station];
    price *= stationEffect;
    factors.push({
        name: '駅距離',
        value: formData.station.replace('-', '〜') + '分',
        effect: stationEffect > 1 ? '+' + Math.round((stationEffect - 1) * 100) + '%' : stationEffect < 1 ? Math.round((stationEffect - 1) * 100) + '%' : '標準'
    });
    
    // 最終価格計算
    const finalPrice = Math.round(price);
    const lowRange = Math.round(finalPrice * 0.9);
    const highRange = Math.round(finalPrice * 1.1);
    
    return {
        main: finalPrice,
        low: lowRange,
        high: highRange,
        factors: factors
    };
}

// 査定結果表示
function calculateAndShowResult() {
    const result = calculateAdvancedEstimate();
    
    // アニメーション付きで結果を表示
    goToStep('step4');
    
    // 結果をぼかした状態で表示
    const estimateResult = document.getElementById('estimateResult');
    if (estimateResult) {
        estimateResult.classList.add('blurred');
    }
    
    // カウントアップアニメーション（ぼかした状態で実行）
    setTimeout(() => {
        animateNumber('mainAmount', result.main);
        animateNumber('rangeLow', result.low);
        animateNumber('rangeHigh', result.high);
        
        // 査定根拠を表示
        displayFactors(result.factors);
        
        // アニメーション完了後にモーダルを表示
        setTimeout(() => {
            showEmailModal();
        }, 2000);
    }, 300);
}

// メールモーダル表示
function showEmailModal() {
    const modal = document.getElementById('emailModal');
    if (modal) {
        modal.classList.add('show');
        document.getElementById('modalEmail').focus();
    }
}

// メール送信処理
function submitEmail() {
    const email = document.getElementById('modalEmail').value;
    if (!email || !email.includes('@')) {
        alert('正しいメールアドレスを入力してください');
        return;
    }
    
    // 元のメール入力フィールドに値をコピー
    document.getElementById('email').value = email;
    
    // モーダルを閉じる
    const modal = document.getElementById('emailModal');
    if (modal) {
        modal.classList.remove('show');
    }
    
    // 既存の送信処理を実行
    const getGuideBtn = document.querySelector('.get-guide-btn');
    if (getGuideBtn) {
        getGuideBtn.click();
    }
}

// 数値アニメーション
function animateNumber(elementId, targetValue) {
    const element = document.getElementById(elementId);
    let currentValue = 0;
    const increment = targetValue / 50;
    
    const animation = setInterval(() => {
        currentValue += increment;
        if (currentValue >= targetValue) {
            currentValue = targetValue;
            clearInterval(animation);
        }
        element.textContent = Math.round(currentValue);
    }, 40);
}

// 査定根拠は内部処理のみ（表示しない）
function displayFactors(factors) {
    // 内部的には詳細な計算を行うが、UIには表示しない
    console.log('査定根拠（内部処理）:', factors);
}

// DOMContentLoaded時の処理
document.addEventListener('DOMContentLoaded', function() {
    updateProgress();
    
    // 選択肢ボタンのクリック処理
    document.querySelectorAll('.choice-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const value = this.getAttribute('data-value');
            const nextStep = this.getAttribute('data-next');
            
            // 前の選択をクリア
            this.parentElement.querySelectorAll('.choice-btn').forEach(b => b.classList.remove('selected'));
            this.classList.add('selected');
            
            // データ保存
            if (nextStep === 'step2') {
                formData.propertyType = value;
            } else if (nextStep === 'step3') {
                formData.area = value;
                // 物件タイプに応じてサイズラベルを更新
                updateSizeLabel();
            }
            
            // 次のステップに進む
            setTimeout(() => {
                goToStep(nextStep);
            }, 300);
        });
    });
    
    // 詳細選択ボタンのクリック処理
    document.querySelectorAll('.quick-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const value = this.getAttribute('data-value');
            const type = this.parentElement.getAttribute('data-type');
            
            // 前の選択をクリア
            this.parentElement.querySelectorAll('.quick-btn').forEach(b => b.classList.remove('selected'));
            this.classList.add('selected');
            
            // データ保存
            formData[type] = value;
            
            // 検証
            validateStep3();
        });
    });
    
    // サイズスライダーの処理
    const sizeRange = document.getElementById('sizeRange');
    if (sizeRange) {
        sizeRange.addEventListener('input', function() {
            const value = this.value;
            document.getElementById('sizeValue').textContent = value;
            formData.size = parseInt(value);
            validateStep3();
        });
    }
    
    // 無料ガイド取得
    const getGuideBtn = document.querySelector('.get-guide-btn');
    if (getGuideBtn) {
        getGuideBtn.addEventListener('click', function() {
            const email = document.getElementById('email').value;
            if (!email || !email.includes('@')) {
                alert('正しいメールアドレスを入力してください');
                return;
            }
            
            console.log('送信データ:', {
                email: email,
                propertyType: formData.propertyType,
                area: formData.area,
                age: formData.age,
                size: formData.size,
                station: formData.station,
                estimated: calculateAdvancedEstimate()
            });
            
            formData.email = email;
            
            // ぼかしは解除しない（メールで確認してもらう）
            // const estimateResult = document.getElementById('estimateResult');
            // if (estimateResult) {
            //     estimateResult.classList.remove('blurred');
            // }
            
            // Google Analytics追跡
            if (typeof gtag !== 'undefined') {
                gtag('event', 'ai_assessment_guide_request', {
                    'event_category': 'engagement',
                    'event_label': 'ai_assessment_guide',
                    'property_type': formData.propertyType,
                    'area': formData.area,
                    'age': formData.age,
                    'size': formData.size,
                    'station': formData.station
                });
            }
            
            // AJAX送信でガイドリクエスト処理
            sendAssessmentWithGuide(email, formData);
        });
    }
    
    // 査定結果とガイド送信関数
    function sendAssessmentWithGuide(email, assessmentData) {
        // ローディング表示
        const button = document.querySelector('.get-guide-btn');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> 送信中...';
        button.disabled = true;
        
        // AJAX送信
        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'ai_assessment_submit',
                email: email,
                property_type: assessmentData.propertyType,
                area: assessmentData.area,
                age: assessmentData.age,
                size: assessmentData.size,
                station: assessmentData.station,
                estimated_price: calculateAdvancedEstimate().main,
                estimated_low: calculateAdvancedEstimate().low,
                estimated_high: calculateAdvancedEstimate().high,
                nonce: '<?php echo wp_create_nonce('ai_assessment_nonce'); ?>'
            })
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.text();
        })
        .then(text => {
            console.log('Response text:', text);
            try {
                const data = JSON.parse(text);
                if (data.success) {
                    showThankYouPage();
                } else {
                    console.error('Server error:', data);
                    alert('送信に失敗しました: ' + (data.data || '不明なエラー'));
                    button.innerHTML = originalText;
                    button.disabled = false;
                }
            } catch (e) {
                console.error('JSON parse error:', e);
                console.error('Response was:', text);
                alert('サーバーエラーが発生しました。');
                button.innerHTML = originalText;
                button.disabled = false;
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('ネットワークエラーが発生しました。');
            button.innerHTML = originalText;
            button.disabled = false;
        });
    }
    
    // サンクスページ表示
    function showThankYouPage() {
        goToStep('step5');
    }
});

// 物件タイプに応じてサイズラベルを更新
function updateSizeLabel() {
    const sizeLabel = document.getElementById('sizeLabel');
    const sizeUnit = document.getElementById('sizeUnit');
    
    if (formData.propertyType === 'land') {
        sizeLabel.textContent = '土地面積';
        sizeUnit.textContent = '㎡';
    } else {
        sizeLabel.textContent = '延床面積';
        sizeUnit.textContent = '㎡';
    }
}
</script>
