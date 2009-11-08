<?php

class Default_Frontend_UnavailableSuccessView extends XRXDefaultFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);
		
		$this->setAttribute('_title', $this->tm->_('Application Unavailable', '.defau;t'));
		
		$this->getResponse()->setHttpStatusCode('503');
	}
}

?>