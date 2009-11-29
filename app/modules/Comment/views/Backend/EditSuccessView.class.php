<?php

class Comment_Backend_EditSuccessView extends XRXCommentBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd, 'redirect');
		
		// Set original request URL redirect
		$this->setAttribute('_url', $rd->getParameter('referer'));
		$this->setAttribute('_type', 'success');
		$this->setAttribute('_title', $this->tm->_('redirecting...', '.comment'));
	}
}

?>