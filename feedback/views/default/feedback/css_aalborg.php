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
 * for Elgg 1.9 by iionly
 * iionly@gmx.de
 */
?>

#feedbackWrapper {
	position: fixed;
	top: 189px;
	left: 35px;
	width: 350px;
	z-index:1;
}

#feedBackToggler {
	float: left;
}

#feedBackContent {
	width: 340px;
	display: none;
	overflow: hidden;
	float: left;
	border: solid #fff 2px;
	color: black;
	background-color: white;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	-webkit-box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.5);
	-moz-box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.5);
	box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.5);
}

#feedBackContent h1 {
	padding-top:10px;
	padding-left:10px;
	padding-bottom:10px;
	color: white;
	background-color: #60B8F7;
	font-family: Georgia,Times,"Times New Roman",serif;
	text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.4);
	text-decoration: none;
}

#feedbackError {
	font-style: bold;
	color: black;
	background-color: #ff0000;
}

#feedbackSuccess {
	font-style: bold;
	color: black;
	background-color: #00ff00;
}

.feedbackButton {
	position: fixed;
	top: 320px;
	left: 0px;
	z-index:1;
	font-size:24px;
	display:inline-block;
	-webkit-border-top-left-radius: 0px;
	-webkit-border-top-right-radius: 0px;
	-moz-border-radius-topleft: 0px;
	-moz-border-radius-topright: 0px;
	border-top-left-radius: 0px;
	border-top-right-radius: 0px;
	-webkit-transform: rotate(-90deg);
	-moz-transform: rotate(-90deg);
	-ms-transform: rotate(-90deg);
	-o-transform: rotate(-90deg);
	transform: rotate(-90deg);
	-webkit-transform-origin: 0% 0%;
	-moz-transform-origin: 0% 0%;
	-ms-transform-origin: 0% 0%;
	-o-transform-origin: 0% 0%;
	transform-origin: 0% 0%;
	filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
}

.feedbackText {
	width:320px;
}

.feedbackTextbox {
	width:320px;
	height:75px;
}
