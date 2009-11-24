<?php

class Comment_Frontend_AddAction extends XRXCommentFrontendAction
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
		$this->setAttribute('module_id', $rd->getParameter('module_id'));
		$this->setAttribute('owner_id', $rd->getParameter('owner_id'));
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
		// Authenticated?
		if ($this->getContext()->getUser()->isAuthenticated()) {
			$params['author_id'] = $this->getContext()->getUser()->getAttribute('userId');
		} else {
			$params['author_name']	= $rd->getParameter('name');
			$params['author_email'] = $rd->getParameter('email');
			$params['author_url']	= $rd->getParameter('url');
		}

		// Prepare Parameters to send to model.
		$params['owner_id']	= $rd->getParameter('owner_id');
		$params['module_id']= $rd->getParameter('module_id');
		$params['content']	= $rd->getParameter('content');

		// Get current language
		$language = $this->getContext()->getTranslationManager()
						   ->getCurrentLocale()->getLocaleLanguage();

		// Add comment in database
		$this->getContext()->getModel('CommentManager', 'Comment')->create($params, $language);

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
		return 'Input';
	}
}

?>