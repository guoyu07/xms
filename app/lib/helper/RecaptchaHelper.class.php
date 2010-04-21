<?php

/**
 * Helper class
 * ReCAPTCHA helper. generate reCaptcha content and pass it to caller.
 *
 * @author Khashayar Hajian <me@khashayar.me>
 * 
 */
class RecaptchaHelper extends XRXHelper
{
    public function Recaptcha()
	{
		require_once 'reCaptcha/recaptchalib.php';

		$publicKey = '6LcAnQwAAAAAAOxHqnYqXsL5v08QJ8ODaFQKioFf';

		$captcha = recaptcha_get_html($publicKey);
		$script	 = "\n\r
			<script>
				var RecaptchaOptions = {
				   theme : 'clean'
				};
			</script>\n<!--
			<div id='recaptcha_widget'>
				<div id='recaptcha_image'></div>
				<input type='text' id='recaptcha_response_field' name='recaptcha_response_field' />
			</div>-->";

		$captcha = $script . $captcha;
		return $captcha;
	}
}

?>