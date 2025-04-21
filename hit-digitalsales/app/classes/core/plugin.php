<?php
namespace HITDigitalSales\App\Classes\Core;

class Plugin {
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        // Initialize hooks
        $this->init_hooks();
        
        // Load dependencies
        $this->load_dependencies();
    }
    
    private function init_hooks() {
        // Register activation/deactivation hooks
        register_activation_hook(HITDIGITALSALES_PLUGIN_BASENAME, [$this, 'activate']);
        register_deactivation_hook(HITDIGITALSALES_PLUGIN_BASENAME, [$this, 'deactivate']);
        
        // Init WordPress hooks
        add_action('init', [$this, 'register_post_types']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
    }
    
    private function load_dependencies() {
        // Load controllers
        new \HITDigitalSales\App\Classes\Controller\ProductController(); //Dummy Class
        new \HITDigitalSales\App\Classes\Controller\OrderController();//Dummy Class
        new \HITDigitalSales\App\Classes\Controller\AdminController();//Dummy Class
    }
    
    public function activate() {
        // Create DB tables if needed
        \HITDigitalSales\App\Classes\Core\Database::create_tables();//Dummy Class
    }
    
    public function deactivate() {
        // Cleanup if needed
    }
    
    public function register_post_types() {
        // Register the digital product post type
        register_post_type('hit_digital_product', [
            'labels' => [
                'name' => 'Digital Products',
                'singular_name' => 'Digital Product',
            ],
            'public' => true,
            'has_archive' => true,
            'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
            'menu_icon' => 'dashicons-download',
        ]);
    }
    
    public function enqueue_scripts() {
        // Frontend scripts and styles
        wp_enqueue_style('hit-digitalproduct', HITDIGITALSALES_PLUGIN_URL . 'public/css/frontend.css', [], HITDIGITALSALES_VERSION);
        wp_enqueue_script('hit-digitalproduct', HITDIGITALSALES_PLUGIN_URL . 'public/js/frontend.js', ['jquery'], HITDIGITALSALES_VERSION, true);
    }
    
    public function admin_enqueue_scripts() {
        // Admin scripts and styles
        wp_enqueue_style('hit-digitalproduct-admin', HITDIGITALSALES_PLUGIN_URL . 'public/css/admin.css', [], HITDIGITALSALES_VERSION);
        wp_enqueue_script('hit-digitalproduct-admin', HITDIGITALSALES_PLUGIN_URL . 'public/js/admin.js', ['jquery'], HITDIGITALSALES_VERSION, true);
    }
}

?>