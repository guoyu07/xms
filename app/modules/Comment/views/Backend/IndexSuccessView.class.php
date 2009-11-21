<?php

class Comment_Backend_IndexSuccessView extends XRXCommentBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', 'Backend.Index');
	}
}

?>