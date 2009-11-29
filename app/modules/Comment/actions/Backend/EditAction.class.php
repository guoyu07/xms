<?php

class Comment_Backend_EditAction extends XRXCommentBackendAction
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
		// Comment object send by validator
		$this->setAttribute('comment', $rd->getParameter('comment'));
		
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
		// Prepare parameters
		$params = array(
			'id'			=> $rd->getParameter('id'),
			'author_name'	=> $rd->getParameter('name'),
			'author_email'	=> $rd->getParameter('email'),
			'author_url'	=> $rd->getParameter('url'),
			'date'			=> $rd->getParameter('date'),
			'status'		=> $rd->getParameter('status'),
			'content'		=> $rd->getParameter('content'),
		);

		// Update the comment
		$this->getContext()->getModel('CommentManager', 'Comment')->update($params);

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