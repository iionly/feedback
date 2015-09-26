define(function(require) {
	var elgg = require("elgg");
	var $ = require("jquery");

	// if user is logged in then disable the feedback ID
	if (elgg.is_logged_in()) {
		$('#feedback_id').prop('disabled', true);
	}

	var userip = $('#feedbackWrapper').data('userip');
	var progressimg = $('#feedbackWrapper').data('progressimg');
	var openimg = $('#feedbackWrapper').data('data-openimg');
	var closeimg = $('#feedbackWrapper').data('data-closeimg');

	$("#feedbackWrapper").width("50px");
	$('#feedbackClose').hide();

	var toggle_state = 0;

	function FeedBack_Toggle() {
		if (toggle_state) {
			toggle_state = 0;
			$("#feedbackWrapper").width("50px");
			$("#feedBackTogglerLink").html(openimg);
			$('#feedBackFormInputs').show();
				$("#feedBackFormStatus").html("");
			$('#feedbackClose').hide();
			document.forms["feedBackForm"].reset();
		} else {
			toggle_state = 1;
			$("#feedbackWrapper").width("450px");
			$("#feedBackTogglerLink").html(closeimg);
		}

		$("#feedBackContent").toggle();
	}

	function FeedBack_Send() {
		var page = encodeURIComponent(location.href);
		var mood = $('input[name=mood]:checked').val();
		var about = $('input[name=about]:checked').val();
		var id = $("#feedback_id").val().replace(/^\s+|\s+$/g,"");
		var txt = encodeURIComponent( $("#feedback_txt").val().replace(/^\s+|\s+$/g,"") );

		// if no address provided...
		if (id == '' || id == elgg.echo('feedback:default:id')) {
			id = userip;
		}

		// if no text provided...
		if (txt == '' || txt == encodeURIComponent(elgg.echo('feedback:default:txt'))) {
			alert(elgg.echo('feedback:default:txt:err'));
			return;
		}

		// show progress indicator
		$('#feedBackFormStatus').html(progressimg);

		// disable the send button while we are submitting
		$('#feedBackFormInputs').hide();

		var options = {
			data: "page="+page+"&mood="+mood+"&about="+about+"&id="+id+"&txt="+txt,
			cache: false,
			dataType: 'html',
			error: function() {
				$("#feedBackFormStatus").html("<div id='feedbackError'>" + elgg.echo('feedback:submit_err') + "</div>");
				$('#feedbackClose').show();
				document.forms["feedBackForm"].reset();
			},
			success: function(data) {
				$("#feedBackFormStatus").html(data);
				$('#feedbackClose').show();
				document.forms["feedBackForm"].reset();
			}
		};
		var url = elgg.security.addToken("action/feedback/submit_feedback");

		// fire the AJAX query
		elgg.post(url, options);
	}

	$('#feedBackTogglerLink').click(function(e) {
		e.preventDefault();
		FeedBack_Toggle();
		$(this).blur();
	});

	$('#feedback_close_btn').click(function(e) {
		e.preventDefault();
		FeedBack_Toggle();
	});

	$('#feedback_send_btn').click(function() {
		FeedBack_Send();
	});

	$('#feedback_cancel_btn').click(function(e) {
		e.preventDefault();
		FeedBack_Toggle();
	});

	$('#feedback_id').focus(function() {
		if ($(this).val() == elgg.echo('feedback:default:id')) {
			$(this).val('');
		}
	});

	$('#feedback_id').blur(function() {
		if ($(this).val() == '') {
			$(this).val(elgg.echo('feedback:default:id'));
		}
	});

	$('#feedback_txt').focus(function() {
		if ($(this).val() == elgg.echo('feedback:default:txt')) {
			$(this).val('');
		}
	});

	$('#feedback_txt').blur(function() {
		if ($(this).val() == '') {
			$(this).val(elgg.echo('feedback:default:txt'));
		}
	});

	$('#feedBackForm').submit(function() {
		FeedBack_Send();
		return false;
	});
});
