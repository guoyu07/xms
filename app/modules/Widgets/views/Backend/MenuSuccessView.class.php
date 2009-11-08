<?php

class Widgets_Backend_MenuSuccessView extends XRXWidgetsBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		// Path to search for each module's "menu.xml" if there's any
		$parts		= array(AgaviConfig::get('core.module_dir'), "*", "config", "menu.xml");
		$files		= glob( implode(DIRECTORY_SEPARATOR, $parts) );
		$menuList	= array();
		
		foreach ($files as $file) {
			// Leave it if it's not readable
			if (! is_readable($file)) {
				continue;
			}

			include(AgaviConfigCache::checkConfig($file));

			// Consider Menu's index
			if (isset ($menu[0]['index'])) {
				if (array_key_exists($menu[0]['index'], $menuList)) {
					throw new AgaviException(sprintf('Menu index has been overriden in %s', $file));
				}

				$menuList[$menu[0]['index']] = $menu[0];
			} else {
				$menuList[] = $menu[0];
			}
		}
		
		// Sort Menus by their index
		ksort($menuList);
		
		$this->setAttribute('menu', $menuList);
	}
}

?>