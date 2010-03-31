<?php

class News_Backend_EditInputView extends XRXNewsBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$news	 = $this->getAttribute('news');
		$current = $this->tm->getCurrentLocaleIdentifier();
		$locales = $this->tm->getAvailableLocales();

		
		try {
			// Format the datetime to spicified one for current locale
			$locale	= $this->tm->getCurrentLocale();
			$lang	= $locale->getLocaleLanguage();
			$prefix = 'XRX.dateFormat.';
			
			$format	= new AgaviDateFormat(AgaviConfig::get($prefix . 'db'));
			$cal	= $format->parse($news[$lang]->date, $locale, false);

			$format	= new AgaviDateFormat(AgaviConfig::get($prefix . $lang));
			$news[$lang]->date	= $format->format($cal, $cal->getType(), $locale);
		}
		catch (AgaviException $e) {
			// Error happened cause the datetime format was not correct
			// Ain't need to do anything, cause FPF will handle the rest...
		}


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
		
		
		if (isset ($news[$lang]->image)) {
			$news[$lang]->image = str_replace('.', '_40.', $news[$lang]->image);
		}



		// Set Title
		$this->setAttribute('_title', $this->tm->_('edit news', '.news'));


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
		$this->appendAttribute("_scripts", "/scripts/CKFinder/ckfinder.js");
	}
}

?>