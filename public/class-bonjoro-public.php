<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.bonjoro.com
 * @since      1.0.0
 *
 * @package    Bonjoro
 * @subpackage Bonjoro/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Bonjoro
 * @subpackage Bonjoro/public
 * @author     Simon Hartcher <simon@bonjoro.com>
 */
class Bonjoro_Public
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
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
    }

    private function load_settings()
    {
        global $current_user;
        $options = get_option("bonjoro_plugin_options");

        $email = $current_user->user_email;
        $app_id = $options["app_id"];
        $identity_secret = $options["identity_secret"];

        if (!($email && $app_id && $identity_secret)) {
            return null;
        }

        return compact("email", "app_id", "identity_secret");
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        $settings = $this->load_settings();

        if (!is_null($settings)) {
            wp_enqueue_script(
                sprintf("%s.js", $this->plugin_name),
                "https://static.bonjoro.com/js/v1/bonjoro.js",
                [],
                $this->version,
                true
            );
            wp_enqueue_script(
                sprintf("%s-public.js", $this->plugin_name),
                plugin_dir_url(__FILE__) . "js/bonjoro-public.js",
                [],
                $this->version,
                true
            );
        }
    }

    public function bonjoro_settings_js()
    {
        $settings = $this->load_settings();

        if (!is_null($settings)) {
            $json = json_encode([
                "appId" => $settings["app_id"],
                "email" => $settings["email"],
                "userHash" => hash_hmac(
                    "SHA256",
                    $settings["email"],
                    $settings["identity_secret"]
                ),
            ]);

            echo sprintf("<script>window.bonjoroSettings = %s</script>", $json);
        }
    }
}
