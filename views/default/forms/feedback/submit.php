<?php
$values = array();
if (elgg_is_sticky_form('feedback/submit')) {
	$values = elgg_get_sticky_values('feedback/submit');
}

echo elgg_format_element('p', ['class' => 'elgg-text-help mbs'], elgg_echo('feedback:message'));

echo elgg_view('input/hidden', array(
	'name' => 'id',
	'value' => elgg_extract('id', $values, feedback_get_user_id()),
));
echo elgg_view('input/hidden', array(
	'name' => 'page',
	'value' => elgg_extract('page', $values),
));
?>

<div class="feedbackInput mbs">
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
		'align' => 'vertical',
	));
	?>
</div>

<div class="feedbackInput mbs">
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
		'align' => 'vertical',
	));
	?>
</div>

<?php if (!elgg_is_logged_in()) { ?>
	<div class="feedbackInput mbs">
		<label><?php echo elgg_echo('feedback:default:id') ?></label>
		<?php
		echo elgg_view('input/text', array(
			'id' => 'feedback_name',
			'name' => 'name',
			'placeholder' => elgg_echo('feedback:default:id'),
			'value' => elgg_extract('name', $values),
		));
		?>
	</div>
<?php } ?>

<div class="feedbackInput mbs">
	<label><?php echo elgg_echo('feedback:default:txt') ?></label>
	<?php
	echo elgg_view('input/plaintext', array(
		'id' => 'feedback_txt',
		'name' => 'txt',
		'placeholder' => elgg_echo('feedback:default:txt'),
		'rows' => 4,
		'class' => 'feedbackTextbox',
		'value' => elgg_extract('txt', $values),
		'required' => true,
		'resize' => 'none',
	));
	?>
</div>

<div class="elgg-foot mbn">
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