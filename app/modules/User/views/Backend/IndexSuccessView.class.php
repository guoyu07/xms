<?php

class User_Backend_IndexSuccessView extends XRXUserBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', $this->tm->_('users list', '.user'));
	}
}

?>