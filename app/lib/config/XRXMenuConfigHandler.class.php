<?php

/**
 * XRXMenuConfigHandler reads menu configuration files to fetch each
 * menu items for administration area.
 *
 * @author     Khashayar Hajian <me@khashayar.me>
 *
 */

class XRXMenuConfigHandler extends AgaviXmlConfigHandler
{
	const XML_NAMESPACE = 'http://agavi.org/agavi/config/parts/menu/1.0';

	/**
	 * Execute this configuration handler.
	 *
	 * @param      AgaviXmlConfigDomDocument The document to parse.
	 *
	 * @return     string Data to be written to a cache file.
	 *
	 * @throws     <b>AgaviParseException</b> If a requested configuration file is
	 *                                        improperly formatted.
	 *
	 * @author     Khashayar Hajian <me@khashayar.me>
	 */

	public function execute(AgaviXmlConfigDomDocument $document)
	{
		// set up our default namespace
		$document->setDefaultNamespace(self::XML_NAMESPACE, 'menu');

		// remember the config file path
		$config = $document->documentURI;

		$menu = array();
		
		foreach ($document->getConfigurationElements() as $cfg) {
			$members = $cfg->getChildren('members');
			
			if ($members) {
				foreach ($members as $attribute) {

					if ($attribute->has('title'))
						$title = $attribute->get('title')->item(0)->getValue();

					if ($attribute->has('url'))
						$url = $attribute->get('url')->item(0)->getValue();

					if ($attribute->has('index'))
						$index = $attribute->get('index')->item(0)->getValue();

					if ($attribute->has('icon'))
						$icon = $attribute->get('icon')->item(0)->getValue();

					$temp = array(
						'title'	=> $title,
						'url'	=> $url,
						'index'	=> $index,
						'icon'	=> $icon,
						'items'	=> array()
					);
					
					if ($attribute->has('member')) {
						foreach ($attribute->get('member') as $member) {

							if ($member->has('title'))
								$title = $member->get('title')->item(0)->getValue();

							if ($member->has('url'))
								$url = $member->get('url')->item(0)->getValue();

							$temp[items][] = array(
								'title'	=> $title,
								'url'	=> $url,
								'icon'	=> $icon
							);
						}
					}

					$menu[] = $temp;
				}
			}
		}
		
		$code = '$menu = ' . var_export($menu, true);
		return $this->generate($code, $config);
	}
}

?>
