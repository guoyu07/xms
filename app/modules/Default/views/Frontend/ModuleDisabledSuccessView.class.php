<?php

class Default_Frontend_ModuleDisabledSuccessView extends XRXDefaultFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', $this->tm->_('Module Disabled', '.defau;t'));
		
		$this->getResponse()->setHttpStatusCode('503');
	}
}

?>
