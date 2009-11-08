<?php

class Category_Backend_DeleteErrorView extends XRXCategoryBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd, 'redirect');

		// Set error messages for template
		$this->setAttribute('errors', $this->getContainer()->getValidationManager()->getErrorMessages());

		$this->setAttribute('_url', $this->ro->gen('default', array('path' => 'admin/category')));
		$this->setAttribute('_type', 'error');
		$this->setAttribute('_title', $this->tm->_('category delete error', '.category'));
	}
}

?>