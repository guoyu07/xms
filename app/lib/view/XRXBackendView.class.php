<?php

/**
 * The backend view from which all project backend views inherit.
 */
class XRXBackendView extends XRXBaseView
{
	/**
	 * Prepares the HTML output type.
	 *
	 * @param      AgaviRequestDataHolder The request data associated with
	 *                                    this execution.
	 * @param      string The layout to load.
	 */
	public function setupHtml(AgaviRequestDataHolder $rd, $layoutName = null)
	{
		if($layoutName === null && $this->getContainer()->getParameter('is_slot', false)) {
			// it is a slot, so we do not load the default layout, but a different one
			// otherwise, we could end up with an infinite loop
			$layoutName = self::SLOT_LAYOUT_NAME;
		}

		if ($layoutName === null) {
			$layoutName = "backend";
		}

		// now load the layout
		// this method returns an array containing the parameters that were declared on the layout (not on a layer!) in output_types.xml
		// you could use this, for instance, to automatically set a bunch of CSS or Javascript includes based on layout parameters -->
		$this->loadLayout($layoutName);
	}
}

?>