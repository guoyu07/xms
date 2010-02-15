<?php

class Page_Backend_AddErrorView extends XRXPageBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', 'Backend.Add');
	}
}

?>