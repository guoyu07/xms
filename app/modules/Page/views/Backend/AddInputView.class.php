<?php

class Page_Backend_AddInputView extends XRXPageBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);


		// Prepare locales
		$current = $this->tm->getCurrentLocaleIdentifier();
		$locales = $this->tm->getAvailableLocales();


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
				$availableLocales[] = $t;
			}
		}

		$this->setAttribute('currentLocale', $current);
		$this->setAttribute('locales', $availableLocales);


		// Set Title
		$this->setAttribute('_title', $this->tm->_('add page', '.page'));

		// Append Scripts
		$this->appendAttribute("_scripts", "/scripts/CKEditor/ckeditor.js");
		$this->appendAttribute("_scripts", "/scripts/CKFinder/ckfinder.js");
	}
}

?>