<?php

declare(strict_types=1);

namespace Shudat;

class ShudatPublic
{
    /**
     * The ID of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string    $pluginName    The ID of this plugin.
     */
    private $pluginName;

    /**
     * The version of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initializes the class and sets its properties.
     *
     * @since 1.0.0
     * @param string $pluginName The name of the plugin.
     * @param string $version    The version of this plugin.
     */
    public function __construct(string $pluginName, string $version)
    {

        $this->pluginName = $pluginName;
        $this->version = $version;
    }

    /**
     * Run all wp hook
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function run()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueStyles']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
        add_action('parse_request', [$this, 'parseRequest']);
        add_action('wp_ajax_get-user-details', [$this, 'retrieveUserDetails']);
        add_action('wp_ajax_nopriv_get-user-details', [$this, 'retrieveUserDetails']);
    }

    /**
     * Registers the stylesheets for the public-facing side of the site.
     *
     * @since 1.0.0
     */
    public function enqueueStyles()
    {
        wp_enqueue_style(
            $this->pluginName,
            plugin_dir_url(__FILE__) . 'css/ShudatPublic.css',
            [],
            $this->version,
            'all'
        );
    }

    /**
     * Registers the JavaScript for the public-facing side of the site.
     *
     * @since 1.0.0
     */
    public function enqueueScripts()
    {
        wp_enqueue_script(
            $this->pluginName,
            plugin_dir_url(__FILE__) . 'js/ShudatPublic.js',
            [ 'jquery' ],
            $this->version,
            false
        );

        $data = [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'shut_ajax_security' => wp_create_nonce('shut-ajax-nonce'),
        ];
        wp_add_inline_script($this->pluginName, 'const shutData = ' . wp_json_encode($data));
    }

    /**
     * Displays users table pages
     *
     * @param  mixed $wp Current WordPress environment instance.
     * @return void
     */
    public function parseRequest($wp)
    {
        if ('users-table' !== $wp->request) {
            return;
        }
        $usersList = get_transient('shudat_users');
        if (! $usersList) {
            $url = 'https://jsonplaceholder.typicode.com/users/';
            $response = wp_remote_get($url);
            if (200 !== wp_remote_retrieve_response_code($response)) {
                echo esc_html__('No data to display!', 'shudat');
                self::exitCode();
            }

            $usersList = json_decode(wp_remote_retrieve_body($response), true);
            if (! $usersList) {
                self::exitCode();
            }

            set_transient('shudat_users', $usersList, 3600);
            set_transient('shudat_users_detail', $usersList, 3600);
        }

        $templatePath = locate_template('ShowTable.php');
        if (! $templatePath) {
            $templatePath = plugin_dir_path(__FILE__) . 'ShowTable.php';
        }
        load_template($templatePath, true, $usersList);
        self::exitCode();
    }

    /**
     * Gets user details
     *
     * @return void
     */
    public function retrieveUserDetails()
    {
        if (check_ajax_referer('shut-ajax-nonce', 'security')) {
            $userId = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_NUMBER_INT);

            $usersList = get_transient('shudat_users_detail');
            if (isset($usersList[$userId - 1])) {
                $userData = is_array($usersList[$userId - 1]) ? json_encode($usersList[$userId - 1]) : $usersList[$userId - 1];

                wp_send_json_success($userData);
            }
            $url = 'https://jsonplaceholder.typicode.com/users/' . $userId;
            $response = wp_remote_get($url);
            if (200 !== wp_remote_retrieve_response_code($response)) {
                wp_send_json_error(__('Failed to get user details!', 'shudat'));
            }

            $userData = wp_remote_retrieve_body($response);
            if (! $userData) {
                wp_send_json_error(__('No data to display!', 'shudat'));
            }

            $usersList[$userId - 1] = $userData;
            set_transient('shudat_users_detail', $usersList, 3600);
            wp_send_json_success($userData);
        }
        wp_send_json_error(__('Wrong request!', 'shudat'));
    }

    /**
     * Exits from the Code
     *
     * @return void
     */
    public static function exitCode()
    {
        if (! defined('PHPUNIT_RUNNING') || ! PHPUNIT_RUNNING === 1) {
            exit;
        }
    }
}
