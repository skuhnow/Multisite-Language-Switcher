<?php
/**
 * Tests for MslsBlogCollection
 *
 * @author Dennis Ploetner <re@lloc.de>
 * @package Msls
 */

use lloc\Msls\MslsBlogCollection;
use lloc\Msls\MslsOptions;

/**
 * WP_Test_MslsBlogCollection
 */
class WP_Test_MslsBlogCollection extends Msls_UnitTestCase {

	public function get_test() {

	}

	/**
	 * Verify the instance-method
	 */
	function test_instance_method() {
		$options = $this->getMockBuilder( MslsOptions::class )->getMock();
		$obj     = MslsBlogCollection::instance();

		$this->assertInstanceOf( MslsBlogCollection::class, $obj );

		$this->assertEquals( 'Test', $obj->get_configured_blog_description( 0, 'Test' ) );
		$this->assertEquals( false, $obj->get_configured_blog_description( 0, false ) );

		$this->assertInternalType( 'array', $obj->get_blogs_of_reference_user( $options ) );

		$this->assertInternalType( 'integer', $obj->get_current_blog_id() );

		$this->assertInternalType( 'boolean', $obj->has_current_blog() );

		$this->assertInternalType( 'array', $obj->get_objects() );

		$this->assertInternalType( 'boolean', $obj->is_plugin_active( 0 ) );

		$this->assertInternalType( 'array', $obj->get_plugin_active_blogs() );

		$this->assertInternalType( 'array', $obj->get() );

		$this->assertInternalType( 'array', $obj->get_filtered() );

		$this->assertInternalType( 'array', $obj->get_users() );
	}

	public function filter_available_languages( array $available_languages = array() ) {
		$available_languages[] = 'de_DE';

		return $available_languages;
	}

	/**
	 * Test get_blog_language
	 */
	public function test_get_blog_language() {
		$blog_id = $this->factory->blog->create();
		add_filter( 'get_available_languages', array( $this, 'filter_available_languages' ) );
		add_blog_option( $blog_id, 'WPLANG', 'de_DE' );
		$this->assertEquals( 'de_DE', MslsBlogCollection::get_blog_language( $blog_id ) );
	}

	/**
	 * Test get_blog_language when WPLANG option is missing
	 */
	public function test_get_blog_language_when_wplang_option_is_missing() {
		$blog_id = $this->factory->blog->create();
		delete_blog_option( $blog_id, 'WPLANG' );
		$this->assertEquals( 'en_US', MslsBlogCollection::get_blog_language( $blog_id ) );
	}
}
