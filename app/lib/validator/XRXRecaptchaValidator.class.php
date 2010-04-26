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

		$user		= $this->getContext()->getUser();
		$privateKey = $user->getAttribute('recaptcha_private_key', 'setting.default');
		$resp		= recaptcha_check_answer($privateKey,
											 $_SERVER['REMOTE_ADDR'],
											 $challenge,
											 $response);
		
		if (! $resp->is_valid) {
			$this->throwError(null, $args[1]);
			return false;
		}

		return true;
	}
}

?>
