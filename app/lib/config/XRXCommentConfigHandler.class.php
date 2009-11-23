<?php

/**
 * XRXCommentConfigHandler reads comment configuration files to fetch each
 * module's table name and field should be present in SQL's join.
 *
 * @author     Khashayar Hajian <me@khashayar.me>
 *
 */

class XRXCommentConfigHandler extends AgaviXmlConfigHandler
{
	const XML_NAMESPACE = 'http://agavi.org/agavi/config/parts/comment/1.0';

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
		$document->setDefaultNamespace(self::XML_NAMESPACE, 'comment');

		// remember the config file path
		$config = $document->documentURI;

		$tables = array();

		foreach ($document->getConfigurationElements() as $cfg) {

			if ($cfg->has('tables')) {
				foreach($cfg->get('tables') as $table) {

					if ($table->has('name'))
						$temp['name']  = $table->get('name')->item(0)->getValue();

					if ($table->has('field'))
						$temp['field'] = $table->get('field')->item(0)->getValue();

					if ($table->has('title'))
						$temp['title'] = $table->get('title')->item(0)->getValue();

					$tables[] = $temp;
				}
			}
		}
		
		$code = '$tables = ' . var_export($tables, true);
		return $this->generate($code, $config);
	}
}

?>
