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

		// Set title
		$this->setAttribute('_title', sprintf($this->tm->_('view news: %s', '.news'), $news->title));
	}
}

?>