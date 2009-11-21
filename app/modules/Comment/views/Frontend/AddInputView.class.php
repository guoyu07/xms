<?php

class Comment_Frontend_AddInputView extends XRXCommentFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		// We normally use comment AddInput as a slot, so store the input URL
		// in the session for a redirect after comment added.
		$this->us->setAttribute('redirect', $this->rq->getUrl(), 'org.agavi.XRX.comment');
		
		$this->setAttribute('_title', $this->tm->_('add comment', '.comment'));
	}
}

?>