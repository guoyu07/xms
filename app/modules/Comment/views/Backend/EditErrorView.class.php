<?php

class Comment_Backend_EditErrorView extends XRXCommentBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd, 'redirect');

		// Set error messages for template
		$this->setAttribute('errors', $this->getContainer()->getValidationManager()->getErrorMessages());

		$this->setAttribute('_url', $this->ro->gen('default', array('path' => 'admin')));
		$this->setAttribute('_type', 'error');
		$this->setAttribute('_title', $this->tm->_('redirecting...', '.comment'));
	}
}

?>