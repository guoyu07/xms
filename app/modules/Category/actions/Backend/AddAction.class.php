<?php

class Category_Backend_AddAction extends XRXCategoryBackendAction
{
	/**
	 * Serves Read (GET) requests
	 *
	 * @param      AgaviRequestDataHolder the incoming request data
	 *
	 * @return     mixed <ul>
	 *                     <li>A string containing the view name associated
	 *                     with this action; or</li>
	 *                     <li>An array with two indices: the parent module
	 *                     of the view to be executed and the view to be
	 *                     executed.</li>
	 *                   </ul>
	 */
	public function executeRead(AgaviRequestDataHolder $rd)
	{
		// Set Modules
		$this->setAttribute('modules', $this->getContext()->getModel('Modules')->retrieveCategoryEnabled());

		// Set Categories
		$this->setAttribute('categories', $this->getContext()->getModel('CategoryManager', 'Category')->retrieveAll(true));

		return 'Input';
	}


	/**
	 * Serves Write (POST) requests
	 *
	 * @param      AgaviRequestDataHolder the incoming request data
	 *
	 * @return     mixed <ul>
	 *                     <li>A string containing the view name associated
	 *                     with this action; or</li>
	 *                     <li>An array with two indices: the parent module
	 *                     of the view to be executed and the view to be
	 *                     executed.</li>
	 *                   </ul>
	 */
	public function executeWrite(AgaviRequestDataHolder $rd)
	{
		$parent = $rd->getParameter('parent');

		// If parent is not root
		if (isset ($parent)) {
			$parent_id	= $parent->id;
			$path		= $parent->path;
			$module_id	= null;
		} else {
			$parent_id	= 0;
			$path		= '/0/';
			$module_id	= $rd->getParameter('module');
		}

		$params = array(
			'name'			=> $rd->getParameter('name'),
			'description'	=> $rd->getParameter('description'),
			'parent_id'		=> $parent_id,
			'path'			=> $path,
			'module_ids'	=> $module_id
		);

		// Insert in database
		$this->getContext()->getModel('CategoryManager', 'Category')->create($params);

		return 'Success';
	}


	/**
	 * Returns the view if there's an error at Write (POST) requests
	 *
	 * @param      AgaviRequestDataHolder the incoming request data
	 *
	 * @return     mixed <ul>
	 *                     <li>A string containing the view name associated
	 *                     with this action; or</li>
	 *                     <li>An array with two indices: the parent module
	 *                     of the view to be executed and the view to be
	 *                     executed.</li>
	 *                   </ul>
	 */
	public function handleWriteError(AgaviRequestDataHolder $rd)
	{
		// Set Modules
		$this->setAttribute('modules', $this->getContext()->getModel('Modules')->retrieveCategoryEnabled());

		// Set Categories
		$this->setAttribute('categories', $this->getContext()->getModel('CategoryManager', 'Category')->retrieveAll(true));
		
		return 'Input';
	}
}

?>