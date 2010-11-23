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


		// Retrieve all published pages
		$filters = array('published' => true);
		$pages	 = $this->getContext()->getModel('PageManager', 'Page')->retrieveAll($filters);

		$ids	= array();
		$titles	= array();
		$pps	= array();

		
		// Search if there's any page with translation for all enabled locales.
		if ($pages) {
			foreach ($pages as $page) {
				$ids[$page->id][] = $page->language;
				$titles[$page->id][$page->language] = $page->title;

				// Let's check if this page has all translations
				if ($ids[$page->id] == $locales) {
					$pps[$page->id]	= $titles[$page->id][$this->getAttribute('_language')];
				}
			}
		}

		// If there's no page, just fill the ComboBox with dummy value
		// to prevent the validator to throw an error.
		if (count($pps) == 0) {
			$pps[0] = '-';
		} else {
			$modules[]	= 'Page';
		}


		$this->setAttribute('modules', $modules);
		$this->setAttribute('pages', $pps);
		$this->setAttribute('_title', $this->tm->_('settings', '.setting'));

		$this->appendAttribute("_styles", "/scripts/jQuery/ui/themes/base/ui.all.css");
		$this->appendAttribute("_scripts", "/scripts/jQuery/ui/jquery.ui.core.js");
		$this->appendAttribute("_scripts", "/scripts/jQuery/ui/jquery.ui.widget.js");
		$this->appendAttribute("_scripts", "/scripts/jQuery/ui/jquery.ui.tabs.js");
	}
}

?>