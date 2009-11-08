<?php

class Category_Backend_AddInputView extends XRXCategoryBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', $this->tm->_('add category', '.category'));
	}
}

?>