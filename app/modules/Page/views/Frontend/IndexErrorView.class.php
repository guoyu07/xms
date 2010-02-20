<?php

class Page_Frontend_IndexErrorView extends XRXPageFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$front = $this->us->getAttribute('show_on_front', 'setting.general');

		// If there's an error and it's supposed to display on front page
		// redirect it back to Default module and let it know that it's rejected.
		if ($front == 'page' && $this->getContainer()->getParameter('is_forward')) {
			$params = array('rejected' => true);
			return $this->createForwardContainer('Default', 'Frontend.Index', $params, null, 'read');
		}

		return $this->createForwardContainer(
			AgaviConfig::get('actions.error404_module'),
			AgaviConfig::get('actions.error404_action')
		);
	}
}

?>