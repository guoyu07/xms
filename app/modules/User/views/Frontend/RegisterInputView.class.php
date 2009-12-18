<?php

class User_Frontend_RegisterInputView extends XRXUserFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		// Change the layout based on Authenticated user.
		$layout = ($this->us->isAuthenticated()) ? 'backend' : 'frontend';

		$this->setupHtml($rd, $layout);

		$this->setAttribute('_title', $this->tm->_('user registration', '.user'));
	}
}

?>