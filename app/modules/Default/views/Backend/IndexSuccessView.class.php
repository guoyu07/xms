<?php

class Default_Backend_IndexSuccessView extends XRXDefaultBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', $this->tm->_('Dashboard', '.default'));

		$this->paginator()->setTotalRecords(131);
	}
}

?>