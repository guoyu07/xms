<?php

class News_Frontend_ViewSuccessView extends XRXNewsFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);
		
		$news = &$this->getAttribute('news');
		$locales = $this->tm->getAvailableLocales();
		$curLang = $this->tm->getCurrentLocale()->getLocaleLanguage();
		$translations = array();
		
		// Detect translations & prepare them for template if there's any
		foreach ($news as $n) {
			if ($curLang != $n->language) {
				$locale = $locales[$this->tm->getLocaleIdentifier($n->language)];
				$translations[] = array(
					'title'	=> $locale['parameters']['description'],
					'link'	=> $this->ro->gen(null, array('locale' => $locale['identifier']))
				);
			}
		}

		// Remove other languages
		$news = $news[$curLang];

		// Translation exists?
		if (count($translations) > 0) {
			$this->setAttribute('translations', $translations);
		}



		$module_name	= $this->getContainer()->getModuleName();
		$module_id		= AgaviConfig::get('modules.' . strtolower($module_name) . '.id');
		$action_name	= $this->getContainer()->getActionName();

		// Create a Slot to view the comments
		$layer = $this->getLayer('content');
		$layer->setSlot('comments',
			$this->createSlotContainer('Comment', 'Frontend.List', array(
				'module_id'	=> $module_id,
				'owner_id'	=> $news->id
			))
		);

		// Create a Slot to view the comments' form
		$layer = $this->getLayer('content');
		$layer->setSlot('comment-form',
			$this->createSlotContainer('Comment', 'Frontend.Add', array(
				'module_id'	=> $module_id,
				'owner_id'	=> $news->id,
				'parameters'=> array(
					'module_name'	=> $module_name,
					'action_name'	=> $action_name
				)
			))
		);
		
		// Set title
		$this->setAttribute('_title', sprintf($this->tm->_('view news: %s', '.news'), $news->title));
	}
}

?>