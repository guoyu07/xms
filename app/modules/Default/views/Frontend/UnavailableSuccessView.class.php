<?php

class Default_Frontend_UnavailableSuccessView extends XRXDefaultFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);
		
		$this->setAttribute('_title', $this->tm->_('application unavailable', '.default'));
		
		$this->getResponse()->setHttpStatusCode('503');
	}
}

?>