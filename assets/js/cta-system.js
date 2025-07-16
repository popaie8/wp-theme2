/**
 * CTA統合システム JavaScript
 * LINE公式アカウントを含む統合CTAイベント管理
 */

(function() {
    'use strict';

    /**
     * CTA統合システム
     */
    class CTASystem {
        constructor() {
            this.initialized = false;
            this.config = {
                gtag_enabled: typeof gtag !== 'undefined',
                debug: false,
                tracking_events: {
                    assessment_click: 'assessment_click',
                    line_contact: 'line_contact',
                    phone_call: 'phone_call'
                }
            };
            
            this.init();
        }

        /**
         * 初期化
         */
        init() {
            if (this.initialized) return;
            
            document.addEventListener('DOMContentLoaded', () => {
                this.setupEventListeners();
                this.setupFloatingCTAAnimation();
                this.setupSmoothScrolling();
                this.setupAccessibility();
                this.initialized = true;
                
                if (this.config.debug) {
                    console.log('CTA System initialized');
                }
            });
        }

        /**
         * イベントリスナー設定
         */
        setupEventListeners() {
            // すべてのCTA要素にイベントリスナーを設定
            const ctaElements = document.querySelectorAll('[data-gtag-event]');
            
            ctaElements.forEach(element => {
                element.addEventListener('click', (e) => {
                    this.handleCTAClick(e, element);
                });
            });

            // フォーム送信イベント
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', (e) => {
                    this.handleFormSubmit(e, form);
                });
            });
        }

        /**
         * CTA���リックハンドラー
         */
        handleCTAClick(event, element) {
            const gtagEvent = element.getAttribute('data-gtag-event');
            const gtagLabel = element.getAttribute('data-gtag-label');
            const href = element.getAttribute('href');
            
            // GTAG追跡
            this.trackEvent(gtagEvent, gtagLabel, element);
            
            // 特別な処理
            switch (gtagEvent) {
                case 'line_contact':
                    this.handleLineContact(event, element, href);
                    break;
                case 'phone_call':
                    this.handlePhoneCall(event, element, href);
                    break;
                case 'assessment_click':
                    this.handleAssessmentClick(event, element, href);
                    break;
            }
        }

        /**
         * LINE連絡処理
         */
        handleLineContact(event, element, href) {
            event.preventDefault();
            
            // 少し遅延を入れてLINEを開く
            setTimeout(() => {
                window.open(href, '_blank', 'noopener,noreferrer');
            }, 100);
            
            // 確認ダイアログ（オプション）
            if (this.config.debug) {
                console.log('LINE contact initiated');
            }
        }

        /**
         * 電話連絡処理
         */
        handlePhoneCall(event, element, href) {
            // 電話番号の確認メッセージ（オプション）
            if (this.config.debug) {
                console.log('Phone call initiated:', href);
            }
        }

        /**
         * 査定クリック処理
         */
        handleAssessmentClick(event, element, href) {
            // フォームへのスムーズスクロール
            if (href.startsWith('#')) {
                event.preventDefault();
                const targetId = href.substring(1);
                const targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    this.smoothScrollTo(targetElement);
                }
            }
        }

        /**
         * フォーム送信処理
         */
        handleFormSubmit(event, form) {
            const formData = new FormData(form);
            const zip = formData.get('zip');
            const propertyType = formData.get('property-type');
            
            // フォーム送信の追跡
            this.trackEvent('form_submit', 'assessment_form', form, {
                zip: zip,
                property_type: propertyType
            });
            
            if (this.config.debug) {
                console.log('Form submitted:', { zip, propertyType });
            }
        }

        /**
         * GTAGイベント追跡
         */
        trackEvent(event, label, element, additionalData = {}) {
            if (!this.config.gtag_enabled) {
                if (this.config.debug) {
                    console.log('GTAG not available, skipping tracking');
                }
                return;
            }

            const eventData = {
                event_category: 'engagement',
                event_label: label,
                value: 1,
                ...additionalData
            };

            try {
                gtag('event', event, eventData);
                
                if (this.config.debug) {
                    console.log('GTAG event tracked:', event, eventData);
                }
            } catch (error) {
                console.error('GTAG tracking error:', error);
            }
        }

        /**
         * フローティングCTAアニメーション
         */
        setupFloatingCTAAnimation() {
            const floatingCTA = document.querySelector('.floating-cta-enhanced');
            
            if (!floatingCTA) return;

            // 常に表示する
            floatingCTA.style.transform = 'translateY(0)';
            floatingCTA.style.opacity = '1';
            floatingCTA.style.visibility = 'visible';
            
            // スクロールイベントは使用しない（常に表示）
            console.log('Floating CTA always visible');
        }

        /**
         * スムーズスクロール設定
         */
        setupSmoothScrolling() {
            const smoothScrollLinks = document.querySelectorAll('a[href^="#"]');
            
            smoothScrollLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    const href = link.getAttribute('href');
                    if (href === '#') return;
                    
                    e.preventDefault();
                    const targetId = href.substring(1);
                    const targetElement = document.getElementById(targetId);
                    
                    if (targetElement) {
                        this.smoothScrollTo(targetElement);
                    }
                });
            });
        }

        /**
         * スムーズスクロール実行
         */
        smoothScrollTo(element) {
            const headerHeight = 80; // ヘッダーの高さ
            const elementPosition = element.offsetTop;
            const offsetPosition = elementPosition - headerHeight;

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }

        /**
         * アクセシビリティ設定
         */
        setupAccessibility() {
            // キーボードナビゲーション
            const ctaElements = document.querySelectorAll('.cta-base, .cta-button');
            
            ctaElements.forEach(element => {
                element.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        element.click();
                    }
                });
            });

            // フォーカス管理
            this.setupFocusManagement();
        }

        /**
         * フォーカス管理
         */
        setupFocusManagement() {
            let focusableElements = [];
            
            const updateFocusableElements = () => {
                focusableElements = Array.from(document.querySelectorAll(
                    'a, button, input, select, textarea, [tabindex]:not([tabindex="-1"])'
                )).filter(el => !el.disabled && !el.hidden);
            };

            updateFocusableElements();
            
            // 定期的に更新
            setInterval(updateFocusableElements, 1000);
        }

        /**
         * 設定更新
         */
        updateConfig(newConfig) {
            this.config = { ...this.config, ...newConfig };
        }

        /**
         * デバッグモード切り替え
         */
        toggleDebug() {
            this.config.debug = !this.config.debug;
            console.log('CTA System debug mode:', this.config.debug);
        }
    }

    /**
     * ユーティリティ関数
     */
    const Utils = {
        /**
         * 要素の可視性チェック
         */
        isElementVisible(element) {
            const rect = element.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        },

        /**
         * デバウンス
         */
        debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        },

        /**
         * スロットル
         */
        throttle(func, limit) {
            let inThrottle;
            return function() {
                const args = arguments;
                const context = this;
                if (!inThrottle) {
                    func.apply(context, args);
                    inThrottle = true;
                    setTimeout(() => inThrottle = false, limit);
                }
            };
        }
    };

    /**
     * インターセクションオブザーバー（セクションアニメーション）
     */
    const setupIntersectionObserver = () => {
        const sections = document.querySelectorAll('section');
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        sections.forEach(section => {
            observer.observe(section);
        });
    };

    /**
     * グローバル初期化
     */
    window.CTASystem = CTASystem;
    window.CTAUtils = Utils;

    // 自動初期化
    const ctaSystem = new CTASystem();

    // セクションアニメーション初期化
    setupIntersectionObserver();

    // パフォーマンス監視（開発時のみ）
    if (typeof performance !== 'undefined' && performance.mark) {
        performance.mark('cta-system-loaded');
    }

})();
