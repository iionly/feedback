<?php

elgg_ajax_gatekeeper();

if (elgg_get_plugin_setting("publicAvailable_feedback", "feedback") !== "yes" && !elgg_is_logged_in()) {
	return false;
}

elgg_push_breadcrumb(elgg_echo('feedback:submit'), 'feedback');

$title = elgg_echo('feedback:title');
$content = elgg_view_form('feedback/submit', array(
	'action' => 'action/feedback/submit_feedback',
));

echo $content;