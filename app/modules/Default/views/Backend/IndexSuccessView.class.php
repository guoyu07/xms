<?php

class Default_Backend_IndexSuccessView extends XRXDefaultBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', $this->tm->_('Dashboard', '.default'));

		$this->paginator()->setRecordPerPage(2);
		$this->paginator()->setTotalRecords(29);
	}
}

?>