<?php

/**
 * Custom validation class
 *
 * @author Khashayar Hajian <me@khashayar.me>
 */
class Category_GenuineIdValidator extends AgaviValidator
{
   /**
	* Checks for existence of passed id.
	*
	* @return	(bool) category with passed id exists?
	*/
	protected function validate()
	{
		$id		= $this->getData($this->getArgument());
		$cat	= $this->getContext()->getModel('CategoryManager', 'Category')->retrieveById($id);
		
		// Checking for existance!
		if ($cat == null) {
			$this->throwError();
			return false;
		}

		// Pass fetched object to EditAction
		$this->export($cat, 'category');
		return true;
	}
}

?>
