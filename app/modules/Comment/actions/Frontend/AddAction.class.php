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
		$this->setAttribute('parameters', $rd->getParameter('parameters'));

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
		// Prepare Parameters to send to model.
		$params['owner_id']	= $rd->getParameter('owner_id');
		$params['module_id']= $rd->getParameter('module_id');
		$params['content']	= $rd->getParameter('content');
		FirePHP::getInstance(true)->log(nl2br($rd->getParameter('content')));

		// Authenticated?
		if ($this->getContext()->getUser()->isAuthenticated()) {
			$params['author_id'] = $this->us->getAttribute('userId');
		} else {
			$params['author_name']	= $rd->getParameter('name');
			$params['author_email'] = $rd->getParameter('email');
			$params['author_url']	= $rd->getParameter('url');
		}

		// Status
		$params['status'] = $this->us->getAttribute('default_status', 'setting.comment');

		// Get current language
		$language = $this->tm->getCurrentLocale()->getLocaleLanguage();

		// Add comment in database
		$comment = $this->getContext()->getModel('CommentManager', 'Comment')->create($params, $language);

		$this->setAttribute('comment', $comment);

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
		$this->setAttribute('module_id', $rd->getParameter('module_id'));
		$this->setAttribute('owner_id', $rd->getParameter('owner_id'));
		$this->setAttribute('parameters', $rd->getParameter('parameters'));
		
		return 'Error';
	}
}

?>