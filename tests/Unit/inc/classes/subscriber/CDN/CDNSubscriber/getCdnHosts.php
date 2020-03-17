<?php

namespace WP_Rocket\Tests\Unit\inc\classes\subscriber\CDN\CDNSubscriber;

use Brain\Monkey\Functions;
use WPMedia\PHPUnit\Unit\TestCase;
use WP_Rocket\Admin\Options_Data;
use WP_Rocket\CDN\CDN;
use WP_Rocket\Subscriber\CDN\CDNSubscriber;

/**
 * @covers \WP_Rocket\Subscriber\CDN\CDNSubscriber::get_cdn_hosts
 * @group  CDN
 */
class Test_GetCdnHosts extends TestCase {
	private $cdn;
	private $subscriber;

	public function setUp() {
		parent::setUp();

		$this->cdn        = $this->createMock( CDN::class );
		$this->subscriber = new CDNSubscriber(
			$this->createMock( Options_Data::class ),
			$this->cdn
		);

		Functions\when( 'get_rocket_parse_url' )->alias( function( $url ) {
			$parsed = parse_url( $url );

			$host     = isset( $parsed['host'] ) ? strtolower( urldecode( $parsed['host'] ) ) : '';
			$path     = isset( $parsed['path'] ) ? urldecode( $parsed['path'] ) : '';
			$scheme   = isset( $parsed['scheme'] ) ? urldecode( $parsed['scheme'] ) : '';
			$query    = isset( $parsed['query'] ) ? urldecode( $parsed['query'] ) : '';
			$fragment = isset( $parsed['fragment'] ) ? urldecode( $parsed['fragment'] ) : '';

			return [
				'host'     => $host,
				'path'     => $path,
				'scheme'   => $scheme,
				'query'    => $query,
				'fragment' => $fragment,
			];
		} );
		Functions\when( 'rocket_add_url_protocol' )->alias( function( $url ) {
			if ( strpos( $url, 'http://' ) !== false || strpos( $url, 'https://' ) !== false ) {
				return $url;
			}

			if ( substr( $url, 0, 2 ) === '//' ) {
				return 'http:' . $url;
			}

			return 'http://' . $url;
		} );
	}

	public function addDataProvider() {
        return $this->getTestData( __DIR__, 'get-cdn-hosts' );
    }

	/**
	 * @dataProvider addDataProvider
	 */
	public function testShouldReturnCdnArray( $original, $zones, $cdn_urls, $expected ) {
		$this->cdn->expects( $this->once() )
			->method( 'get_cdn_urls' )
			->willReturn( $cdn_urls );

		$this->assertSame(
			$expected,
			array_values( $this->subscriber->get_cdn_hosts( $original, $zones ) )
		);
	}
}
