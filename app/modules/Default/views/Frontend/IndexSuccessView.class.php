<?php

class Default_Frontend_IndexSuccessView extends XRXDefaultFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$frontPage = $this->us->getAttribute('show_on_front', 'setting.general');
		
		if ( $frontPage == 'page' ) {
			$params = array(
				'id'		=> $this->us->getAttribute('show_on_front_id', 'setting.general'),
				'frontpage'	=> true
			);
			
			return $this->createForwardContainer('Page', 'Frontend.Index', $params, null, 'read');
		}

		// Default is News Module
		return $this->createForwardContainer('News', 'Frontend.Index', $rd, null, 'read');
	}
}

?>