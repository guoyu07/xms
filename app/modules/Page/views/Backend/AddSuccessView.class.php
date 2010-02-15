<?php

class Page_Backend_AddSuccessView extends XRXPageBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd, 'redirect');

		$this->setAttribute('_url', $this->ro->gen('default', array('path' => 'admin/page')));
		$this->setAttribute('_type', 'success');
		$this->setAttribute('_title', $this->tm->_('page added successfully', '.page'));
	}
}

?>