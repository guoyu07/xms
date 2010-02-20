<?php

class Widgets_Frontend_HeaderSuccessView extends XRXWidgetsFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		$filters = array('language' => $this->getAttribute('_language'));
		$pages	 = $this->getContext()->getModel('PageManager', 'Page')->retrieveAll( $filters );

		$this->setAttribute('pages', $pages);
		$this->setAttribute('showOnFront', $this->us->getAttribute('show_on_front', 'setting.general'));
		$this->setAttribute('showOnFrontId', $this->us->getAttribute('show_on_front_id', 'setting.general'));
	}
}

?>