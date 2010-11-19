<?php

class User_Backend_EditInputView extends XRXUserBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', $this->tm->_('edit user', '.user'));
	}
}

?>