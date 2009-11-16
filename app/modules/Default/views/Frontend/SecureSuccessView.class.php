<?php

class Default_Frontend_SecureSuccessView extends XRXDefaultFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', $this->tm->_('access denied', '.default'));
		
		$this->getResponse()->setHttpStatusCode('403');
	}
}

?>
