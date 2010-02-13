<?php

class News_Frontend_IndexAction extends XRXNewsFrontendAction
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
		// Pagination
		$page	= $rd->getParameter('_p', '1');
		$limit	= 10;
		$start	= ($page - 1) * 10;

		$locale = $this->getContext()->getTranslationManager()->getCurrentLocale();
		$cid	= $rd->getParameter('category', null);

		$newsManager = $this->getContext()->getModel('NewsManager', 'News');
		
		// Pass to view
		$this->setAttributeByRef('news', $newsManager->retrieveLatest($locale->getLocaleLanguage(), $limit, $start, true, $cid));
		$this->setAttribute('page', $page);
		$this->setAttribute('total', $newsManager->getTotalCount());
		
		return 'Success';
	}
}

?>