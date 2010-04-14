<?php

class XRXDefaultRoutingCallback extends AgaviRoutingCallback
{
	public function onMatched(array &$parameters, AgaviExecutionContainer $container)
	{
		$ctrl = $container->getContext()->getController();

		// Remove 'Frontend' from default action name in case of admin area called
		$def_action = array_pop(explode('.', AgaviConfig::get('actions.default_action')));
		$def_module = AgaviConfig::get('actions.default_module');
		$params		= explode('/', strtolower($parameters['path']));
		
		// Format 'Module' & 'Action' names first char to uppercase
//		for ($i = 0; $i < 3; ++$i) {
//			$params[$i] = ucfirst(strtolower($params[$i]));
//		}
		
		// If 'admin' is in uri, then select the next index as module name.
		if ($params[0] == 'admin') {
			$idx = 1;
			$section = 'Backend.';
		}
		else {
			$idx = 0;
			$section = 'Frontend.';
		}

		
		// Set Module Name
		$module	= ($params[$idx]) ? $params[$idx] : $def_module;
		$module = ucfirst($module);

		if ($ctrl->moduleExists($module) == true) {
			// Valid Module Name
			$container->setModuleName($module);
		} else {
			$idx--;
			$container->setModuleName($def_module);
		}

		
		// Set Action Name
		$action	= ($params[$idx + 1]) ? $params[$idx + 1] : $def_action;
		$action = ucfirst($action);

		if ($ctrl->actionExists($module, $section . $action) == true) {
			// Action exists, so add it as action
			$action = $section . $action;
			$container->setActionName($action);
		} else {
			// Action doesn't exists, so assign the default action name as
			// action and update the index value.
			$idx--;
			$action = $section . $def_action;
			$container->setActionName($action);
		}
		

		// Assgin the others as parameters
		for ($i = 2 + $idx; $i < count($params); ++$i) {
			$parameters[strtolower($params[$i])] = $params[++$i];
		}
		
		return true;
	}

	/**
	 * Gets executed when the route of this callback route did not match.
	 *
	 * @param      AgaviExecutionContainer The original execution container.
	 *
	 * @author     Khashayar Hajian <me@khashayar.me>
	 */
	public function onNotMatched(AgaviExecutionContainer $container)
	{
		return false;
	}

	/**
	 * Gets executed when the route of this callback is about to be reverse
	 * generated into an URL.
	 *
	 * @param      array The default parameters stored in the route.
	 * @param      array The parameters the user supplied to AgaviRouting::gen().
	 * @param      array The options the user supplied to AgaviRouting::gen().
	 *
	 * @return     bool  Whether this route part should be generated.
	 *
	 * @author     Khashayar Hajian <me@khashayar.me>
	 */
	public function onGenerate(array $defaultParameters, array &$userParameters, array &$userOptions)
	{
		// If path has not set...
		$userParameters['path'] = isset($userParameters['path']) ?
										$userParameters['path'] :
										new AgaviRoutingValue('');

		// If parameters for module & action passed separately
		if (isset($userParameters['module']) ||
			isset($userParameters['action']))
		{
			// Set Module
			$module = isset($userParameters['module']) ?
							$userParameters['module']->getValue() :
							AgaviConfig::get('actions.default_module');

			// Set Action
			$action = isset($userParameters['action']) ?
							$userParameters['action']->getValue() :
							AgaviConfig::get('actions.default_action');

			$action = array_pop(explode('.', $action));

			// Finish it up
			$userParameters['path']->setValue($module . '/' . $action);

			unset($userParameters['module']);
			unset($userParameters['action']);
		}

		// Search for extra parameters...
		$extraParams = '';
		foreach ($userParameters as $key => $value) {
			if ($key == 'path' || $key == 'locale' || $key == 'page') {
				continue;
			}
			
			if ($key == 'title') {
				$userParameters['title']->setValueNeedsEncoding(true);
				$userParameters['title']->setValue(	str_replace(array(' '), '-', $value->getValue()) );
			}
			
			$extraParams .= "/$key/$value";
		}

		// ... and append them to url
		$path = $userParameters['path']->getValue() . ( (strlen($extraParams) > 1) ? $extraParams : '' );
		
		$userParameters['path']->setValue($path);
		$userParameters['path']->setValueNeedsEncoding(false);

		return true;
	}
}

?>
