<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.bonjoro.com
 * @since      1.0.0
 *
 * @package    Bonjoro
 * @subpackage Bonjoro/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Bonjoro
 * @subpackage Bonjoro/admin
 * @author     Simon Hartcher <simon@bonjoro.com>
 */
class Bonjoro_Admin
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Bonjoro_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Bonjoro_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style(
            $this->plugin_name,
            plugin_dir_url(__FILE__) . "css/bonjoro-admin.css",
            [],
            $this->version,
            "all"
        );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Bonjoro_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Bonjoro_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script(
            $this->plugin_name,
            plugin_dir_url(__FILE__) . "js/bonjoro-admin.js",
            ["jquery"],
            $this->version,
            false
        );
    }

    public function admin_settings()
    {
        include "partials/bonjoro-admin-display.php";
    }

    public function register_menu()
    {
        add_options_page(
            "Bonjoro Settings",
            "Bonjoro",
            "manage_options",
            "bonjoro",
            [&$this, "admin_settings"]
        );
    }

    public function register_settings()
    {
        register_setting("bonjoro_plugin_options", "bonjoro_plugin_options", [
            &$this,
            "settings_validate",
        ]);

        add_settings_section(
            "web_delivery_settings",
            "Web Delivery Settings",
            [&$this, "settings_section_web_delivery"],
            "bonjoro"
        );

        add_settings_field(
            "app_id",
            "App ID",
            [&$this, "settings_app_id"],
            "bonjoro",
            "web_delivery_settings"
        );

        add_settings_field(
            "identity_secret",
            "Identity Verification Secret Key",
            [&$this, "settings_identity_secret"],
            "bonjoro",
            "web_delivery_settings"
        );
    }

    public function settings_section_web_delivery()
    {
        echo '<p>
            Retrieve your App ID and Identity Verification Secret Key from the <a href="https://www.bonjoro.com/settings/web-delivery" target="_new">Web Delivery settings page</a>.
	</p>';
    }

    public function settings_app_id()
    {
        $options = get_option("bonjoro_plugin_options");
        $value = $options["app_id"];

        echo sprintf(
            "<input type='text' id='app_id' name='bonjoro_plugin_options[app_id]' required style='width: 300px' value='%s'/>",
            esc_attr($value)
        );
    }

    public function settings_identity_secret()
    {
        $options = get_option("bonjoro_plugin_options");
        $value = $options["identity_secret"];

        echo sprintf(
            "
	<input type='password' id='identity_secret' name='bonjoro_plugin_options[identity_secret]' required style='width: 300px' value='%s'/>
",
            esc_attr($value)
        );
    }

    public function settings_validate($input)
    {
        return $input;
    }
}
