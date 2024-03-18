	/*  Wizard */
	jQuery(function ($) {
		"use strict";
		// Chose here which method to send the email, available:
		// Text/html(basic) > form_send.php
		// Phpmaimer text/html > phpmailer/form_send_phpmailer.php
		// Phpmaimer text/html SMPT > phpmailer/form_send_phpmailer_smtp.php
		// PHPmailer with html template > phpmailer/form_send_phpmailer_template.php
		// PHPmailer with html template SMTP> phpmailer/form_send_phpmailer_template_smtp.php
		$('form#wrapped').attr('action', 'phpmailer/form_send_phpmailer_template.php');
		$("#wizard_container").wizard({
			stepsWrapper: "#wrapped",
			submit: ".submit",
			beforeSelect: function (event, state) {
				if ($('input#website').val().length != 0) {
					return false;
				}
				if (!state.isMovingForward)
					return true;
				var inputs = $(this).wizard('state').step.find(':input');
				return !inputs.length || !!inputs.valid();
			}
		}).validate({
			errorPlacement: function (error, element) {
				if (element.is(':radio') || element.is(':checkbox')) {
					error.insertBefore(element.next());
				} else {
					error.insertAfter(element);
				}
			}
		});
	});