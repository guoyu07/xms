<?php

class Default_Frontend_IndexSuccessView extends XRXDefaultFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$frontPage = $this->us->getAttribute('show_on_front', 'general');

		// Default is News Module
		if ( stripos($frontPage, 'page') !== false ) {
			$parts = explode('-', $frontPage);
			return $this->createForwardContainer('Page', 'Frontend.Index', array('id' => $parts[1]), null, 'read');
		} else {
			return $this->createForwardContainer('News', 'Frontend.Index', $rd, null, 'read');
		}
	}
}

?>