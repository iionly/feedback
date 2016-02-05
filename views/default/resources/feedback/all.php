<?php

elgg_gatekeeper();

if (!elgg_is_admin_logged_in()) {
	$user = elgg_get_logged_in_user_entity();
	$usernames = array();
	for ($i = 1; $i <= 5; $i++) {
		$usernames[] = elgg_get_plugin_setting("user_{$i}", 'feedback');
	}

	if (!in_array($user->username, $usernames)) {
		forward('', '403');
	}
}

elgg_push_breadcrumb(elgg_echo('feedback:title'), 'feedback');

$title = elgg_echo('feedback:admin:title');
$content = elgg_view('lists/feedback');

if (elgg_is_xhr()) {
	echo $content;
} else {
	$layout = elgg_view_layout('content', array(
		'title' => $title,
		'content' => $content,
		'filter' => false,
	));
	echo elgg_view_page($title, $layout);
}