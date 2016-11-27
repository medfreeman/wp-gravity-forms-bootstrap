<?php
/**
 * Hooks wordpress trait.
 *
 * @package wordpress-dev
 * @author johnpbloch <https://github.com/johnpbloch>
 * @since 1.0.0
 */

namespace MedFreeman\WP\Dev;

trait Hooks {

	/**
	 * Internal property to track closures attached to WordPress hooks
	 *
	 * @var array
	 */
	protected $__filter_map = [];

	/**
	 * Add a WordPress filter
	 *
	 * @param string   $hook     Wordpress hook name.
	 * @param callable $method   PHP method for the hook to call.
	 * @param int      $priority Hook priority.
	 * @param int      $arg_count Hook arguments count.
	 */
	protected function add_filter( $hook, $method, $priority = 10, $arg_count = 1 ) {
		add_filter(
			$hook,
			$this->map_filter( $this->get_wp_filter_id( $hook, $method, $priority ), $method, $arg_count ),
			$priority,
			$arg_count
		);
	}

	/**
	 * Add a WordPress action
	 *
	 * This is just an alias of add_filter()
	 *
	 * @param string   $hook     Wordpress hook name.
	 * @param callable $method   PHP method for the hook to call.
	 * @param int      $priority Hook priority.
	 * @param int      $arg_count Hook arguments count.
	 */
	protected function add_action( $hook, $method, $priority = 10, $arg_count = 1 ) {
		$this->add_filter( $hook, $method, $priority, $arg_count );
	}

	/**
	 * Add a WordPress shortcode
	 *
	 * @param string   $hook     Wordpress shortcode name.
	 * @param callable $method   PHP method for the shortcode to call.
	 */
	protected function add_shortcode( $hook, $method ) {
		$priority = 1;
		$arg_count = 2;
		add_shortcode(
			$hook,
			$this->map_filter( $this->get_wp_filter_id( $hook, $method, $priority ), $method, $arg_count ),
			$priority,
			$arg_count
		);
	}

	/**
	 * Remove a WordPress filter
	 *
	 * @param string   $hook     Wordpress hook name.
	 * @param callable $method   PHP method for the hook to call.
	 * @param int      $priority Hook priority.
	 * @param int      $arg_count Hook arguments count.
	 */
	protected function remove_filter( $hook, $method, $priority = 10, $arg_count = 1 ) {
		remove_filter(
			$hook,
			$this->map_filter( $this->get_wp_filter_id( $hook, $method, $priority ), $method, $arg_count ),
			$priority,
			$arg_count
		);
	}

	/**
	 * Remove a WordPress action
	 *
	 * This is just an alias of remove_filter()
	 *
	 * @param string   $hook     Wordpress hook name.
	 * @param callable $method   PHP method for the hook to call.
	 * @param int      $priority Hook priority.
	 * @param int      $arg_count Hook arguments count.
	 */
	protected function remove_action( $hook, $method, $priority = 10, $arg_count = 1 ) {
		$this->remove_filter( $hook, $method, $priority, $arg_count );
	}

	/**
	 * Remove a WordPress shortcode
	 *
	 * @param string $hook Wordpress hook name.
	 */
	protected function remove_shortcode( $hook ) {
		remove_shortcode( $hook );
	}

	/**
	 * Get a unique ID for a hook based on the internal method, hook, and priority
	 *
	 * @param string $hook     Wordpress hook name.
	 * @param string $method   PHP method for the hook to call.
	 * @param int    $priority Hook priority.
	 *
	 * @return bool|string
	 */
	protected function get_wp_filter_id( $hook, $method, $priority ) {
		return _wp_filter_build_unique_id( $hook, [ $this, $method ], $priority );
	}

	/**
	 * Map a filter to a closure that inherits the class' internal scope
	 *
	 * This allows hooks to use protected and private methods
	 *
	 * @param string $id        Hook unique ID.
	 * @param string $method    PHP method for the hook to call.
	 * @param int    $arg_count Hook arguments count.
	 *
	 * @return \Closure The callable actually attached to a WP hook
	 */
	protected function map_filter( $id, $method, $arg_count ) {
		if ( empty( $this->__filter_map[ $id ] ) ) {
			$this->__filter_map[ $id ] = function () use ( $method, $arg_count ) {
				return call_user_func_array( [ $this, $method ], array_slice( func_get_args(), 0, $arg_count ) );
			};
		}

		return $this->__filter_map[ $id ];
	}

}
