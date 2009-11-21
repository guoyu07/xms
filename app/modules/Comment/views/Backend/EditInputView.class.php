<?php

class Comment_Backend_EditInputView extends XRXCommentBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', 'Backend.Edit');
	}
}

?>