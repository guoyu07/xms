<?php

/**
 * Helper class
 * Escapes passed value and echos it
 *
 * @author Khashayar Hajian <me@khashayar.me>
 * 
 */
class EscapeHelper extends XRXHelper
{
    public function escape($text)
	{
		echo htmlspecialchars($text, ENT_COMPAT, 'UTF-8');
	}
}

?>