<?php

/**
 * Custom validation class
 *
 * @author Khashayar Hajian <me@khashayar.me>
 */
class News_GenuineIdValidator extends AgaviValidator
{
   /**
	* Checks for existence of passed id.
	*
	* @return	(bool) news with passed id exists?
	*/
	protected function validate()
	{
		$id		= $this->getData($this->getArgument());
		$news	= $this->getContext()->getModel('NewsManager', 'News')->retrieveById($id);
		$lang	= $this->getContext()->getTranslationManager()
					   ->getCurrentLocale()->getLocaleLanguage();

		// Checking for existance!
		if ($news == null || empty ($news[$lang])) {
			$this->throwError();
			return false;
		}

		// Pass fetched News object to EditAction
		$this->export($news, 'news');
		return true;
	}
}

?>
