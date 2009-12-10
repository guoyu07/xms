<?php

class Category_Frontend_ListAction extends XRXCategoryFrontendAction
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
		$this->setAttribute('categories',
			$this->getContext()->getModel('CategoryManager', 'Category')
							   ->retrieveAssociatedWith( $rd->getParameter('module_id') )
		);

		return 'Success';
	}
}

?>