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
	if (elgg_get_plugin_setting("publicAvailable_feedback", "feedback") == "yes" || elgg_is_logged_in()) {
		elgg_extend_view('page/elements/body', 'feedback/footer');
	}

	// extend the site CSS
	if (elgg_is_active_plugin('aalborg_theme')) {
		elgg_extend_view('css/elgg', 'feedback/css_aalborg');
	} else {
		elgg_extend_view('css/elgg', 'feedback/css');
	}
	elgg_extend_view('css/admin', 'feedback/admin_css');

	// create feedback page in admin section
	elgg_register_admin_menu_item('administer', 'feedback', 'administer_utilities');

	elgg_register_widget_type('feedback', elgg_echo('feedback:admin:title'), elgg_echo('feedback:widget:description'), array('admin'));

	// Register feedback pages as public pages for walled-garden
	elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'feedback_public');

	// Register actions
	elgg_register_action('feedback/delete', elgg_get_plugins_path() . 'feedback/actions/delete.php', 'admin');
	elgg_register_action('feedback/submit_feedback', elgg_get_plugins_path() . 'feedback/actions/submit_feedback.php', 'public');

	elgg_register_page_handler('feedback', 'feedback_page_handler');
}

function feedback_public($hook, $handler, $return, $params) {
	$pages = array(
		'action/feedback/submit_feedback',
		'feedback/submit',
	);
	return array_merge($pages, $return);
}

/**
 * Feedback page handler
 * /feedback/all
 * /feedback/submit
 *
 * @param array $segments URL segments
 * @return bool
 */
function feedback_page_handler($segments) {

	$page = array_shift($segments);

	switch ($page) {
		case 'all' :
			echo elgg_view_resource('feedback/all');
			return true;

		case 'submit' :
			echo elgg_view_resource('feedback/submit');
			return true;
	}

	return false;
}
