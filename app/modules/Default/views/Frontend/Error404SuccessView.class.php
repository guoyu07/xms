<?php

class Default_Frontend_Error404SuccessView extends XRXDefaultFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);
		
		$this->setAttribute('_title', $this->tm->_('404 not found', '.default'));
		
		$this->getResponse()->setHttpStatusCode('404');
	}
}

?>