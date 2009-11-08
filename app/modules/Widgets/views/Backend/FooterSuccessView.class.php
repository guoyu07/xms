<?php

class Widgets_Backend_FooterSuccessView extends XRXWidgetsBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$this->setAttribute('agavi_plug', AgaviConfig::get('agavi.release'));
	}
}

?>