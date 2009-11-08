<?php

class User_Frontend_RegisterSuccessView extends XRXUserFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd, 'redirect');

		$this->setAttribute('_url', $this->ro->gen('default', array('path' => 'admin/default')));
		$this->setAttribute('_type', 'success');
		$this->setAttribute('_title', $this->tm->_('registeration succeed', '.user'));
	}
}

?>