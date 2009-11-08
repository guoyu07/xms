<?php

class Category_Frontend_IndexSuccessView extends XRXCategoryFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', 'Frontend.Index');
	}
}

?>