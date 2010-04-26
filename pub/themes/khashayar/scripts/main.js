/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var XRX = {
	addErrors : function(data, form) {
		form = form || document;

		// Loop through failed fields
		for (var field in data.errors) {
			form.find(':input').each( function(idx, el) {
				// Is this the same failed field?
				if (el.name == field) {
					var ct = '<div class="xrx-errors">';

					for (var i = 0; i < data.errors[field].length; ++i) {
						ct += '<p class="xrx-error">' + data.errors[field][i] + '</p>';
					}

					ct += '</div>';
					$(el).addClass('error');

					// If the form created by li, append erros to them
					// else append error to it's parent
					if ($(el).parents('li')) {
						$(el).parents('li').append(ct);
					} else {
						$(el).parent().after(ct);
					}
				}
			})
		}

		// If reCaptcha enabled
		if (typeof Recaptcha != 'undefined') {
			Recaptcha.reload();
		}
	}

	,removeErrors : function(form) {
		form = form || document;
		
		form.find(':input').removeClass('error');
		form.find('.xrx-errors').remove();
		form.children('.xrx-errors').remove();
	}

	,handleResponse : function(data) {
		if (data.redirect) {
			window.location = data.redirect;
		}
		
		if (data.alert) {
			window.alert(data.alert);
		}

		if (data.message && data.msgTarget) {
			$(data.msgTarget).html(data.message);
		}

		if (data.content && data.ctTarget) {
			data.location = data.location || '';
			
			switch (data.location) {
				case 'before':
					$(data.ctTarget).before(data.content);
					break;

				case 'after':
					$(data.ctTarget).after(data.content);
					break;

				case 'child:first':
					$(data.ctTarget).prepend(data.content);
					break;

				case 'child:last':
				default:
					$(data.ctTarget).append(data.content);
			}
		}
	}
}


$(function() {
	var forms = $('form');

	forms.submit( function(e) {
		var form = $(e.target);
		var btn = form.find('input[type="submit"]');
		btn.attr('disabled', 'disabled');
		btn.after('<span class="xrx-loading"></span>');

		// Remove all errors in case of previously created
		XRX.removeErrors(form);

		$.ajax({
			url			: form.attr('action')
			,dataType	: 'json'
			,type		: 'post'
			,data		: form.serialize()
			,success	: function(data) {
				if (!data) {return}

				switch (data.status) {
					case 'failure':
						XRX.addErrors(data, form);
						break;

					case 'success':
						XRX.handleResponse(data);
						form[0].reset();
						break;
				}

				btn.removeAttr('disabled');
				btn.next().remove();
			}
		});

		return false;
	})
});