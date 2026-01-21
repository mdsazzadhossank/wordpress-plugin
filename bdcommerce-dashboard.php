
<?php
/**
 * Plugin Name: BdCommerce E-Commerce Dashboard
 * Description: A high-fidelity administrative dashboard for e-commerce management featuring real-time statistics, order tracking, and AI insights.
 * Version: 1.0.0
 * Author: BdCommerce
 * Text Domain: bdcommerce-dashboard
 */

if (!defined('ABSPATH')) exit;

class BdCommerceDashboard {
    public function __construct() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    public function add_admin_menu() {
        add_menu_page(
            'BdCommerce Dashboard',
            'BdCommerce',
            'manage_options',
            'bdcommerce-dashboard',
            [$this, 'render_dashboard'],
            'dashicons-chart-area', // Icon
            2
        );
    }

    public function enqueue_scripts($hook) {
        if ($hook !== 'toplevel_page_bdcommerce-dashboard') {
            return;
        }

        $plugin_url = plugin_dir_url(__FILE__);
        $plugin_path = plugin_dir_path(__FILE__);

        // Enqueue React Build JS
        wp_enqueue_script(
            'bdcommerce-react-main',
            $plugin_url . 'dist/assets/main.js',
            ['wp-element'],
            '1.0.0',
            true
        );

        // Enqueue React Build CSS
        wp_enqueue_style(
            'bdcommerce-react-styles',
            $plugin_url . 'dist/assets/main.css',
            [],
            '1.0.0'
        );

        // Pass Configuration to React
        wp_localize_script('bdcommerce-react-main', 'bdcommercePlugin', [
            'apiUrl' => $plugin_url . 'api/',
            'nonce' => wp_create_nonce('wp_rest'),
            'adminUrl' => admin_url(),
            'siteUrl' => site_url(),
            'assetsUrl' => $plugin_url . 'dist/assets/'
        ]);
    }

    public function render_dashboard() {
        echo '<div id="root"></div>';
    }
}

new BdCommerceDashboard();
