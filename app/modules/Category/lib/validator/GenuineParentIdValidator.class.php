<?php

/**
 * Custom validation class
 *
 * @author Khashayar Hajian <me@khashayar.me>
 */
class Category_GenuineParentIdValidator extends AgaviValidator
{
   /**
	* Checks for existence of passed parent_id.
	*
	* @return	(bool) category with passed id exists?
	*/
	protected function validate()
	{
		$id		= $this->getData($this->getArgument());
		$parent	= $this->getContext()->getModel('CategoryManager', 'Category')->retrieveById($id);
		
		// Checking for existance!
		if ($parent == null) {
			$this->throwError();
			return false;
		}

		// Pass fetched Category object to Action
		$this->export($parent, 'parent');
		
		return true;
	}
}

?>
