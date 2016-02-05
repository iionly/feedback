<?php

/**
 * Elgg Feedback plugin
 * Feedback interface for Elgg sites
 *
 * @package Feedback
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Prashant Juvekar
 * @copyright Prashant Juvekar
 * @link http://www.linkedin.com/in/prashantjuvekar
 *
 * for Elgg 1.8 onwards by iionly
 * iionly@gmx.de
 */
elgg_register_event_handler('init', 'system', 'feedback_init');

/**
 * Initialize Plugin
 */
function feedback_init() {

	// extend the view
	elgg_extend_view('page/elements/body', 'feedback/footer');

	// extend the site CSS
	elgg_extend_view('elgg.css', 'feedback/feedback.css');
	elgg_extend_view('css/admin', 'feedback/admin_css');

	// create feedback page in admin section
	elgg_register_admin_menu_item('administer', 'feedback', 'administer_utilities');

	elgg_register_widget_type('feedback', elgg_echo('feedback:admin:title'), elgg_echo('feedback:widget:description'), array('admin'));

	// Register feedback pages as public pages for walled-garden
	elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'feedback_public');

	// Register actions
	elgg_register_action('feedback/delete', elgg_get_plugins_path() . 'feedback/actions/delete.php', 'admin');
	elgg_register_action('feedback/submit_feedback', elgg_get_plugins_path() . 'feedback/actions/submit_feedback.php', 'public');
}

function feedback_public($hook, $handler, $return, $params) {
	$pages = array('action/feedback/submit_feedback');
	return array_merge($pages, $return);
}

/**
 * Identify a user
 * @return string
 */
function feedback_get_user_id() {
	if (elgg_is_logged_in()) {
		$user = elgg_get_logged_in_user_entity();
		$user_id = $user->name . " (" . $user->email . ")";
	} else {

		// Try to get IP address
		if (getenv('HTTP_CLIENT_IP')) {
			$user_id = getenv('HTTP_CLIENT_IP');
		} elseif (getenv('HTTP_X_FORWARDED_FOR')) {
			$user_id = getenv('HTTP_X_FORWARDED_FOR');
			// Check for multiple IP addresses in result from
			// HTTP_X_FORWARDED_FOR and return only the last one
			if (($pos = strrpos($user_id, ",")) !== false) {
				$user_id = substr($user_id, $pos + 1);
			}
		} elseif (getenv('HTTP_X_FORWARDED')) {
			$user_id = getenv('HTTP_X_FORWARDED');
		} elseif (getenv('HTTP_FORWARDED_FOR')) {
			$user_id = getenv('HTTP_FORWARDED_FOR');
		} elseif (getenv('HTTP_FORWARDED')) {
			$user_id = getenv('HTTP_FORWARDED');
		} else {
			$user_id = $_SERVER['REMOTE_ADDR'];
		}

		// Check for multiple IP addresses in
		if (($pos = strrpos($user_id, ",")) !== false) {
			$user_id = substr($user_id, $pos + 1);
		}
	}

	return $user_id ? : elgg_echo('feedback:default:id');
}
