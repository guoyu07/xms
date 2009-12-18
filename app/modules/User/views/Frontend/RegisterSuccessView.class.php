<?php

class User_Frontend_RegisterSuccessView extends XRXUserFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd, 'redirect');

		$url = ($this->us->isAuthenticated()) ?
					$this->ro->gen('default', array('path' => 'admin/user')):
					$this->ro->gen('default', array('path' => 'user/login'));

		$this->setAttribute('_url', $url);
		$this->setAttribute('_type', 'success');
		$this->setAttribute('_title', $this->tm->_('registeration succeed', '.user'));
	}
}

?>