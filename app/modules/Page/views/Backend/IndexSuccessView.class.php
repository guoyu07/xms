<?php

class Page_Backend_IndexSuccessView extends XRXPageBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', $this->tm->_('pages list', '.page'));
	}
}

?>