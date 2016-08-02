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

$entity = elgg_extract('entity', $vars);

$controls = elgg_view_menu('entity', array(
	'entity' => $entity,
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$meta = array(
	elgg_echo('feedback:list:mood') => elgg_echo("feedback:mood:$entity->mood"),
	elgg_echo('feedback:list:from') => $entity->id,
);

if ($entity->page) {
	$meta[elgg_echo('feedback:list:page')] = elgg_view('output/url', array(
		'href' => $entity->page,
	));
} else {
	$meta[elgg_echo('feedback:list:page')] = elgg_echo('feedback:list:page:unknown');
}

$subtitle = array();
foreach ($meta as $label => $value) {
	$subtitle[] = "<b>$label</b>: $value";
}

$subtitle[] = elgg_view_friendly_time($entity->time_created);

$content = elgg_view('output/longtext', array(
	'value' => $entity->txt,
));

echo elgg_view('object/elements/summary', array(
	'entity' => $entity,
	'title' => elgg_echo("feedback:about:$entity->about"),
	'metadata' => $controls,
	'subtitle' => implode('<br>', $subtitle),
	'content' => $content,
));
