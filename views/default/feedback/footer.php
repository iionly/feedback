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

elgg_require_js('feedback/feedback');

$user_ip = '';
if (!elgg_is_logged_in()) {
	// Try to get IP address
	if (getenv('HTTP_CLIENT_IP')) {
		$user_ip = getenv('HTTP_CLIENT_IP');
	} elseif (getenv('HTTP_X_FORWARDED_FOR')) {
		$user_ip = getenv('HTTP_X_FORWARDED_FOR');
		// Check for multiple IP addresses in result from
		// HTTP_X_FORWARDED_FOR and return only the last one
		if (($pos = strrpos($user_ip, ",")) !== false) {
			$user_ip = substr($user_ip, $pos+1);
		}
	} elseif (getenv('HTTP_X_FORWARDED')) {
		$user_ip = getenv('HTTP_X_FORWARDED');
	} elseif (getenv('HTTP_FORWARDED_FOR')) {
		$user_ip = getenv('HTTP_FORWARDED_FOR');
	} elseif (getenv('HTTP_FORWARDED')) {
		$user_ip = getenv('HTTP_FORWARDED');
	} else {
		$user_ip = $_SERVER['REMOTE_ADDR'];
	}

	// Check for multiple IP addresses in 
	if (($pos = strrpos($user_ip, ",")) !== false) {
		$user_ip = substr($user_ip, $pos+1);
	}
}

$user_id = elgg_echo('feedback:default:id');
if (elgg_is_logged_in()) {
	$user = elgg_get_logged_in_user_entity();
	$user_id = $user->name . " (" . $user->email .")";
}

$progress_img = '<img src="' . elgg_get_simplecache_url('ajax_loader.gif') . '" alt="' . elgg_echo('feedback:submit_msg') . '">';
$open_img = '<div class="elgg-button elgg-button-action feedbackButton">' . elgg_echo('feedback:title') . '</div>';
$close_img = '<div class="elgg-button elgg-button-action feedbackButton">' . elgg_echo('feedback:title') . '</div>';

echo "<div id='feedbackWrapper' data-userip='" . $user_ip . "' data-progressimg='" . $progress_img . "' data-openimg='" . $open_img . "' data-closeimg='" . $close_img . "'>";

	echo '<div id="feedBackToggler" href="#">';
		echo '<a id="feedBackTogglerLink">' . $open_img . '</a>';
	echo '</div>';

	echo '<div id="feedBackContent">';
		echo '<div style="padding:10px;">';
			echo '<h1 style="padding-bottom:5px;">' . elgg_echo('feedback:title') . '</h1>';
			echo '<div style="padding-bottom:5px;">' . elgg_echo('feedback:message') . '</div>';

			echo '<div id="feedBackFormInputs">';

				echo '<form id="feedBackForm" action="" method="post">';
					echo '<div>';
						echo '<div><label>' . elgg_echo('feedback:list:mood') . ':</label></div>';
						echo '<div>';
							echo '<div><input type="radio" name="mood" value="angry">' . elgg_echo('feedback:mood:angry') . '</div>';
							echo '<div><input type="radio" name="mood" value="neutral" checked>' . elgg_echo('feedback:mood:neutral') . '</div>';
							echo '<div><input type="radio" name="mood" value="happy">' . elgg_echo('feedback:mood:happy') . '</div>';
						echo '</div>';
					echo '</div>';
					echo '<div style="clear:both;"></div>';
					echo '<div>';
						echo '<div><label>' . elgg_echo('feedback:list:about') . ':</label></div>';
						echo '<div>';
							echo '<div><input type="radio" name="about" value="bug_report">' . elgg_echo('feedback:about:bug_report') . '</div>';
							echo '<div><input type="radio" name="about" value="suggestions" checked>' . elgg_echo('feedback:about:suggestions') . '</div>';
							echo '<div><input type="radio" name="about" value="content">' . elgg_echo('feedback:about:content') . '</div>';
							echo '<div><input type="radio" name="about" value="compliment">' . elgg_echo('feedback:about:compliment') . '</div>';
							echo '<div><input type="radio" name="about" value="other">' . elgg_echo('feedback:about:other') . '</div>';
						echo '</div>';
					echo '</div>';
					echo '<div style="clear:both;"></div>';
					echo '<div style="padding-top:5px;">';
						echo '<input type="text" name="feedback_id" value="' . $user_id . '" id="feedback_id" size="20" class="feedbackText" />';
					echo '</div>';
					echo '<div style="padding-top:5px;">';
						echo '<textarea name="feedback_txt" cols="25" rows="10" id="feedback_txt" class="feedbackTextbox">' . elgg_echo('feedback:default:txt') . '</textarea>';
					echo '</div>';
					echo '<div style="padding-top:10px;">';
						echo '<input id="feedback_send_btn" name="send" value="' . elgg_echo('send') . '" type="button" class="elgg-button elgg-button-submit"/>'.' ';
						echo '<input id="feedback_cancel_btn" name="cancel" value="' . elgg_echo('cancel') . '" type="button" class="elgg-button elgg-button-cancel"/>';
					echo '</div>';
				echo '</form>';

			echo '</div>';
			echo '<div id="feedBackFormStatus"></div>';
			echo '<div id="feedbackClose" style="padding-top:10px;">';
			echo '<input id="feedback_close_btn" name="close" value="' . elgg_echo('close') . '" type="button" class="elgg-button elgg-button-cancel"/>';
			echo '</div>';
		echo '</div>';
	echo '</div>';

	echo '<div style="clear:both;"></div>';

echo '</div>';
