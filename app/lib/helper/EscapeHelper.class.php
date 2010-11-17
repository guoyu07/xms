<?php

/**
 * Helper class
 * Escapes special chars on passed value.
 *
 * @author Khashayar Hajian <me@khashayar.me>
 * 
 */
class EscapeHelper extends XRXHelper
{
    public function escape($text)
	{
		return htmlspecialchars($text, ENT_COMPAT, 'UTF-8');
	}
}

?>