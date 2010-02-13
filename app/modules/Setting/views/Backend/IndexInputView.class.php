<?php

class Setting_Backend_IndexInputView extends XRXSettingBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', $this->tm->_('settings', '.setting'));
	}
}

?>