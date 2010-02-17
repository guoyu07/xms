<?php

class Page_Frontend_IndexSuccessView extends XRXPageFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$page = &$this->getAttribute('page');
		$page = $page[$this->getAttribute('_language')];

		$this->setAttribute('_title', $page->title);
	}
}

?>