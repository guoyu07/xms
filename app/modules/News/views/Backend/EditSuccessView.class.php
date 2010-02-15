<?php

class News_Backend_EditSuccessView extends XRXNewsBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd, 'redirect');

		$this->setAttribute('_url', $this->ro->gen('default', array('path'=>'admin/news')));
		$this->setAttribute('_type', 'success');
		$this->setAttribute('_title', $this->tm->_('redirecting...', '.news'));
	}
}

?>