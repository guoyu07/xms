<?php

class Setting_Backend_IndexAction extends XRXSettingBackendAction
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
		return 'Input';
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
		// Prepare params based on submitted module
		if ( ! is_null($rd->getParameter('general')) ) {
			$settings = array(
				array('name' => 'website_title',	'value' => $rd->getParameter('website_title'),		'module' => 'general'),
				array('name' => 'items_per_page',	'value' => $rd->getParameter('items_per_page'),		'module' => 'general'),
				array('name' => 'show_on_front',	'value' => $rd->getParameter('front_page'),			'module' => 'general'),
				array('name' => 'show_on_front_id',	'value' => $rd->getParameter('front_page_id', 0),	'module' => 'general')
			);
		}
		else if ( ! is_null($rd->getParameter('comment')) ) {
			$settings = array(
				array('name' => 'default_status',	'value' => $rd->getParameter('default_status'),	'module' => 'comment'),
			);
		}
		else {
			return 'Input';
		}


		$manager = $this->getContext()->getModel('SettingManager', 'Setting');
		if ( $manager->update($settings) ) {
			// Update the stored settings in session
			$this->getContext()->getUser()->initSettings(true);
		}

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
		return 'Input';
	}
}

?>