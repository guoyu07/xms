<?php

class User_Frontend_LoginSuccessView extends XRXUserFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd, 'redirect');

		// Response
		$res = $this->getResponse();
		
		// Set the autologon cookie if requested
		if ($rd->hasParameter('remember')) {
			$res->setCookie('autologon[username]', $rd->getParameter('username'), '+14 days');
			$res->setCookie('autologon[password]', $this->us->getPassword(), '+14 days');
		}

		// Find redirect url
		if ($this->us->hasAttribute('redirect', 'org.agavi.XRX.login')) {
			// Get original request URL redirect
			$url = $this->us->removeAttribute('redirect', 'org.agavi.XRX.login');
		}
		else {
			// Generate Redirect URL
			$url = $this->ro->gen('admin');
		}

		$this->setAttribute('_title', $this->tm->_('logged in', '.user'));
		$this->setAttribute('_type', 'success');
		$this->setAttribute('_url', $url);
	}
}

?>