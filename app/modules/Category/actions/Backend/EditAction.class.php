<?php

class Category_Backend_EditAction extends XRXCategoryBackendAction
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
		// EditValidator passed category object
		$this->setAttribute('category', $rd->getParameter('category'));

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
		// Get CategoryManager model
		$catManager  = $this->getContext()->getModel('CategoryManager', 'Category');

		$id			 = $rd->getParameter('id');
		$parent		 = $rd->getParameter('parent');
		$prev_parent = $catManager->retrieveByChildId($id);


		// If parent is not root
		if (isset ($parent)) {
			$parent_id		= $parent->id;
			$parent_path	= $parent->path;
			$path			= $parent->path . $id . '/';
			$module_id		= null;
		} else {
			$parent_id		= 0;
			$parent_path	= "/0/";
			$path			= "/0/$id/";
			$module_id		= $rd->getParameter('module');
		}

		// Prepare parameters to send to model
		$params = array(
			'id'				=> $id,
			'name'				=> $rd->getParameter('name'),
			'description'		=> $rd->getParameter('description'),
			'path'				=> $path,
			'parent_id'			=> $parent_id,
			'parent_path'		=> $parent_path,
			'prev_parent_id'	=> $prev_parent->getId(),
			'prev_parent_path'	=> $prev_parent->getPath(),
			'module_ids'		=> $module_id
		);

		

		
		// Insert in database
		if ($catManager->update($params)) {

			// Sync relations between category & module
			if ($prev_parent->getId() == 0 && $parent_id != 0) {
				// Parent -> Child

				$catManager->deleteRelationsById($id);
			}
			else if ($prev_parent->getId() != 0 && $parent_id == 0) {
				// Child -> Parent

				$catManager->createRelations($id, $module_id);
			}
			else if ($prev_parent->getId() == 0 && $parent_id == 0) {
				// Parent -> Parent
				
				$catManager->deleteRelationsById($id);
				$catManager->createRelations($id, $module_id);
			}

		}

		return 'Success';
	}


	/**
	 * Returns the view if there's an error in Read (GET) requests
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
	public function handleReadError(AgaviRequestDataHolder $rd)
	{
		return 'Error';
	}


	/**
	 * Returns the view if there's an error in Write (POST) requests
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