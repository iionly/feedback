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

	// create feedback page in admin section
	elgg_register_admin_menu_item('administer', 'feedback', 'administer_utilities');

	elgg_register_widget_type('feedback', elgg_echo('feedback:admin:title'), elgg_echo('feedback:widget:description'), array('admin'));

	// Register feedback pages as public pages for walled-garden
	elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'feedback_public');

	// Register actions
	elgg_register_action('feedback/delete', elgg_get_plugins_path() . 'feedback/actions/delete.php', 'admin');
	elgg_register_action('feedback/submit_feedback', elgg_get_plugins_path() . 'feedback/actions/submit_feedback.php', 'public');

	elgg_register_plugin_hook_handler('register', 'menu:entity', 'feedback_entity_menu_setup');
}

function feedback_public($hook, $handler, $return, $params) {
	$pages = array('action/feedback/submit_feedback');
	return array_merge($pages, $return);
}

/**
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
