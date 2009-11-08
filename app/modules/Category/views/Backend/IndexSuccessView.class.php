<?php

class Category_Backend_IndexSuccessView extends XRXCategoryBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', $this->tm->_('category list', '.category'));
	}
}

?>