<?php

// +---------------------------------------------------------------------------+
// | This file is part of the Agavi package.                                   |
// | Copyright (c) 2005-2009 the Agavi Project.                                |
// | Based on the Mojavi3 MVC Framework, Copyright (c) 2003-2005 Sean Kerr.    |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code. You can also view the    |
// | LICENSE file online at http://www.agavi.org/LICENSE.txt                   |
// |   vi: set noexpandtab:                                                    |
// |   Local Variables:                                                        |
// |   indent-tabs-mode: t                                                     |
// |   End:                                                                    |
// +---------------------------------------------------------------------------+

class XRXRbacSecurityUser extends AgaviRbacSecurityUser
{
	protected $user;

	public function startup()
	{
		parent::startup();

		$reqData = $this->getContext()->getRequest()->getRequestData();

		if(!$this->isAuthenticated() && $reqData->hasCookie('autologon')) {
			$login = $reqData->getCookie('autologon');
			try {
				$this->login($login['username'], $login['password'], true);
			} catch(AgaviSecurityException $e) {
				$response = $this->getContext()->getController()->getGlobalResponse();
				
				// login didn't work. that cookie sucks, delete it.
				$response->setCookie('autologon[username]', false);
				$response->setCookie('autologon[password]', false);
			}
		}
	}

	public function login($username, $password, $isPasswordHashed = false)
	{
		try {
			$userManager = $this->getContext()->getModel('UserManager', 'User');
			$this->user	 = $userManager->getByUsername($username);
		} catch(AgaviSecurityException $e) {

		}

		if(!isset($this->user)) {
			throw new AgaviSecurityException('username');
		}

		if(!$isPasswordHashed) {
			$password = $this->computeHash($password);
		}

		if($password != $this->user->getPassword()) {
			throw new AgaviSecurityException('password');
		}

		$this->setAuthenticated(true);
		$this->clearCredentials();

		// Let's save user's data for future refrence!
		$this->setAttribute('userId', $this->user->getId());
		$this->setAttribute('username', $this->user->getUsername());
		$this->setAttribute('password', $this->user->getPassword());
		$this->setAttribute('email', $this->user->getEmail());

		// TODO: should be implemented
		// $this->grantRoles($this->user->getRoles());

		return $this->user;
	}

	public function computeHash($secret)
	{
		return sha1($secret);
	}

	public function getPassword()
	{
		if($this->user) {
			return $this->user->getPassword();
		}
	}

	public function logout()
	{
		$this->clearCredentials();
		$this->setAuthenticated(false);
	}
}

?>