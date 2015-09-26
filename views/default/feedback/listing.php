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

$controls = elgg_view("output/url",array(
	'href' => elgg_get_site_url() . "action/feedback/delete?guid=" . $vars['entity']->guid,
	'text' => elgg_view_icon('delete'),
	'is_action' => true,
	'is_trusted' => true,
	'confirm' => elgg_echo('deleteconfirm'),
));

$mood = elgg_echo ( "feedback:mood:" . $vars['entity']->mood );
$about = elgg_echo ( "feedback:about:" . $vars['entity']->about );

$page = "Unknown";
if ( !empty($vars['entity']->page) ) {
	$page = $vars['entity']->page;
	$page = "<a href='" . $page . "'>" . $page . "</a>";
}

$info = "<div><b>" . elgg_echo('feedback:list:mood') . ": </b>" . $mood . "</div>";
$info .= "<div><b>" . elgg_echo('feedback:list:about') . ": </b>" . $about . "</div>";
$info .= "<div><b>" . elgg_echo('feedback:list:page') . ": </b>" . $page . "</div>";
$info .= "<div><b>" . elgg_echo('feedback:list:from') . ": </b>" . $vars['entity']->id . "</div>";
$info .= "<div>" . $vars['entity']->txt . "</div>";

echo elgg_view('page/components/image_block', array('image' => $controls, 'body' => $info, 'class' => 'submitted-feedback'));
