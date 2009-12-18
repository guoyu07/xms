<?php

class User_Backend_EditSuccessView extends XRXUserBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd, 'redirect');

		// Set original request URL redirect
		$this->setAttribute('_url', $this->ro->gen('default', array('path'=>'admin/user')));
		$this->setAttribute('_type', 'success');
		$this->setAttribute('_title', $this->tm->_('redirecting...', '.user'));
	}
}

?>