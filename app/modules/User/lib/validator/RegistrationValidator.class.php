<?php

/**
 * Custom validation class
 *
 * @author Khashayar Hajian <me@khashayar.me>
 */
class User_RegistrationValidator extends AgaviValidator
{
   /**
	* Checks for uniquness of username & email address.
	*
	* @return	(bool) Same user already registered with this username and/or email.
	*/
	protected function validate()
	{
		$arguments	= $this->getArguments();
		$username	= $this->getData($arguments[0]);
		$email		= $this->getData($arguments[1]);

		$userManager = $this->getContext()->getModel('UserManager', 'User');
		$user		 = $userManager->getByUsernameOrEmail($username, $email);
		
		// Checking for uniquness!
		if ($user) {
			if ($user->getUsername() == $username)
				$this->throwError($arguments[0], $arguments[0]);

			if ($user->getEmail() == $email)
				$this->throwError($arguments[1], $arguments[1]);
				
			return false;
		}

		return true;
	}
}

?>
