<?php

class User_Frontend_LoginErrorView extends XRXUserFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);
		
		// Set error messages from the user login method
		if (($error = $this->getAttribute('error')) !== null) {
			$this->getContainer()->getValidationManager()
				 ->setError($error, sprintf($this->tm->_('Invalid %s', '.user'), $error));
		}

		// Use the input template, default would be LoginError, but that doesn't exist
		$this->getLayer('content')->setTemplate('Frontend/LoginInput');

		// Set the title
		$this->setAttribute('_title', $this->tm->_('user login error', '.user'));
	}
}

?>