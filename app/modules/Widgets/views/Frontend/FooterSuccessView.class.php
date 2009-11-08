<?php

class Widgets_Frontend_FooterSuccessView extends XRXWidgetsFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('locales', $this->tm->getAvailableLocales());
		$this->setAttribute('current_locale', $this->tm->getCurrentLocaleIdentifier());
	}
}

?>