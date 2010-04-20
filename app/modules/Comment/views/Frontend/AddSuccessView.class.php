<?php

class Comment_Frontend_AddSuccessView extends XRXCommentFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd, 'redirect');

		// Fetch required data for redirection from session
		$module_id	= $rd->getParameter('module_id');
		$owner_id	= $rd->getParameter('owner_id');
		$params		= $this->us->getAttribute($module_id . $owner_id, 'comment');

		// Oops!
		if (empty ($params)) {

			// Redirect user to main page if there's no data in session.
			$url = $this->ro->gen('index', array(), array('relative'=>false));

		} else {

			$params	= array_merge($params['arguments'], array(
				'module'	=> $params['module_name'],
				'action'	=> str_replace('Frontend/', '', $params['action_name'])
			));

			// Generate url based on data on session
			$url = $this->ro->gen('default', $params, array('relative'=>false));

		}

		
		// Set original request URL redirect
		$this->setAttribute('_url', strtolower($url));
		$this->setAttribute('_type', 'success');
		$this->setAttribute('_title', $this->tm->_('redirecting...', '.comment'));
	}

	public function executeJson(AgaviRequestDataHolder $rd)
	{
		$comment = $this->getAttribute('comment');
		$align	 = $this->getAttribute('_align');
		$content = '
			<li id="xrx-comment-%1$s">
				<div class="xrx-comment-credential xrx-%2$s">
					<cite>
						<strong>
							<a target="_blank" title="http://ko-em.org" href="http://ko-em.org">%3$s</a>
						</strong>
						<br>%4$s
					</cite>
				</div>
				<div class="xrx-comment-text">
				<blockquote>%5$s</blockquote>
				</div>
				<div class="xrx-clear"></div>
			</li>';

		$data = array(
			'alert'		=> $this->tm->_('comment sucessfully submitted', '.comment'),
			'content'	=> sprintf($content, $comment->getId(), $align, $comment->getAuthorName(), $this->tm->_d($comment->getDate()), $comment->getContent()),
			'ctTarget'	=> '#xrx-comments-list ul',
			'location'	=> 'child:last'
		);

		return $data;
	}
}

?>