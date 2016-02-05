<?php

/**
 * Elgg Feedback plugin
 * Feedback interface for Elgg sites
 *
 * for Elgg 1.8 onwards by iionly
 * iionly@gmx.de
 *
 * List the latest feedback entries
 */
$entity = elgg_extract('entity', $vars);

echo elgg_view('lists/feedback', array(
	'limit' => $entity->num_display ? : 4,
));

$more_link = elgg_view('output/url', array(
	'href' => 'feedback/all',
	'text' => elgg_echo('link:view:all'),
		));

echo elgg_format_element('div', [
	'class' => 'elgg-widget-more',
		], $more_link);
