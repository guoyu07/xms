<?php

/**
 * Custom validation class
 *
 * @author Khashayar Hajian <me@khashayar.me>
 */
class Category_GenuineModuleIdValidator extends AgaviValidator
{
   /**
	* Checks for existence of passed module ids.
	*
	* @return	(bool) module with passed id exists?
	*/
	protected function validate()
	{
		$ids = $this->getData($this->getArgument());

		foreach ($ids as $id) {
			$module	= $this->getContext()->getModel('Modules')->retrieveById($id);
			
			// Checking for existance!
			if ($module == null) {
				$this->throwError();
				return false;
			}
			
			$modules[] = $module->id;
		}

		// Pass fetched Module to Action
		$this->export($modules, 'module');
		
		return true;
	}
}

?>
