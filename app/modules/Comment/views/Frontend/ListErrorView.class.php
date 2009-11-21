<?php

class Comment_Frontend_ListErrorView extends XRXCommentBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', 'Frontend.List');
	}
}

?>