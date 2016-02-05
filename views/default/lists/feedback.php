<?php

echo elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'feedback',
	'limit' => elgg_extract('limit', $vars, elgg_get_config('default_limit')),
	'pagination' => !elgg_in_context('widgets'),
	'no_results' => elgg_echo('feedback:list:nofeedback'),
));
