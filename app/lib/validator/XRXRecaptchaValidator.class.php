<?php

/**
 * Validate reCAPTCHA
 *
 * @author Khashayar Hajian <me@khashayar.me>
 */
class XRXRecaptchaValidator extends AgaviValidator
{
   /**
	* Check if the user's guess was correct or not?
	*
	* @return	(bool) captcha value is correct?
	*/
	protected function validate()
	{
		$args		= $this->getArguments();
		$challenge	= $this->getData($args[0]);
		$response	= $this->getData($args[1]);

		// If one of arguments is not present, answer is not valid.
		if (!$challenge || !$response) {
			return false;
		}

		require 'reCaptcha/recaptchalib.php';

		$privateKey = '6LcAnQwAAAAAABxSqPxIo0mzKeZAR6SpEF8I5KPY';
		$resp		= recaptcha_check_answer($privateKey,
											 $_SERVER['REMOTE_ADDR'],
											 $challenge,
											 $response);
		FirePHP::getInstance(true)->log($resp);
		return $resp->is_valid;
	}
}

?>
