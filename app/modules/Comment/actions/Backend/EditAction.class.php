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
		$comment = $rd->getParameter('comment');
		$comment->user_type = $comment->author_id ? 'registered' : 'guest';
		
		$this->setAttribute('comment', $comment);
		$this->setAttribute('users', $this->getContext()
										  ->getModel('UserManager', 'User')
										  ->retrieveAll());
		
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
		$params['id']		= $rd->getParameter('id');
		$params['date']		= $rd->getParameter('date');
		$params['status']	= $rd->getParameter('status');
		$params['content']	= $rd->getParameter('content');
		
		
		if ($rd->getParameter('author_type') == 'registered') {
			$params['author_id'] = $rd->getParameter('author_id');
		} else {
			$params['author_id']	= null;
			$params['author_name']	= $rd->getParameter('name');
			$params['author_email'] = $rd->getParameter('email');
			$params['author_url']	= $rd->getParameter('url');
		}
		
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