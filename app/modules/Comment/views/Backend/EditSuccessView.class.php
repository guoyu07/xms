<?php

class Comment_Backend_EditSuccessView extends XRXCommentBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('_title', 'Backend.Edit');
	}
}

?>