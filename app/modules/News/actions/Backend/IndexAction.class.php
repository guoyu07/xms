<?php

class News_Backend_IndexAction extends XRXNewsBackendAction
{
	/**
	 * Returns the default view if the action does not serve the request
	 * method used.
	 *
	 * @return     mixed <ul>
	 *                     <li>A string containing the view name associated
	 *                     with this action; or</li>
	 *                     <li>An array with two indices: the parent module
	 *                     of the view to be executed and the view to be
	 *                     executed.</li>
	 *                   </ul>
	 */
	public function getDefaultViewName()
	{
		return 'Success';
	}


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
		$page		 = $rd->getParameter('_p', '1');
		$limit		 = $this->us->getAttribute('items_per_page', 'setting.general');
		$start		 = ($page - 1) * $limit;
		$language	 = $this->tm->getCurrentLocale()->getLocaleLanguage();
		$newsManager = $this->getContext()->getModel('NewsManager', 'News');
		
		$this->setAttribute('news', $newsManager->retrieveLatest($language, $limit, $start));
		$this->setAttribute('page', $page);
		$this->setAttribute('limit', $limit);
		$this->setAttribute('total', $newsManager->getTotalCount());
		
		return 'Success';
	}
}

?>