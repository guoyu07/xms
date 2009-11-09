<?php

class News_Frontend_IndexSuccessView extends XRXNewsFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', $this->tm->_('lastest news', '.news'));
	}
}

?>