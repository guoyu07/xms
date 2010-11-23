<?php

class News_Backend_EditAction extends XRXNewsBackendAction
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
		// EditValidator passed news' object
		$this->setAttributeByRef('news', $rd->getParameter('news'));

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
		$id		= $rd->getParameter('id');
		$trans	= $rd->getParameter('translation');

		// Prepare values to send to model
		foreach ($trans as $key => $val) {
			if (count($trans[$key]) > 0) {
				$trans[$key]['language'] = $key;
				unset ($trans[$key]['check']);
			} else {
				unset ($trans[$key]);
			}
		}

		$params = array(
			'id'			=> $id,
			'modified'		=> date(DATE_ATOM),
			'published'		=> (boolean) $rd->getParameter('published'),
			'comment_status'=> (boolean) $rd->getParameter('comments'),
			'image'			=> $rd->getParameter('image'),
			'category_id'	=> $rd->getParameter('category'),
			'translations'	=> $trans
		);

		// Insert in database
		$newsManager = $this->getContext()->getModel('NewsManager', 'News');
		$newsManager->update($params);


		// Delete translations if there's any
		$deleted = $rd->getParameter('deleted');
		
		if ($deleted) {
			if (count ($deleted) > 1) {
				$newsManager->deleteAllByLang($id, $deleted);
			} else {
				$newsManager->deleteByLang($id, $deleted[0]);
			}
		}


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
		// Set Categories
		$this->setAttribute('categories', $this->getContext()
											   ->getModel('CategoryManager', 'Category')
											   ->retrieveAssociatedWith( AgaviConfig::get('modules.news.id') ));
		
		return 'Input';
	}
}

?>