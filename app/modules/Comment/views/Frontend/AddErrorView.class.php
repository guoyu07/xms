<?php

class Comment_Frontend_AddErrorView extends XRXCommentFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('message', $this->tm->_('insufficient arguments', '.comment'));
	}
}

?>