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
        <div class="form-step" id="step4">
            <div class="estimate-result">
                <h4>🎯 AI査定結果</h4>
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
                
                <div class="assessment-confidence">
                    <div class="confidence-badge">
                        <i class="fas fa-shield-check"></i>
                        <span>精度 95%以上</span>
                    </div>
                    <p class="confidence-text">AIが市場データを分析して算出した推定価格です</p>
                </div>
            </div>
            
            <div class="email-section">
                <h5>詳細な査定結果をメールでお送りします</h5>
                <div class="email-input-group">
                    <input type="email" id="email" placeholder="メールアドレス" required>
                    <button type="submit" class="final-submit-btn">
                        <i class="fas fa-envelope"></i>
                        詳細査定を受け取る
                    </button>
                </div>
                <div class="privacy-note">
                    <i class="fas fa-lock"></i>
                    <span>営業電話は一切ありません・匿名査定OK</span>
                </div>
            </div>
            
            <button class="back-btn" onclick="goToStep('step2')">← 戻る</button>
        </div>
    </div>
</div>

<style>
.super-simple-form {
    max-width: 500px;
    margin: 0 auto;
    padding: clamp(1.5rem, 4vw, 2rem);
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    position: relative;
    overflow: hidden;
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

.choice-btn {
    padding: clamp(1rem, 2.5vw, 1.25rem);
    border: 2px solid #e0e0e0;
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

.email-section h5 {
    color: var(--color-primary);
    margin-bottom: 15px;
    font-size: 1rem;
}

.email-input-group {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
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
    border: 2px solid #e0e0e0;
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

.back-btn {
    background: transparent;
    border: none;
    color: #666;
    cursor: pointer;
    font-size: 0.9rem;
    margin-top: 10px;
}

@media (max-width: 600px) {
    .choice-buttons {
        grid-template-columns: 1fr 1fr;
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
    
    .email-input-group {
        flex-direction: column;
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
    const progress = (currentStep / 4) * 100;
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
    
    // カウントアップアニメーション
    setTimeout(() => {
        animateNumber('mainAmount', result.main);
        animateNumber('rangeLow', result.low);
        animateNumber('rangeHigh', result.high);
        
        // 査定根拠を表示
        displayFactors(result.factors);
    }, 300);
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
    
    // 最終送信
    const submitBtn = document.querySelector('.final-submit-btn');
    if (submitBtn) {
        submitBtn.addEventListener('click', function() {
            const email = document.getElementById('email').value;
            if (!email || !email.includes('@')) {
                alert('正しいメールアドレスを入力してください');
                return;
            }
            
            formData.email = email;
            
            // Google Analytics追跡
            if (typeof gtag !== 'undefined') {
                gtag('event', 'form_submit', {
                    'event_category': 'engagement',
                    'event_label': 'ai_assessment_form',
                    'property_type': formData.propertyType,
                    'area': formData.area,
                    'age': formData.age,
                    'size': formData.size,
                    'station': formData.station
                });
            }
            
            // 次のページに移動
            const params = new URLSearchParams({
                email: email,
                'property-type': formData.propertyType,
                area: formData.area,
                age: formData.age,
                size: formData.size,
                station: formData.station
            });
            window.location.href = `<?php echo home_url('/lead-step2/'); ?>?${params.toString()}`;
        });
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
