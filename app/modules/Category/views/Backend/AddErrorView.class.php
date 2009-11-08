<?php

class Category_Backend_AddErrorView extends XRXCategoryBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', 'Backend.Add');
	}
}

?>