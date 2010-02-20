<?php

class Page_Backend_DeleteErrorView extends XRXPageBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd, 'redirect');

		// Set error messages for template
		$this->setAttribute('errors', $this->getContainer()->getValidationManager()->getErrorMessages());

		$this->setAttribute('_url', $this->ro->gen('default', array('path' => 'admin/page')));
		$this->setAttribute('_type', 'error');
		$this->setAttribute('_title', $this->tm->_('redirecting...', '.page'));
	}
}

?>