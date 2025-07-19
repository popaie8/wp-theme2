/**
 * AI査定フォーム制御
 * super-simple-form.phpから分離
 */

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