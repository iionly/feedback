<?php
$values = array();
if (elgg_is_sticky_form('feedback/submit')) {
	$values = elgg_get_sticky_values('feedback/submit');
}

echo elgg_format_element('p', ['class' => 'elgg-text-help'], elgg_echo('feedback:message'));

echo elgg_view('input/hidden', array(
	'name' => 'id',
	'value' => elgg_extract('id', $values, feedback_get_user_id()),
));
echo elgg_view('input/hidden', array(
	'name' => 'page',
	'value' => elgg_extract('page', $values),
));
?>
<div>
	<label><?php echo elgg_echo('feedback:list:mood') ?></label>
	<?php
	echo elgg_view('input/radio', array(
		'options' => array(
			elgg_echo('feedback:mood:angry') => 'angry',
			elgg_echo('feedback:mood:neutral') => 'neutral',
			elgg_echo('feedback:mood:happy') => 'happy',
		),
		'name' => 'mood',
		'value' => elgg_extract('mood', $values, 'neutral'),
		'align' => 'horizontal',
	));
	?>
</div>

<div>
	<label><?php echo elgg_echo('feedback:list:about') ?></label>
	<?php
	echo elgg_view('input/radio', array(
		'options' => array(
			elgg_echo('feedback:about:bug_report') => 'bug_report',
			elgg_echo('feedback:about:suggestions') => 'suggestions',
			elgg_echo('feedback:about:content') => 'content',
			elgg_echo('feedback:about:compliment') => 'compliment',
			elgg_echo('feedback:about:other') => 'other',
		),
		'name' => 'about',
		'value' => elgg_extract('about', $values, 'suggestions'),
		'align' => 'horizontal',
	));
	?>
</div>
<div>
	<label><?php echo elgg_echo('feedback:default:txt') ?></label>
	<?php
	echo elgg_view('input/plaintext', array(
		'id' => 'feedback_txt',
		'name' => 'txt',
		'class' => 'feedbackTextbox',
		'placeholder' => elgg_echo('feedback:default:txt'),
		'rows' => 4,
		'value' => elgg_extract('txt', $values),
		'required' => true,
	));
	?>
</div>
<div class="elgg-foot">
	<?php
	echo elgg_view('input/submit', array(
		'value' => elgg_echo('send'),
		'id' => 'feedback_send_btn',
	));
	echo elgg_format_element('button', array(
		'class' => 'elgg-button elgg-button-cancel feedback-toggler mlm',
		'type' => 'reset',
		'id' => 'feedback_cancel_btn',
	), elgg_echo('cancel'));
	?>
</div>
<script>
// allow this form to be initialized when loaded in a lightbox
	require(['forms/feedback/submit']);
</script>