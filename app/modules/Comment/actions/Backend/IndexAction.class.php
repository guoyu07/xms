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
		// Get Module by its id.
		$module = $this->getContext()->getModel('Modules')->retrieveById($rd->getParameter('module'));

		// Path for "comment.xml"
		$file = AgaviConfig::get('core.module_dir') . "/{$module->name}/config/comment.xml";

		// Leave it if it's not readable
		if (! is_readable($file)) {
			throw new AgaviException(sprintf("Couldn't find 'comment.xml' in %s", $file));
		}
		
		include(AgaviConfigCache::checkConfig($file));
		
		// Current Language
		$language = $this->getContext()->getTranslationManager()
						 ->getCurrentLocale()->getLocaleLanguage();

		// Get List of comments for passed module & current language.
		$comments = $this->getContext()->getModel('CommentManager', 'Comment')
						 ->retrieveAllByModuleId(4, $schema, $language);

		// Pass variables to view
		$this->setAttribute('module_name', $module->name);
		$this->setAttribute('comments', $comments);

		return 'Success';
	}
}

?>