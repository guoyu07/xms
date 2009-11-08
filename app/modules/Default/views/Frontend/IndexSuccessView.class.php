<?php

class Default_Frontend_IndexSuccessView extends XRXDefaultFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', $this->tm->_('Main Page', '.defau;t'));
	}
}

?>