<?php

/**
 * Custom validation class
 *
 * @author Khashayar Hajian <me@khashayar.me>
 */
class Comment_GenuineIdValidator extends AgaviValidator
{
   /**
	* Checks for existence of passed id.
	*
	* @return	(bool) comment with passed id exists?
	*/
	protected function validate()
	{
		$id		= $this->getData($this->getArgument());
		$lang	= $this->getContext()->getTranslationManager()
					   ->getCurrentLocale()->getLocaleLanguage();
		
		// Find Comment
		$comment = $this->getContext()
						->getModel('CommentManager', 'Comment')
						->retrieveById($id, $lang);

		// Checking for existance!
		if ($comment == null) {
			$this->throwError();
			return false;
		}

		// Pass fetched Comment object to EditAction
		$this->export($comment, 'comment');
		return true;
	}
}

?>
