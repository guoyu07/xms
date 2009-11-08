<?php

class User_Frontend_RegisterErrorView extends XRXUserFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->getLayer('content')->setTemplate('Frontend/RegisterInput');
		
		$this->setAttribute('_title', $this->tm->_('registration error', '.user'));
	}
}

?>