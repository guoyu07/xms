<?php

class Default_Frontend_IndexSuccessView extends XRXDefaultFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		// If landing module rejected to be shown (validation error, ...)
		if ( $rd->getParameter('rejected') ) {
			// Update the FrontPage stored in session.
			$this->us->setAttribute('show_on_front', 'news', 'setting.general');

			// Redirect back to News Module
			return $this->createForwardContainer('News', 'Frontend.Index', $rd, null, 'read');
		}

		

		$frontPage = $this->us->getAttribute('show_on_front', 'setting.general');

		switch ($frontPage) {
			// Page
			case 'page':
				$params = array(
					'id' => $this->us->getAttribute('show_on_front_id', 'setting.general'),
				);
				
				return $this->createForwardContainer('Page', 'Frontend.Index', $params, null, 'read');
				break;

			// News
			default:
				return $this->createForwardContainer('News', 'Frontend.Index', $rd, null, 'read');
		}
	}
}

?>