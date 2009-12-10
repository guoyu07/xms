<?php

class News_Frontend_IndexSuccessView extends XRXNewsFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		if ($this->getAttribute('news')) {
			foreach ($this->getAttribute('news') as $n) {
				// If news has an image, pass the 60x60 pixel thumbnail to template
				if (isset ($n->image)) {
					$n->image = str_replace('.', '_60.', $n->image);
				}
			}
		};



		// Create a Slot to view categories
		$layer = $this->getLayer('content');
		$layer->setSlot('categories',
			$this->createSlotContainer('Category', 'Frontend.List', array(
				'module_id'	=> AgaviConfig::get('modules.news.id')
			))
		);

		$this->setAttribute('_title', $this->tm->_('lastest news', '.news'));
	}
}

?>