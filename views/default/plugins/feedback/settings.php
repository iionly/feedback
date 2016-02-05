<?php
$entity = elgg_extract('entity', $vars);
?>
<div>
	<label><?php echo elgg_echo("feedback:settings:public") ?></label>
	<?php
	echo elgg_view('input/select', array(
		'name' => 'params[publicAvailable_feedback]',
		'value' => $entity->publicAvailable_feedback,
		'options_values' => array(
			'yes' => elgg_echo('option:yes'),
			'no' => elgg_echo('option:no'),
		),
	));
	?>
</div>
<div>
	<label><?php echo elgg_echo("feedback:settings:usernames") ?></label>
	<?php
	for ($i = 1; $i <= 5; $i++) {
		?>
		<div>
			<label><?php echo elgg_echo("feedback:user_{$i}") ?></label>
			<?php
			$sn = "user_{$i}";
			$value = $entity->$sn;
			if (!get_user_by_username($value)) {
				$value = '';
			}
			echo elgg_view('input/text', array(
				'name' => "params[{$sn}]",
				'value' => $value,
			));
			?>
		</div>
		<?php
	}
	?>
</div>
