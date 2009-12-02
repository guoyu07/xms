<?php

class Comment_Frontend_AddSuccessView extends XRXCommentFrontendView
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