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
	return;
}

elgg_require_js('feedback/feedback');

$toggle = elgg_view('output/url', array(
	'href' => '#feedBackContent',
	'rel' => 'popup',
	'class' => 'elgg-button elgg-button-action feedbackButton feedback-toggler-fixed',
	'text' => elgg_echo('feedback:title'),
		));

$toggler = elgg_format_element('div', array(
	'id' => 'feedBackToggler',
		), $toggle);

$title = elgg_echo('feedback:title');
$form = elgg_view_form('feedback/submit', array(
	'id' => 'feedBackForm',
	'action' => 'action/feedback/submit_feedback',
		));
$module = elgg_view_module('info', $title, $form);

$content = elgg_format_element('div', array(
	'id' => 'feedBackContent',
	'class' => 'elgg-module-popup elgg-module-feedback hidden',
		), $module);

echo elgg_format_element('div', array(
	'id' => 'feedbackWrapper',
	'class' => 'feedback-component',
		), $toggler . $content);
