<?php

class News_Frontend_IndexErrorView extends XRXNewsFrontendView
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