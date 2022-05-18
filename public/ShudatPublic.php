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
            plugin_dir_url(__FILE__) . 'css/shut-public.css',
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
            plugin_dir_url(__FILE__) . 'js/shut-public.js',
            [ 'jquery' ],
            $this->version,
            false
        );

    }

    /**
     * Displays users table pages
     *
     * @param  mixed $wp Current WordPress environment instance.
     * @return void
     */
    public function parseRequest($wp)
    {

        if ('users-table' === $wp->request) {
            $url = 'https://jsonplaceholder.typicode.com/users/';
            $args = [];
            $response = wp_remote_get($url, $args);
            $usersList = json_decode(wp_remote_retrieve_body($response), true);

            load_template(plugin_dir_path(__FILE__) . 'showTable.php', true, $usersList);
            exit;
        }
    }
}
