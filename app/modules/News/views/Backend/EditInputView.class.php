<?php

class News_Backend_EditInputView extends XRXNewsBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$news	 = $this->getAttribute('news');
		$current = $this->tm->getCurrentLocaleIdentifier();
		$locales = $this->tm->getAvailableLocales();
		$language = $this->getAttribute('_language');


		// Prepare locales
		$availableLocales = array();
		
		foreach ($locales as $locale) {
			$t = new stdClass();
			$t->id		= $locale['identifier'];
			$t->lang	= $locale['identifierData']['language'];
			$t->desc	= $locale['parameters']['description'];
			$t->dir		= ($this->tm->getLocale($locale['identifier'])->getCharacterOrientation() == 'left-to-right') ? 'ltr' : 'rtl';

			// Make sure current language is on top of the stack
			if ($current == $t->id) {
				$availableLocales = array_merge(array($t), $availableLocales);
			} else {
				// If other languages has translation for this news
				if (isset ($news[$t->lang])) {
					$t->translated = true;
				}

				$availableLocales[] = $t;
			}
		}


		$this->setAttribute('currentLocale', $current);
		$this->setAttribute('locales', $availableLocales);


		// Set Title
		$this->setAttribute('_title', $this->tm->_('edit news', '.news'));

		$this->appendAttribute("_scripts", "/scripts/CKEditor/ckeditor.js");
		$this->appendAttribute("_scripts", "/scripts/CKFinder/ckfinder.js");
	}
}

?>