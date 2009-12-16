<?php

class User_Frontend_RegisterInputView extends XRXUserFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', $this->tm->_('user registration', '.user'));
	}
}

?>