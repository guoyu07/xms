<?php

class Comment_Backend_IndexAction extends XRXCommentBackendAction
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
		
//		$language		= $this->getContext()->getTranslationManager()
//											 ->getCurrentLocale()
//											 ->getLocaleLanguage();
//
//		$this->setAttribute('comments', $commentManager->retrieveAll());


		// Path for "comment.xml"
		$file = AgaviConfig::get('core.module_dir') . "/News/config/comment.xml";

		// Leave it if it's not readable
		if (! is_readable($file)) {
			return "Error";
		}
		
		include(AgaviConfigCache::checkConfig($file));

		$commentManager = $this->getContext()->getModel('CommentManager', 'Comment');
		$this->setAttribute('comments', $commentManager->retrieveAllByModuleId(4, $tables));

		return 'Success';
	}
}

?>