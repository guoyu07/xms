<?php

class Comment_Frontend_AddSuccessView extends XRXCommentFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		// Get original request URL redirect
		$url = $this->us->removeAttribute('redirect', 'org.agavi.XRX.comment');

		// Redirect to original url
		$this->getContainer()->getResponse()->setRedirect($url);
	}
}

?>