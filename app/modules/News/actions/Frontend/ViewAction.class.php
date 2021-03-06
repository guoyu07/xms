<?php

class News_Frontend_ViewAction extends XRXNewsFrontendAction
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
		$news = $rd->getParameter('news');
		$lang = $this->getContext()->getTranslationManager()
					 ->getCurrentLocale()->getLocaleLanguage();

		// If it's not published
		if (! $news[$lang]->published) {
			return 'Error';
		}

		// Set passed news from Validator to view
		$this->setAttributeByRef('news', $news);

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