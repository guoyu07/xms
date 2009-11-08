<?php

class User_Frontend_RegisterInputView extends XRXUserFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		// User authenticated? what's he doing here?
		if ($this->us->isAuthenticated()) {
			$this->getResponse()->setRedirect($this->ro->gen('admin'));
			return;
		}

		$this->setAttribute('_title', $this->tm->_('user registration', '.user'));
	}
}

?>