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
		$locale = $this->getContext()->getTranslationManager()->getCurrentLocale();
		
		// Get lastest news
		$news = $this->getContext()->getModel('NewsManager', 'News')
					 ->retrieveLatest($locale->getLocaleLanguage(), 10, 0, true);
		
		// Pass to view
		$this->setAttributeByRef('news', $news);

		return 'Success';
	}
}

?>