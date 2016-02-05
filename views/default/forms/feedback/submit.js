define(function (require) {
	var elgg = require("elgg");
	var $ = require("jquery");
	var spinner = require('elgg/spinner');
	require('jquery.form');

	$(document).on('submit', '.elgg-form-feedback-submit', function (e) {
		var $form = $(this);
		var $pageInput = $form.find('input[name="page"]');
		if (!$pageInput.val()) {
			$pageInput.val(location.href);
		}
		elgg.action($form.attr('action'), {
			data: $form.serialize(),
			beforeSend: function () {
				$form.find('[type="submit"]').prop('disabled', true).addClass('elgg-state-disabled');
				spinner.start();
			},
			complete: function () {
				$form.find('[type="submit"]').prop('disabled', false).removeClass('elgg-state-disabled');
				spinner.stop();
			},
			success: function (data) {
				if (data.status >= 0) {
					$form.find('.feedback-toggler').trigger('click'); // hide
				}
			}
		});
		return false;
	});
});
