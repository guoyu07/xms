<?php

class Comment_Frontend_ListSuccessView extends XRXCommentFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', $this->tm->_('list comments', '.comment'));
	}
}

?>