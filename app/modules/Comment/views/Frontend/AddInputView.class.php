<?php

class Comment_Frontend_AddInputView extends XRXCommentFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$module_id	= $this->getAttribute('module_id');
		$owner_id	= $this->getAttribute('owner_id');

		// Prevent it from overriding a previously added value
		if (! $this->us->getAttribute($module_id . $owner_id, 'comment')) {
			
			$parameters	= array_merge($this->getAttribute('parameters'), array(
				'arguments'	=> array(
					'id'		=> $owner_id
				)
			));

			// We normally use comment AddInput as a slot, so store owner module's
			// info in user's session
			$this->us->setAttribute($module_id . $owner_id, $parameters, 'comment');
		}

		$this->setAttribute('_title', $this->tm->_('add comment', '.comment'));
	}
}

?>