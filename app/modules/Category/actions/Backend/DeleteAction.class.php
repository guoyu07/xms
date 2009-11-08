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

		foreach ($ids as $id) {
			$catManager->deleteById($id);
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