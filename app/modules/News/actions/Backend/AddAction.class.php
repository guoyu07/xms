<?php

class News_Backend_AddAction extends XRXNewsBackendAction
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
		// Set Categories
		$this->setAttribute('categories', $this->getContext()
											   ->getModel('CategoryManager', 'Category')
											   ->retrieveAssociatedWith( AgaviConfig::get('modules.news.id') ));

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
		$file	= $rd->getFile('image');
		$trans	= $rd->getParameter('translation');

		// Prepare translatable values to send to model
		foreach ($trans as $key => $val) {
			if (count($trans[$key]) > 0) {
				$trans[$key]['language'] = $key;
				unset ($trans[$key]['check']);
			} else {
				unset ($trans[$key]);
			}
		}

		// Handle image file
		if ($file) {
			$dir = AgaviConfig::get('core.pub_dir') . '/modules/news/';

			switch ($file->getType()) {
				case 'image/jpeg':
				case 'image/pjpeg':
					$name = md5(microtime(true)) . '.jpg';
					break;

				case 'image/gif':
					$name = md5(microtime(true)) . '.gif';
					break;
			}

			$file->move("$dir/$name");
		}

		$params = array(
			'date'			=> $rd->getParameter('date'),
			'published'		=> (boolean) $rd->getParameter('published'),
			'image'			=> $name,
			'author_id'		=> $this->getContext()->getUser()->getAttribute('userId'),
			'category_id'	=> $rd->getParameter('category'),
			'translations'	=> $trans
		);

		// Insert in database
		$this->getContext()->getModel('NewsManager', 'News')->create($params);
		
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
		// Set Categories
		$this->setAttribute('categories', $this->getContext()
											   ->getModel('CategoryManager', 'Category')
											   ->retrieveAssociatedWith( AgaviConfig::get('modules.news.id') ));
		
		return 'Input';
	}


	/**
	 * Manually validate files and parameters in Write (POST) requests.
	 *
	 * @param      AgaviRequestDataHolder The action's request data holder.
	 *
	 * @return     bool true, if validation completed successfully, otherwise
	 *                  false.
	 */
	public function validateWrite(AgaviRequestDataHolder $rd)
	{
		// Only could get here if someone trying to do malicious actions
		$translation = $rd->getParameter('translation');
		$tManager	 = $this->getContext()->getTranslationManager();
		$language	 = $tManager->getCurrentLocale()->getLocaleLanguage();
		
		// If form's structure has been changed!!!
		if (empty ($translation) ||
			empty ($translation[$language]) ||
			empty ($translation[$language]['check']))
		{
			$this->getContainer()->getValidationManager()->setError("", $tManager->_("Malicious action detected!", ".news"));
			return false;
		}

		return true;
	}
}

?>