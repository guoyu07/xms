<?php

class News_Backend_AddInputView extends XRXNewsBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$language = $this->getAttribute('_language');

		// Calendar attributes
		if ($language == 'fa') {
			// Set client-side calendar as Jalali
			$this->setAttribute('jalali', true);

			// Set client-side calendar date format
			$this->setAttribute('dateFormat', '%Y/%m/%d %H:%M:%S');
		} else {
			// Set client-side calendar date format for the others
			$this->setAttribute('dateFormat', '%m/%d/%Y %H:%M:%S');
		}



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
		$this->setAttribute('_title', $this->tm->_('add news', '.news'));


		// Append Styles
		$this->appendAttribute("_styles", "/scripts/JalaliJSCalendar/skins/calendar-system.css");
		

		// Append Scripts
		if ($this->getAttribute('jalali')) {
			$this->appendAttribute("_scripts", "/scripts/JalaliJSCalendar/jalali.js");
		}
		
		$this->appendAttribute("_scripts", "/scripts/JalaliJSCalendar/calendar.js");
		$this->appendAttribute("_scripts", "/scripts/JalaliJSCalendar/calendar-setup.js");
		$this->appendAttribute("_scripts", "/scripts/JalaliJSCalendar/lang/calendar-$language.js");
		$this->appendAttribute("_scripts", "/scripts/CKEditor/ckeditor.js");
	}
}

?>