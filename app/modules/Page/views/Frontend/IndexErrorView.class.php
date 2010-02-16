<?php

class Page_Frontend_IndexErrorView extends XRXPageFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', 'Frontend.View');
	}
}

?>