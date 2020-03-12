<?php
namespace WP_Rocket\Tests\Integration;

use Smush\Core\Settings;
use WP_Rocket\Subscriber\Third_Party\Plugins\Smush_Subscriber;
use WPMedia\PHPUnit\Integration\TestCase;

abstract class SmushSubscriberTestCase extends TestCase {
	protected $subscriber;
	protected $smush;
	protected $smush_settings_option_name;
	protected $smush_settings;
	protected $smush_lazy_option_name;
	protected $smush_lazy;

	public function setUp() {
		parent::setUp();

		$this->subscriber                 = new Smush_Subscriber();
		$this->smush                      = Settings::get_instance();
		$this->smush_settings_option_name = WP_SMUSH_PREFIX . 'settings';
		$this->smush_settings             = $this->smush->get_setting( $this->smush_settings_option_name );
		$this->smush_lazy_option_name     = WP_SMUSH_PREFIX . 'lazy_load';
		$this->smush_lazy                 = $this->smush->get_setting( $this->smush_lazy_option_name );
	}

	public function tearDown() {
		parent::tearDown();

		// Added by \Smush\Core\Settings::__construct().
		remove_action( 'wp_ajax_save_settings', [ $this->subscriber, 'save' ] );
		remove_action( 'wp_ajax_reset_settings', [ $this->subscriber, 'reset' ] );

		$this->smush->set_setting( $this->smush_settings_option_name, $this->smush_settings );
		$this->smush->set_setting( $this->smush_lazy_option_name, $this->smush_lazy );

		$this->subscriber     = null;
		$this->smush_settings = null;
		$this->smush_lazy     = null;
	}

	protected function setSmushSettings( $lazyload_enabled, array $lazyload_formats ) {
		$settings              = $this->smush_settings;
		$settings['lazy_load'] = (bool) $lazyload_enabled;

		$this->smush->set_setting( $this->smush_settings_option_name, $settings );

		$settings           = $this->smush_lazy;
		$settings['format'] = $lazyload_formats;

		$this->smush->set_setting( $this->smush_lazy_option_name, $settings );

		$this->smush->init();
	}
}
