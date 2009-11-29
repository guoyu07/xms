<?php

class Comment_Frontend_AddInputView extends XRXCommentFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		// We normally use comment AddInput as a slot, so store the input URL
		// in the form for a redirect after comment added.
		$this->setAttribute('referer', $this->rq->getUrl());
		
		$this->setAttribute('_title', $this->tm->_('add comment', '.comment'));
	}
}

?>