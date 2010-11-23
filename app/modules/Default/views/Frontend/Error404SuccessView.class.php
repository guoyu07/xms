<?php

class Default_Frontend_Error404SuccessView extends XRXDefaultFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$ref	= parse_url($rd->getHeader('REFERER'), PHP_URL_HOST);
		$host	= $rd->getHeader('HOST');

		// If Referer is the Host itself, don't send 404 status code,
		// cause it's not SEO friendly. otherwise, let user knows she
		// had a wrong link or typed the url incorrectly.
		// This is useful for multilingual modules and when a content
		// doesn't have the translation, so it'd be better to redirect
		// visitor to index instead of a 404 page.

		if (!empty ($ref) && $ref == $host) {
			$this->getResponse()->setRedirect($this->ro->gen('index'));
			return;
		}

		$this->setAttribute('_title', $this->tm->_('404 not found', '.default'));
		
		$this->getResponse()->setHttpStatusCode('404');
	}
}

?>