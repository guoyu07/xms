<?php

class News_Backend_IndexSuccessView extends XRXNewsBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', $this->tm->_('news list', '.news'));
	}
}

?>