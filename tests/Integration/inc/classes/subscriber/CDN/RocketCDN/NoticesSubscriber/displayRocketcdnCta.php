<?php

namespace WP_Rocket\Tests\Integration\inc\classes\subscriber\CDN\RocketCDN;

use WPMedia\PHPUnit\Integration\TestCase;
use WP_Error;

/**
 * @covers \WP_Rocket\Subscriber\CDN\RocketCDN\NoticesSubscriber::display_rocketcdn_cta
 * @group  RocketCDN
 * @group  AdminOnly
 */
class Test_DisplayRocketcdnCta extends TestCase {
	private function getActualHtml() {
		ob_start();
		do_action( 'rocket_before_cdn_sections' );

		return $this->format_the_html( ob_get_clean() );
	}

	public function testShouldDisplayNothingWhenNotLiveSite() {
		$callback = function() {
			return 'http://localhost';
		};

		$not_expected = $this->format_the_html( '<div class="wpr-rocketcdn-cta-small notice-alt notice-warning wpr-isHidden" id="wpr-rocketcdn-cta-small">
			<div class="wpr-flex">
				<section>
					<h3 class="notice-title">Speed up your website with RocketCDN, WP Rocket’s Content Delivery Network.</strong></h3>
				</section>
				<div>
					<button class="wpr-button" id="wpr-rocketcdn-open-cta">Learn More</button>
				</div>
			</div>
		</div>
		<div class="wpr-rocketcdn-cta " id="wpr-rocketcdn-cta">
			<section class="wpr-rocketcdn-cta-content--no-promo">
				<h3 class="wpr-title2">RocketCDN</h3>
				<p class="wpr-rocketcdn-cta-subtitle">Speed up your website thanks to:</p>
				<div class="wpr-flex">
					<ul class="wpr-rocketcdn-features">
						<li class="wpr-rocketcdn-feature wpr-rocketcdn-bandwidth">High performance Content Delivery Network (CDN) with <strong>unlimited bandwith</strong></li>
						<li class="wpr-rocketcdn-feature wpr-rocketcdn-configuration">Easy configuration: the <strong>best CDN settings</strong> are automatically applied</li>
						<li class="wpr-rocketcdn-feature wpr-rocketcdn-automatic">WP Rocket integration: the CDN option is <strong>automatically configured</strong> in our plugin</li>
					</ul>
					<div class="wpr-rocketcdn-pricing">
						<h4 class="wpr-rocketcdn-pricing-current"><span class="wpr-title1">$7.99</span> / month</h4>
						<button class="wpr-button wpr-rocketcdn-open" data-micromodal-trigger="wpr-rocketcdn-modal">Get Started</button>
					</div>
				</div>
			</section>
			<div class="wpr-rocketcdn-cta-footer">
				<a href="https://go.wp-rocket.me/rocket-cdn" target="_blank" rel="noopener noreferrer">Learn more about RocketCDN</a>
			</div>
			<button class="wpr-rocketcdn-cta-close--no-promo" id="wpr-rocketcdn-close-cta">
				<span class="screen-reader-text">Reduce this banner</span>
			</button>
		</div>' );

		add_filter( 'home_url', $callback );

		$this->assertNotContains( $not_expected, $this->getActualHtml() );

		remove_filter( 'home_url', $callback );
	}

	public function testShouldNotDisplayNoticeWhenActive() {
		set_transient( 'rocketcdn_status', [ 'subscription_status' => 'running' ], MINUTE_IN_SECONDS );

		$not_expected = $this->format_the_html( '<div class="wpr-rocketcdn-cta-small notice-alt notice-warning wpr-isHidden" id="wpr-rocketcdn-cta-small">
			<div class="wpr-flex">
				<section>
					<h3 class="notice-title">Speed up your website with RocketCDN, WP Rocket’s Content Delivery Network.</strong></h3>
				</section>
				<div>
					<button class="wpr-button" id="wpr-rocketcdn-open-cta">Learn More</button>
				</div>
			</div>
		</div>
		<div class="wpr-rocketcdn-cta " id="wpr-rocketcdn-cta">
			<section class="wpr-rocketcdn-cta-content--no-promo">
				<h3 class="wpr-title2">RocketCDN</h3>
				<p class="wpr-rocketcdn-cta-subtitle">Speed up your website thanks to:</p>
				<div class="wpr-flex">
					<ul class="wpr-rocketcdn-features">
						<li class="wpr-rocketcdn-feature wpr-rocketcdn-bandwidth">High performance Content Delivery Network (CDN) with <strong>unlimited bandwith</strong></li>
						<li class="wpr-rocketcdn-feature wpr-rocketcdn-configuration">Easy configuration: the <strong>best CDN settings</strong> are automatically applied</li>
						<li class="wpr-rocketcdn-feature wpr-rocketcdn-automatic">WP Rocket integration: the CDN option is <strong>automatically configured</strong> in our plugin</li>
					</ul>
					<div class="wpr-rocketcdn-pricing">
						<h4 class="wpr-rocketcdn-pricing-current"><span class="wpr-title1">$7.99</span> / month</h4>
						<button class="wpr-button wpr-rocketcdn-open" data-micromodal-trigger="wpr-rocketcdn-modal">Get Started</button>
					</div>
				</div>
			</section>
			<div class="wpr-rocketcdn-cta-footer">
				<a href="https://go.wp-rocket.me/rocket-cdn" target="_blank" rel="noopener noreferrer">Learn more about RocketCDN</a>
			</div>
			<button class="wpr-rocketcdn-cta-close--no-promo" id="wpr-rocketcdn-close-cta">
				<span class="screen-reader-text">Reduce this banner</span>
			</button>
		</div>' );

		$this->assertNotContains( $not_expected, $this->getActualHtml() );
	}

	public function testShouldDisplayBigCTANoPromoWhenDefault() {
		set_transient( 'rocketcdn_status', [ 'subscription_status' => 'cancelled' ], MINUTE_IN_SECONDS );
		set_transient(
			'rocketcdn_pricing',
			[
				'is_discount_active'       => false,
				'discounted_price_monthly' => 5.99,
				'discounted_price_yearly'  => 59.0,
				'discount_campaign_name'   => '',
				'end_date'                 => '2020-01-30',
				'monthly_price'            => 7.99,
				'annual_price'             => 79.0
			],
			MINUTE_IN_SECONDS
		);

		$expected = $this->format_the_html( '<div class="wpr-rocketcdn-cta-small notice-alt notice-warning wpr-isHidden" id="wpr-rocketcdn-cta-small">
			<div class="wpr-flex">
				<section>
					<h3 class="notice-title">Speed up your website with RocketCDN, WP Rocket’s Content Delivery Network.</strong></h3>
				</section>
				<div>
					<button class="wpr-button" id="wpr-rocketcdn-open-cta">Learn More</button>
				</div>
			</div>
		</div>
		<div class="wpr-rocketcdn-cta " id="wpr-rocketcdn-cta">
			<section class="wpr-rocketcdn-cta-content--no-promo">
				<h3 class="wpr-title2">RocketCDN</h3>
				<p class="wpr-rocketcdn-cta-subtitle">Speed up your website thanks to:</p>
				<div class="wpr-flex">
					<ul class="wpr-rocketcdn-features">
						<li class="wpr-rocketcdn-feature wpr-rocketcdn-bandwidth">High performance Content Delivery Network (CDN) with <strong>unlimited bandwith</strong></li>
						<li class="wpr-rocketcdn-feature wpr-rocketcdn-configuration">Easy configuration: the <strong>best CDN settings</strong> are automatically applied</li>
						<li class="wpr-rocketcdn-feature wpr-rocketcdn-automatic">WP Rocket integration: the CDN option is <strong>automatically configured</strong> in our plugin</li>
					</ul>
					<div class="wpr-rocketcdn-pricing">
						<h4 class="wpr-rocketcdn-pricing-current"><span class="wpr-title1">$7.99</span> / month</h4>
						<button class="wpr-button wpr-rocketcdn-open" data-micromodal-trigger="wpr-rocketcdn-modal">Get Started</button>
					</div>
				</div>
			</section>
			<div class="wpr-rocketcdn-cta-footer">
				<a href="https://go.wp-rocket.me/rocket-cdn" target="_blank" rel="noopener noreferrer">Learn more about RocketCDN</a>
			</div>
			<button class="wpr-rocketcdn-cta-close--no-promo" id="wpr-rocketcdn-close-cta">
				<span class="screen-reader-text">Reduce this banner</span>
			</button>
		</div>' );

		$this->assertContains( $expected, $this->getActualHtml() );
	}

	public function testShouldDisplaySmallCTAWhenBigHidden() {
		$user_id = self::factory()->user->create( [ 'role' => 'administrator' ] );

		wp_set_current_user( $user_id );

		set_transient( 'rocketcdn_status', [ 'subscription_status' => 'cancelled' ], MINUTE_IN_SECONDS );
		set_transient(
			'rocketcdn_pricing',
			[
				'is_discount_active'       => false,
				'discounted_price_monthly' => 5.99,
				'discounted_price_yearly'  => 59.0,
				'discount_campaign_name'   => '',
				'end_date'                 => '2020-01-30',
				'monthly_price'            => 7.99,
				'annual_price'             => 79.0
			],
			MINUTE_IN_SECONDS
		);

		add_user_meta( get_current_user_id(), 'rocket_rocketcdn_cta_hidden', true );

		$expected = $this->format_the_html( '<div class="wpr-rocketcdn-cta-small notice-alt notice-warning " id="wpr-rocketcdn-cta-small">
			<div class="wpr-flex">
				<section>
					<h3 class="notice-title">Speed up your website with RocketCDN, WP Rocket’s Content Delivery Network.</strong></h3>
				</section>
				<div>
					<button class="wpr-button" id="wpr-rocketcdn-open-cta">Learn More</button>
				</div>
			</div>
		</div>
		<div class="wpr-rocketcdn-cta wpr-isHidden" id="wpr-rocketcdn-cta">
			<section class="wpr-rocketcdn-cta-content--no-promo">
				<h3 class="wpr-title2">RocketCDN</h3>
				<p class="wpr-rocketcdn-cta-subtitle">Speed up your website thanks to:</p>
				<div class="wpr-flex">
					<ul class="wpr-rocketcdn-features">
						<li class="wpr-rocketcdn-feature wpr-rocketcdn-bandwidth">High performance Content Delivery Network (CDN) with <strong>unlimited bandwith</strong></li>
						<li class="wpr-rocketcdn-feature wpr-rocketcdn-configuration">Easy configuration: the <strong>best CDN settings</strong> are automatically applied</li>
						<li class="wpr-rocketcdn-feature wpr-rocketcdn-automatic">WP Rocket integration: the CDN option is <strong>automatically configured</strong> in our plugin</li>
					</ul>
					<div class="wpr-rocketcdn-pricing">
						<h4 class="wpr-rocketcdn-pricing-current"><span class="wpr-title1">$7.99</span> / month</h4>
						<button class="wpr-button wpr-rocketcdn-open" data-micromodal-trigger="wpr-rocketcdn-modal">Get Started</button>
					</div>
				</div>
			</section>
			<div class="wpr-rocketcdn-cta-footer">
				<a href="https://go.wp-rocket.me/rocket-cdn" target="_blank" rel="noopener noreferrer">Learn more about RocketCDN</a>
			</div>
			<button class="wpr-rocketcdn-cta-close--no-promo" id="wpr-rocketcdn-close-cta">
				<span class="screen-reader-text">Reduce this banner</span>
			</button>
		</div>' );

		$this->assertContains( $expected, $this->getActualHtml() );
	}

	public function testShouldDisplayBigCTAPromoWhenPromoActive() {
		set_transient( 'rocketcdn_status', [ 'subscription_status' => 'cancelled' ], MINUTE_IN_SECONDS );
		set_transient(
			'rocketcdn_pricing',
			[
				'is_discount_active'       => true,
				'discounted_price_monthly' => 5.99,
				'discounted_price_yearly'  => 59.0,
				'discount_campaign_name'   => 'Launch',
				'end_date'                 => '2020-01-30',
				'monthly_price'            => 7.99,
				'annual_price'             => 79.0
			],
			MINUTE_IN_SECONDS
		);

		$expected = $this->format_the_html( '<div class="wpr-rocketcdn-cta-small notice-alt notice-warning wpr-isHidden" id="wpr-rocketcdn-cta-small">
			<div class="wpr-flex">
				<section>
					<h3 class="notice-title">Speed up your website with RocketCDN, WP Rocket’s Content Delivery Network.</strong></h3>
				</section>
				<div>
					<button class="wpr-button" id="wpr-rocketcdn-open-cta">Learn More</button>
				</div>
			</div>
		</div>
		<div class="wpr-rocketcdn-cta " id="wpr-rocketcdn-cta">
			<div class="wpr-flex wpr-rocketcdn-promo">
				<h3 class="wpr-title1">Launch</h3>
				<p class="wpr-title2 wpr-rocketcdn-promo-date">Valid until 2020-01-30 only!</p>
			</div>
			<section class="wpr-rocketcdn-cta-content">
				<h3 class="wpr-title2">RocketCDN</h3>
				<p class="wpr-rocketcdn-cta-subtitle">Speed up your website thanks to:</p>
				<div class="wpr-flex">
					<ul class="wpr-rocketcdn-features">
						<li class="wpr-rocketcdn-feature wpr-rocketcdn-bandwidth">High performance Content Delivery Network (CDN) with <strong>unlimited bandwith</strong></li>
						<li class="wpr-rocketcdn-feature wpr-rocketcdn-configuration">Easy configuration: the <strong>best CDN settings</strong> are automatically applied</li>
						<li class="wpr-rocketcdn-feature wpr-rocketcdn-automatic">WP Rocket integration: the CDN option is <strong>automatically configured</strong> in our plugin</li>
					</ul>
					<div class="wpr-rocketcdn-pricing">
						<h4 class="wpr-title2 wpr-rocketcdn-pricing-regular"><del>$7.99</del></h4>
						<h4 class="wpr-rocketcdn-pricing-current"><span class="wpr-title1">$5.99*</span> / month</h4>
						<button class="wpr-button wpr-rocketcdn-open" data-micromodal-trigger="wpr-rocketcdn-modal">Get Started</button>
					</div>
				</div>
			</section>
			<div class="wpr-rocketcdn-cta-footer">
				<a href="https://go.wp-rocket.me/rocket-cdn" target="_blank" rel="noopener noreferrer">Learn more about RocketCDN</a>
			</div>
			<button class="wpr-rocketcdn-cta-close" id="wpr-rocketcdn-close-cta">
				<span class="screen-reader-text">Reduce this banner</span>
			</button>
			<p>* $5.99/month for 12 months then $7.99/month. You can cancel your subscription at any time.</p>
		</div> ' );

		$this->assertContains( $expected, $this->getActualHtml() );
	}

	public function testShouldDisplayErrorMessageWhenPricingAPINotAvailable() {
		set_transient( 'rocketcdn_status', [ 'subscription_status' => 'cancelled' ], MINUTE_IN_SECONDS );
		set_transient( 'rocketcdn_pricing', new WP_Error( 'rocketcdn_error', 'RocketCDN is not available at the moment. Please retry later' ), MINUTE_IN_SECONDS );

		$expected = $this->format_the_html( '<div class="wpr-rocketcdn-cta-small notice-alt notice-warning wpr-isHidden" id="wpr-rocketcdn-cta-small">
			<div class="wpr-flex">
				<section>
					<h3 class="notice-title">Speed up your website with RocketCDN, WP Rocket’s Content Delivery Network.</strong></h3>
				</section>
				<div>
					<button class="wpr-button" id="wpr-rocketcdn-open-cta">Learn More</button>
				</div>
			</div>
		</div>
		<div class="wpr-rocketcdn-cta " id="wpr-rocketcdn-cta">
			<section class="wpr-rocketcdn-cta-content--no-promo">
				<h3 class="wpr-title2">RocketCDN</h3>
				<p class="wpr-rocketcdn-cta-subtitle">Speed up your website thanks to:</p>
				<div class="wpr-flex">
					<ul class="wpr-rocketcdn-features">
						<li class="wpr-rocketcdn-feature wpr-rocketcdn-bandwidth">High performance Content Delivery Network (CDN) with <strong>unlimited bandwith</strong></li>
						<li class="wpr-rocketcdn-feature wpr-rocketcdn-configuration">Easy configuration: the <strong>best CDN settings</strong> are automatically applied</li>
						<li class="wpr-rocketcdn-feature wpr-rocketcdn-automatic">WP Rocket integration: the CDN option is <strong>automatically configured</strong> in our plugin</li>
					</ul>
					<div class="wpr-rocketcdn-pricing">
						<p>RocketCDN is not available at the moment. Please retry later</p>
					</div>
				</div>
			</section>
			<div class="wpr-rocketcdn-cta-footer">
				<a href="https://go.wp-rocket.me/rocket-cdn" target="_blank" rel="noopener noreferrer">Learn more about RocketCDN</a>
			</div>
			<button class="wpr-rocketcdn-cta-close--no-promo" id="wpr-rocketcdn-close-cta">
				<span class="screen-reader-text">Reduce this banner</span>
			</button>
		</div>' );

		$this->assertContains( $expected, $this->getActualHtml() );
	}
}
