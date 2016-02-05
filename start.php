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

	elgg_register_page_handler('feedback', 'feedback_page_handler');
	elgg_register_plugin_hook_handler('permissions_check', 'object', 'feedback_permissions_override');
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'feedback_entity_menu_setup');

	elgg_register_plugin_hook_handler('register', 'menu:footer', 'feedback_footer_menu_setup');
	elgg_register_plugin_hook_handler('register', 'menu:extras', 'feedback_extras_menu_setup');
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

/*
 * Feeback object entity menu
 *
 * @param string         $hook   "register"
 * @param string         $type   "menu:entity"
 * @param ElggMenuItem[] $return Menu
 * @param array          $params Hook params
 * @return ElggMenuItem[]
 */
function feedback_entity_menu_setup($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params);
	if (!$entity instanceof ElggObject || $entity->getSubtype() != 'feedback') {
		return;
	}

	if ($entity->canEdit()) {
		$return[] = ElggMenuItem::factory(array(
					'name' => 'delete',
					'href' => "action/feedback/delete?guid=$entity->guid",
					'text' => elgg_view_icon('delete'),
					'confirm' => elgg_echo('deleteconfirm'),
		));
	}

	return $return;
}

/*
 * Allow users that have permissions to review feedback to also edit/delete it
 *
 * @param string $hook   "permissions_check"
 * @param string $type   "object"
 * @param bool   $return Permission
 * @param array  $params Hook params
 * @return bool
 */
function feedback_permissions_override($hook, $type, $return, $params) {

	$entity = elgg_extract('entity', $params);

	if (!$entity instanceof ElggObject || $entity->getSubtype() !== 'feedback') {
		return;
	}

	if (!elgg_is_logged_in()) {
		return;
	}

	$user = elgg_get_logged_in_user_entity();
	$usernames = array();
	for($i=1;$i<=5;$i++) {
		$usernames[] = elgg_get_plugin_setting("user_{$i}", 'feedback');
	}

	if (in_array($user->username, $usernames)) {
		return true;
	}
}

/*
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

/*
 * Feeback footer menu
 *
 * @param string         $hook   "register"
 * @param string         $type   "menu:footer"
 * @param ElggMenuItem[] $return Menu
 * @param array          $params Hook params
 * @return ElggMenuItem[]
 */
function feedback_footer_menu_setup($hook, $type, $return, $params) {

	$position = elgg_get_plugin_setting('form_position', 'feedback');
	if ($position == 'footer_menu') {
		elgg_load_js('lightbox');
		elgg_load_css('lightbox');
		$return[] = ElggMenuItem::factory(array(
					'name' => 'feedback',
					'href' => 'feedback/submit',
					'link_class' => 'elgg-lightbox',
					'text' => elgg_echo('feedback:submit'),
		));
		return $return;
	}
}

/*
 * Feeback extras menu
 *
 * @param string         $hook   "register"
 * @param string         $type   "menu:entity"
 * @param ElggMenuItem[] $return Menu
 * @param array          $params Hook params
 * @return ElggMenuItem[]
 */
function feedback_extras_menu_setup($hook, $type, $return, $params) {

	$position = elgg_get_plugin_setting('form_position', 'feedback');
	if ($position == 'extras_menu') {
		elgg_load_js('lightbox');
		elgg_load_css('lightbox');
		$return[] = ElggMenuItem::factory(array(
					'name' => 'feedback',
					'href' => 'feedback/submit',
					'text' => elgg_view_icon('bullhorn'),
					'link_class' => 'elgg-lightbox',
					'title' => elgg_echo('feedback:submit'),
		));
		return $return;
	}
}
