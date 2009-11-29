<?php

class Comment_Frontend_ListAction extends XRXCommentFrontendAction
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
		$owner_id	= $rd->getParameter('owner_id');
		$module_id	= $rd->getParameter('module_id');
		$language	= $this->getContext()->getTranslationManager()
						   ->getCurrentLocale()->getLocaleLanguage();

		$this->setAttribute('comments',
			$this->getContext()->getModel('CommentManager', 'Comment')
							   ->retrieveByOwnerId($owner_id, $module_id, $language, 'approved')
		);
		
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
}

?>