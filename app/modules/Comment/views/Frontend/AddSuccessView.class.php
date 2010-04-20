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
		$content = '
			<li id="xrx-comment-23">
				<div class="xrx-comment-credential xrx-left">
					<cite>
						<strong>
							<a target="_blank" title="http://ko-em.org" href="http://ko-em.org">Joe</a>
						</strong>
						<br>Monday, April 19, 2010
					</cite>
				</div>
				<div class="xrx-comment-text">
				<blockquote>hi there. whats up?</blockquote>
				</div>
				<div class="xrx-clear"></div>
			</li>';

		$data = array(
			'alert'	=> $this->tm->_('comment sucessfully submitted', '.comment'),
		);

		return $data;
	}
}

?>