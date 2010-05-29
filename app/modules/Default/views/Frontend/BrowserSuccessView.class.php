<?php

class Default_Frontend_BrowserSuccessView extends XRXDefaultFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd, 'simple');

		$this->setAttribute('_title', $this->tm->_('browser warning', '.default'));
	}
}

?>