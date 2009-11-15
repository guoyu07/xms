<?php

class Category_Backend_DeleteAction extends XRXCategoryBackendAction
{
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
		$ids = $rd->getParameter('id');
		$catManager = $this->getContext()->getModel('CategoryManager', 'Category');

		// Find modules has been linked to these category ids.
		$modules = $catManager->retrieveModulesAssociatedWith($ids);

		foreach ($ids as $id) {
			// Thanks to InnoDB, there's no need to worry about deleting
			// relations in category-module table.
			$catManager->deleteById($id);
		}

		
		// InnoDB sets the category_id's value to null, so we just
		// need to loop through each related modules and update the
		// category_id to "Uncategorized" with id of 1.
		foreach ($modules as $m) {
			$moduleName = ucfirst(strtolower($m->name));
			$model = $this->getContext()->getModel("{$moduleName}Manager", $moduleName);

			if ($model instanceof XRXICategoryModel) {
				$model->resetCategoryId();
			}
			else {
				throw new AgaviException("Class {$moduleName}Manager is not instance of XRXICategoryModel");
			}
		}

		
		return "Success";
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
		return 'Error';
	}
}

?>