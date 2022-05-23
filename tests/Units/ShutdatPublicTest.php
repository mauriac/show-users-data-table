<?php

declare(strict_types=1);

namespace Shudat\Tests\Units;

use Brain\Monkey\Functions;
use Shudat\ShudatPublic;
use WP;

class ShutdatPublicTest extends AbstractUnitTestcase
{
    public function testRun()
    {
        $shudatPublic = new ShudatPublic('', '');
        $shudatPublic->run();
        self::assertSame(10, has_action(
            'wp_enqueue_scripts',
            'Shudat\ShudatPublic->enqueueStyles()'
        ));
        self::assertSame(10, has_action(
            'wp_enqueue_scripts',
            'Shudat\ShudatPublic->enqueueScripts()'
        ));
        self::assertSame(10, has_action(
            'parse_request',
            'Shudat\ShudatPublic->parseRequest()'
        ));
        self::assertSame(10, has_action(
            'wp_ajax_get-user-details',
            'Shudat\ShudatPublic->retrieveUserDetails()'
        ));
        self::assertSame(10, has_action(
            'wp_ajax_nopriv_get-user-details',
            'Shudat\ShudatPublic->retrieveUserDetails()'
        ));
    }

    public function testEnqueueStyles()
    {
        Functions\expect('wp_enqueue_style')->once()->andReturnNull();
        Functions\expect('plugin_dir_url')->once();

        $shudatPublic = new ShudatPublic('', '');
        self::assertSame(null, $shudatPublic->enqueueStyles());
    }

    public function testEnqueueScripts()
    {
        Functions\expect('wp_enqueue_script')->once()->andReturnNull();
        Functions\expect('plugin_dir_url')->once();
        Functions\expect('admin_url')->once();
        Functions\expect('wp_create_nonce')->once();
        Functions\expect('wp_add_inline_script')->once();
        Functions\expect('wp_json_encode')->once();

        $shudatPublic = new ShudatPublic('', '');
        self::assertSame(null, $shudatPublic->enqueueScripts());
    }

    public function testParseRequest()
    {
        define('SHUDAT_TEXT_DOMAIN', 'shudat');
        $wp = \Mockery::mock(WP::class);
        $wp->request = 'users-table';

        Functions\expect('get_transient')->once()->andReturnNull();
        Functions\expect('wp_remote_get')->once()->andReturnNull();
        Functions\expect('wp_remote_retrieve_response_code')->once()->andReturn(200);
        $fakeJson = '
        {
          "id": 1,
          "name": "Leanne Graham",
          "username": "Bret",
          "email": "Sincere@april.biz",
          "address": {
            "street": "Kulas Light",
            "suite": "Apt. 556",
            "city": "Gwenborough",
            "zipcode": "92998-3874",
            "geo": {
              "lat": "-37.3159",
              "lng": "81.1496"
            }
          },
          "phone": "1-770-736-8031 x56442",
          "website": "hildegard.org",
          "company": {
            "name": "Romaguera-Crona",
            "catchPhrase": "Multi-layered client-server neural-net",
            "bs": "harness real-time e-markets"
          }
        }';
        Functions\expect('wp_remote_retrieve_body')->once()->andReturn($fakeJson);
        Functions\expect('set_transient')->twice()->andReturnNull();
        Functions\expect('load_template')->once()->andReturnNull();
        Functions\expect('plugin_dir_path')->once()->andReturnNull();

        $shudatPublic = new ShudatPublic('', '');
        self::assertSame(null, $shudatPublic->parseRequest($wp));
    }
}
