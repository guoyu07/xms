<?php

class Page_Frontend_IndexAction extends XRXPageFrontendAction
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
		$page = $rd->getParameter('page');
		$lang = $this->tm->getCurrentLocale()->getLocaleLanguage();
		
		// If it's not published
		if (! $page[$lang]->published) {
			return 'Error';
		}

		// Set passed page from validator to view
		$this->setAttributeByRef('page', $page);

		return 'Success';
	}


	/**
	 * Returns the view if there's an error
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
	public function handleError(AgaviRequestDataHolder $rd)
	{
		return 'Error';
	}
}

?>