<!-- 信頼性インジケーター -->
<div class="trust-indicators">
    <div class="container">
        <div class="trust-grid">
            <div class="trust-item">
                <div class="trust-icon">
                    <i class="fas fa-ban"></i>
                </div>
                <h4>営業電話0件保証</h4>
                <p>しつこい営業電話は一切行いません。お客様のペースを最優先します。</p>
            </div>
            
            <div class="trust-item">
                <div class="trust-icon">
                    <i class="fas fa-user-secret"></i>
                </div>
                <h4>完全匿名査定</h4>
                <p>個人情報なしでも概算査定が可能。安心してご利用いただけます。</p>
            </div>
            
            <div class="trust-item">
                <div class="trust-icon">
                    <i class="fas fa-award"></i>
                </div>
                <h4>査定実績1,250件</h4>
                <p>多くのお客様にご利用いただいた<br>実績と信頼があります。</p>
            </div>
            
            <div class="trust-item">
                <div class="trust-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h4>24時間以内に回答</h4>
                <p>お問い合わせから24時間以内に<br>必ずご連絡いたします。</p>
            </div>
        </div>
        
        <div class="security-badges">
            <div class="badge">
                <i class="fas fa-lock"></i>
                <span>SSL暗号化</span>
            </div>
            <div class="badge">
                <i class="fas fa-certificate"></i>
                <span>プライバシーマーク</span>
            </div>
            <div class="badge">
                <i class="fas fa-building"></i>
                <span>宅建免許取得</span>
            </div>
        </div>
    </div>
</div>

<style>
.trust-indicators {
    background: #f8f9fa;
    padding: 60px 0;
}

.trust-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

.trust-item {
    background: #fff;
    padding: 30px 20px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
}

.trust-item:hover {
    transform: translateY(-5px);
}

.trust-icon {
    width: 60px;
    height: 60px;
    background: var(--color-accent);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.trust-icon i {
    font-size: 1.5rem;
    color: #fff;
}

.trust-item h4 {
    color: var(--color-primary);
    margin-bottom: 15px;
    font-size: 1.1rem;
}

.trust-item p {
    color: #666;
    font-size: 0.9rem;
    line-height: 1.5;
}

.security-badges {
    display: flex;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
}

.badge {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 15px;
    background: #fff;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--color-primary);
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.badge i {
    color: var(--color-accent);
}

@media (max-width: 768px) {
    .trust-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .security-badges {
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }
}
</style>
