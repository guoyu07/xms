<?php

class Page_Backend_EditAction extends XRXPageBackendAction
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
		// EditValidator passed page object
		$this->setAttributeByRef('page', $rd->getParameter('page'));
		
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
			'published'		=> (boolean) $rd->getParameter('published'),
			'translations'	=> $trans
		);

		// Insert in database
		$pageManager = $this->getContext()->getModel('PageManager', 'Page');
		$pageManager->update($params);


		// Delete translations if there's any
		$deleted = $rd->getParameter('deleted');

		if ($deleted) {
			$pageManager->deleteByLang($id, $deleted);
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
		return 'Input';
	}
}

?>