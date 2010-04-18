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
					$(el).parent().after(ct);
				}
			})
		}
	}

	,removeErrors : function(form) {
		form = form || document;
		
		form.find(':input').removeClass('error');
		form.children('.xrx-errors').remove();
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
				if (!data) { return }

				// failure?
				if (data.success === false) {
					XRX.addErrors(data, form);
				} else {
					
				}

				btn.removeAttr('disabled');
				btn.next().remove();
			}
		});

		return false;
	})
});