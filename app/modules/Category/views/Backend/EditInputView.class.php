<?php

class Category_Backend_EditInputView extends XRXCategoryBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', $this->tm->_('edit category', '.category'));
	}
}

?>