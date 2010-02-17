<?php

class Setting_Backend_IndexInputView extends XRXSettingBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);


		// Modules can be shown on front page
		$modules = array('News');

		
		// Get all available locales
		foreach ($this->tm->getAvailableLocales() as $locale) {
			$locales[] = $locale['identifierData']['language'];
		}


		// Retrieve all pages
		$pages	= $this->getContext()->getModel('PageManager', 'Page')->retrieveAll();
		$ids	= array();
		$titles	= array();
		$pps	= array();

		
		// Search if there's any pages with translation for all enable locales.
		foreach ($pages as $page) {
			$ids[$page->id][] = $page->language;
			$titles[$page->id][$page->language] = $page->title;

			// Let's check if this page has all translations
			if ($ids[$page->id] == $locales) {
				$pps[$page->id]	= $titles[$page->id][$this->getAttribute('_language')];
			}
		}

		if (count($pps) == 0) {
			$pps[0] = 0;
		} else {
			$modules[]	= 'Page';
		}


		$this->setAttribute('modules', $modules);
		$this->setAttribute('pages', $pps);
		$this->setAttribute('_title', $this->tm->_('settings', '.setting'));
	}
}

?>