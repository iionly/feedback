define(function (require) {
	var elgg = require("elgg");
	var $ = require("jquery");
	require('jquery.form');

	$(document).on('click', '.feedback-toggler', function () {
		// forcefully hide the popup
		$('body').trigger('click');
		if (typeof elgg.ui.lightbox.close === 'function') {
			elgg.ui.lightbox.close();
		}
	});

	/**
	 * Repositions the feedback wrapper popup
	 */
	function popupHandler(hook, type, params, options) {
		if (!params.source.is('.feedback-toggler-fixed')) {
			// only do this for fixed element
			return;
		}

		options.my = 'left top';
		options.at = 'left top';
		options.collision = 'fit fit';
		return options;
	}

	elgg.register_hook_handler('getOptions', 'ui.popup', popupHandler);
});
