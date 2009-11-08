<?php

class User_Frontend_IndexSuccessView extends XRXUserFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', $this->tm->_('Frontend.Index', '.user'));
	}
}

?>