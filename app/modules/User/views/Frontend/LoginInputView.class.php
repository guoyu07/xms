<?php

class User_Frontend_LoginInputView extends XRXUserFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		// User authenticated? what's he doing here?
		if ($this->us->isAuthenticated()) {
			$this->getResponse()->setRedirect($this->ro->gen('admin'));
			return;
		}

		// Our login form is displayed. so let's remove that cookie thing there
		$this->getResponse()->setCookie('autologon[username]', false);
		$this->getResponse()->setCookie('autologon[password]', false);
		
		if ($this->rq->hasAttributeNamespace('org.agavi.controller.forwards.login')) {
			// we were redirected to the login form by the controller because
			// the requested action required security, so store the input URL
			// in the session for a redirect after login
			$this->us->setAttribute('redirect', $this->rq->getUrl(), 'org.agavi.XRX.login');
		}
		else {
			// clear the redirect URL just to be sure
			$this->us->removeAttribute('redirect', 'org.agavi.XRX.login');
		}

		$this->setAttribute('_title', $this->tm->_('user login', '.user'));
	}
}

?>