<?php
/**
 * CTA管理システム
 * LINE公式アカウントを含む統合CTAマネージャー
 */

if (!defined('ABSPATH')) {
    exit;
}

class CTAManager {
    
    /**
     * CTA設定
     */
    private static $cta_configs = [
        'floating' => [
            'assessment' => [
                'text' => '無料査定',
                'href' => '#assessment-form',
                'icon' => 'fas fa-calculator',
                'class' => 'cta-primary',
                'priority' => 1,
                'gtag_event' => 'assessment_click',
                'gtag_label' => 'floating_cta'
            ],
            'line' => [
                'text' => 'LINE相談',
                'href' => 'https://line.me/ti/p/@377sitjf',
                'icon' => 'fab fa-line',
                'class' => 'cta-line',
                'priority' => 2,
                'gtag_event' => 'line_contact',
                'gtag_label' => 'floating_cta',
                'target' => '_blank'
            ],
            'phone' => [
                'text' => '電話相談',
                'href' => 'tel:050-5810-5875',
                'icon' => 'fas fa-phone',
                'class' => 'cta-phone',
                'priority' => 3,
                'gtag_event' => 'phone_call',
                'gtag_label' => 'floating_cta'
            ]
        ],
        'header' => [
            'assessment' => [
                'text' => '無料査定',
                'href' => '#assessment-form',
                'icon' => '',
                'class' => 'header-cta-btn',
                'priority' => 1,
                'gtag_event' => 'assessment_click',
                'gtag_label' => 'header_cta'
            ]
        ],
        'inline' => [
            'assessment_primary' => [
                'text' => '無料で相談・査定を依頼する',
                'href' => '#assessment-form',
                'icon' => '',
                'class' => 'cta-button cta-primary',
                'priority' => 1,
                'gtag_event' => 'assessment_click',
                'gtag_label' => 'inline_cta'
            ],
            'line_secondary' => [
                'text' => 'まずLINE相談',
                'href' => 'https://line.me/ti/p/@377sitjf',
                'icon' => 'fab fa-line',
                'class' => 'cta-button cta-line-secondary',
                'priority' => 2,
                'gtag_event' => 'line_contact',
                'gtag_label' => 'inline_cta',
                'target' => '_blank'
            ]
        ]
    ];
    
    /**
     * フローティングCTA出力
     */
    public static function render_floating_cta() {
        $ctas = self::$cta_configs['floating'];
        
        echo '<div class="floating-cta-enhanced">';
        
        foreach ($ctas as $key => $cta) {
            $target = isset($cta['target']) ? ' target="' . esc_attr($cta['target']) . '"' : '';
            $icon = $cta['icon'] ? '<i class="' . esc_attr($cta['icon']) . '"></i>' : '';
            
            echo '<a href="' . esc_url($cta['href']) . '" class="' . esc_attr($cta['class']) . '" data-gtag-event="' . esc_attr($cta['gtag_event']) . '" data-gtag-label="' . esc_attr($cta['gtag_label']) . '"' . $target . '>';
            echo $icon . '<span>' . esc_html($cta['text']) . '</span>';
            echo '</a>';
        }
        
        echo '</div>';
    }
    
    /**
     * ヘッダーCTA出力
     */
    public static function render_header_cta() {
        $ctas = self::$cta_configs['header'];
        
        echo '<div class="header-cta">';
        
        foreach ($ctas as $key => $cta) {
            $target = isset($cta['target']) ? ' target="' . esc_attr($cta['target']) . '"' : '';
            $icon = $cta['icon'] ? '<i class="' . esc_attr($cta['icon']) . '"></i>' : '';
            
            echo '<a href="' . esc_url($cta['href']) . '" class="' . esc_attr($cta['class']) . '" data-gtag-event="' . esc_attr($cta['gtag_event']) . '" data-gtag-label="' . esc_attr($cta['gtag_label']) . '"' . $target . '>';
            echo $icon . esc_html($cta['text']);
            echo '</a>';
        }
        
        echo '</div>';
    }
    
    /**
     * インラインCTA出力
     */
    public static function render_inline_cta($type = 'primary', $additional_class = '') {
        $ctas = self::$cta_configs['inline'];
        
        if ($type === 'primary') {
            $cta = $ctas['assessment_primary'];
        } elseif ($type === 'line') {
            $cta = $ctas['line_secondary'];
        } else {
            $cta = $ctas['assessment_primary'];
        }
        
        $target = isset($cta['target']) ? ' target="' . esc_attr($cta['target']) . '"' : '';
        $icon = $cta['icon'] ? '<i class="' . esc_attr($cta['icon']) . '"></i>' : '';
        $class = $cta['class'] . ($additional_class ? ' ' . $additional_class : '');
        
        echo '<a href="' . esc_url($cta['href']) . '" class="' . esc_attr($class) . '" data-gtag-event="' . esc_attr($cta['gtag_event']) . '" data-gtag-label="' . esc_attr($cta['gtag_label']) . '"' . $target . '>';
        echo $icon . esc_html($cta['text']);
        echo '</a>';
    }
    
    /**
     * 複数CTAグループ出力
     */
    public static function render_cta_group($types = ['primary', 'line'], $wrapper_class = 'cta-group') {
        echo '<div class="' . esc_attr($wrapper_class) . '">';
        
        foreach ($types as $type) {
            self::render_inline_cta($type);
        }
        
        echo '</div>';
    }
    
    /**
     * JavaScript GTAGイベントトラッキング出力
     */
    public static function render_gtag_tracking() {
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // CTA GTAGトラッキング
            const ctaElements = document.querySelectorAll('[data-gtag-event]');
            
            ctaElements.forEach(function(element) {
                element.addEventListener('click', function(e) {
                    const event = this.getAttribute('data-gtag-event');
                    const label = this.getAttribute('data-gtag-label');
                    
                    if (typeof gtag !== 'undefined') {
                        gtag('event', event, {
                            'event_category': 'engagement',
                            'event_label': label,
                            'value': 1
                        });
                    }
                    
                    // LINE CTAの場合は少し遅延を入れる
                    if (event === 'line_contact') {
                        e.preventDefault();
                        setTimeout(function() {
                            window.open(element.href, '_blank');
                        }, 100);
                    }
                });
            });
        });
        </script>
        <?php
    }
    
    /**
     * CTA設定を取得
     */
    public static function get_cta_config($type = 'floating') {
        return self::$cta_configs[$type] ?? [];
    }
    
    /**
     * CTA設定を更新
     */
    public static function update_cta_config($type, $key, $config) {
        if (isset(self::$cta_configs[$type])) {
            self::$cta_configs[$type][$key] = $config;
        }
    }
    
    /**
     * LINE ID設定
     */
    public static function set_line_id($line_id) {
        $line_url = 'https://line.me/ti/p/' . $line_id;
        
        // フローティングCTAのLINE URL更新
        self::$cta_configs['floating']['line']['href'] = $line_url;
        
        // インラインCTAのLINE URL更新
        self::$cta_configs['inline']['line_secondary']['href'] = $line_url;
    }
}
