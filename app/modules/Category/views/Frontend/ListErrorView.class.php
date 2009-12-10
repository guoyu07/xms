<?php

class Category_Frontend_ListErrorView extends XRXCategoryFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		return $this->createForwardContainer(
			AgaviConfig::get('actions.error404_module'),
			AgaviConfig::get('actions.error404_action')
		);
	}
}

?>