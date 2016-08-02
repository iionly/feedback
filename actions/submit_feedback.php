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

if (elgg_get_plugin_setting("publicAvailable_feedback", "feedback") != "yes" && !elgg_is_logged_in()) {
	forward('', '403');
}

if (elgg_get_logged_in_user_guid()) {
	$owner_guid = elgg_get_logged_in_user_guid();
} else {
	$owner_guid = elgg_get_config('site_guid');
}

$access = elgg_set_ignore_access(true);

// Initialise a new ElggObject
$feedback = new ElggObject();
// Tell the system it's a feedback
$feedback->subtype = "feedback";
$feedback->owner_guid = $owner_guid;
$feedback->container_guid = $owner_guid;
// Set the feedback's content
$feedback->page = $feedback_page = get_input('page');
$feedback->mood = $feedback_mood = get_input('mood');
$feedback->about = $feedback_about = get_input('about');
$feedback->id = $feedback_sender = get_input('id');
$feedback->txt = $feedback_txt = get_input('txt');

if ($logged_in_user = elgg_get_logged_in_user_entity()) {
	$feedback_sender = $logged_in_user->name . " (" . $logged_in_user->email . ")";

	$link_params = array(
		'href' => $logged_in_user->getUrl(),
		'text' => $logged_in_user->name,
	);
	$feedback->id = elgg_view('output/url', $link_params) . " (" . $logged_in_user->email . ")";
} else {
	$feedback_name = get_input('name', elgg_echo('feedback:default:id:none'));
	$feedback->id = $feedback_sender = $feedback_name  . " (" . get_input('id') . ")";
}

// save the feedback now
if ($feedback->save()) {
	system_message(elgg_echo("feedback:submit:success"));

	// now email if required
	$user_guids = array();
	for ($idx = 1; $idx <= 5; $idx++) {
		$name = elgg_get_plugin_setting('user_' . $idx, 'feedback');
		if (!empty($name)) {
			if ($user = get_user_by_username($name)) {
				$user_guids[] = $user->guid;
			}
		}
	}
	if (count($user_guids) > 0) {
		foreach ($user_guids as $user_guid) {
			if ($user = get_user($user_guid)) {
				$feedback_page = $feedback_page ? : elgg_echo('feedback:list:page:unknown', array(), $user_language);
				$admins = elgg_get_admins(array('order_by' => 'time_created asc'));
				$user_language = ($user->language) ? $user->language : (($site_language = elgg_get_config('language')) ? $site_language : 'en');
				$feedback_page = $feedback_page ? : elgg_echo('feedback:list:page:unknown', array(), $user_language);
				$subject = elgg_echo("feedback:email:subject", array(), $user_language);
				$message = elgg_echo("feedback:email:body", array(
					$user->name,
					elgg_echo("feedback:about:$feedback_about", array(), $user_language),
					elgg_echo("feedback:mood:$feedback_mood", array(), $user_language),
					$feedback_sender,
					$feedback_page,
					$feedback_txt), $user_language);
				notify_user($user_guid, $admins[0]->guid, $subject, $message);
			}
		}
	}
} else {
	register_error(elgg_echo("feedback:submit:error"));
}

elgg_set_ignore_access($access);
