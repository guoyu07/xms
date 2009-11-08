<?php

/**
 * The base action from which all project actions inherit.
 */
class XRXBackendAction extends XRXBaseAction
{
	final public function isSecure()
	{
		return true;
	}
}

?>