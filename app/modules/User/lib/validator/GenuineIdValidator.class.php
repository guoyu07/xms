<?php

/**
 * Custom validation class
 *
 * @author Khashayar Hajian <me@khashayar.me>
 */
class User_GenuineIdValidator extends AgaviValidator
{
   /**
	* Checks for existence of passed id.
	*
	* @return	(bool) comment with passed id exists?
	*/
	protected function validate()
	{
		$id	= $this->getData($this->getArgument());
		
		// Find Comment
		$user = $this->getContext()
						->getModel('UserManager', 'User')
						->retrieveById($id);

		// Checking for existance!
		if ($user == null) {
			$this->throwError();
			return false;
		}

		// Pass fetched Comment object to EditAction
		$this->export($user, 'user');
		return true;
	}
}

?>