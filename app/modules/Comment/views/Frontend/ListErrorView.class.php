<?php

class Comment_Frontend_ListErrorView extends XRXCommentFrontendView
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