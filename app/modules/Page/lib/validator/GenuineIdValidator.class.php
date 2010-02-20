<?php

/**
 * Custom validation class
 *
 * @author Khashayar Hajian <me@khashayar.me>
 */
class Page_GenuineIdValidator extends AgaviValidator
{
   /**
	* Checks for existence of passed id.
	*
	* @return	(bool) page with passed id exists?
	*/
	protected function validate()
	{
		$id		= $this->getData( $this->getArgument() );
		$page	= $this->getContext()->getModel('PageManager', 'Page')->retrieveById($id);
		$lang	= $this->getContext()->getTranslationManager()
					   ->getCurrentLocale()->getLocaleLanguage();

		// Checking for existance!
		if ( ($page == null || empty ($page[$lang])) ) {
			$this->throwError();
			return false;
		}

		// Pass fetched Page object to EditAction
		$this->export($page, 'page');
		return true;
	}
}

?>
