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


		// reCaptcha
		$captcha = (boolean) $this->us->getAttribute('use_recaptcha', 'setting.comment');
		if ($captcha) {
			// Template path
			$template = AgaviConfig::get('core.template_dir') .
						DIRECTORY_SEPARATOR . 'templates' .
						DIRECTORY_SEPARATOR . 'reCaptcha.phtml';

			// Set options
			$this->recaptcha()->setOptions(array(
				'theme'					=> 'custom',
				'template'				=> $template,
				'custom_theme_widget'	=> 'recaptcha_widget'
			));
		}
		
		
		$this->setAttribute('captcha', $captcha);
		$this->setAttribute('_title', $this->tm->_('add comment', '.comment'));
	}
}

?>