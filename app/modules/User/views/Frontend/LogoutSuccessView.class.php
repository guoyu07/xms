<?php

class User_Frontend_LogoutSuccessView extends XRXUserFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd, 'redirect');

		$this->getResponse()->setCookie('autologon[username]', false);
		$this->getResponse()->setCookie('autologon[password]', false);

		$this->setAttribute('_url', $this->ro->gen('default', array('path' => '')));
		$this->setAttribute('_type', 'success');
		$this->setAttribute('_title', $this->tm->_('logged out', '.user'));
	}
}

?>