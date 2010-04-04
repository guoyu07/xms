<?php

/**
 * Template layer implementation for templates fetched using a PHP stream.
 *
 * @author     Khashayar Hajian <me@khashayar.me>
 * @copyright  Authors
 * @copyright  The XRX Project
 */
class XRXFileTemplateLayer extends AgaviFileTemplateLayer
{
	/**
	 * Constructor.
	 *
	 * @param      array Initial parameters.
	 *
	 * @author     Khashayar Hajian <me@khashayar.me>
	 */
	public function __construct(array $parameters = array())
	{
		$targets = array();
		if(AgaviConfig::get('core.use_translation')) {
			$targets[] = AgaviConfig::get('core.template_dir') . '/templates/${module}/${locale}/${template}${extension}';
			$targets[] = AgaviConfig::get('core.template_dir') . '/templates/${module}/${template}.${locale}${extension}';
			$targets[] = '${directory}/${locale}/${template}${extension}';
			$targets[] = '${directory}/${template}.${locale}${extension}';
		}
		$targets[] = AgaviConfig::get('core.template_dir') . '/templates/${module}/${template}${extension}';
		$targets[] = '${directory}/${template}${extension}';
		
		parent::__construct(array_merge(array(
			'directory' => AgaviConfig::get('core.module_dir') . '/${module}/templates',
			'scheme' => 'file',
			'check' => true,
			'targets' => $targets,
		), $parameters));
	}
}

?>