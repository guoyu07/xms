<?php

class News_Frontend_IndexSuccessView extends XRXNewsFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		// If news has an image, pass the 60x60 pixel thumbnail to template
		foreach ($this->getAttribute('news') as $n) {
			if (isset ($n->image)) {
				$n->image = str_replace('.', '_60.', $n->image);
			}
		}

		$this->setAttribute('_title', $this->tm->_('lastest news', '.news'));
	}
}

?>