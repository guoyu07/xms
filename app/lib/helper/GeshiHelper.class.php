<?php

/**
 * Helper class
 * Geshi syntax highlighter
 * Search for geshi classes and replace those with styled text.
 *
 * @author Khashayar Hajian <me@khashayar.me>
 *
 */
class GeshiHelper extends XRXHelper
{
    public function geshi($content)
	{
		// <pre class="geshi:php;line_num:false;"> source code </pre>
		// ^START												^STOP
		$codekey = 'geshi';
		$codetag = '<pre class="';
		$fulltag = $codetag . $codekey;
		$START	 = strpos($content, $fulltag) ;
		$langs	 = array();

		while ($START !== false) {
			include_once 'GeSHi/geshi.php';

			// Take tag option string
			$start	= $START+strlen($codetag);
			$stop	= strpos($content, '"', $start) ;
			$tagopt = substr($content, $start, $stop - $start);

			// Parse option string into array
			$options	= $this->str2Arr($tagopt, ';', ':');
			$lang		= $options['geshi'];
			$line_num	= ($options['line_num'] != 'false');

			// Look for source code
			$start = 1+strpos($content, '>', $start) ;
			$stop  = strpos($content, '</pre>', $start) ;

			// If close tag is not found goto untile EndOfFIle
			if ($stop !== false) {
				$STOP = $stop+strlen('</pre>');
			} else {
				$stop = strlen ($content);
				$STOP = $stop;
			}

			// Get the source code
			$source = substr ($content, $start, $stop - $start) ;
			$source = html_entity_decode($source, ENT_QUOTES);


			if (end($langs) == $lang) {
				if ($line_num == true)
					$geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
				else
					$geshi->enable_line_numbers(GESHI_NO_LINE_NUMBERS);

				// If lang is same of a last code block then recycle geshi obj and css
				$geshi->set_source($source);
			} else {
				// New source language has been found in the content
				// Create a new geshi obj
				$geshi = new GeSHi($source, $lang);

				// And echo the result!
				$geshi->set_header_type(GESHI_HEADER_PRE);
				$geshi->enable_classes();
				$geshi->set_overall_class('xrx-code');


				// MISTAKE: for right formatting, this must be out before outing css
				if ($line_num == true)
					$geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
				else
					$geshi->enable_line_numbers(GESHI_NO_LINE_NUMBERS);

				// Echo out the stylesheet for this code block
				// check if css lang has already loaded
				if (! in_array($lang, $langs)) {
					echo '<style type="text/css"><!--'.
					$geshi->get_stylesheet().
					'--></style>';
				}

				// Stores languase already found in current page
				array_push($langs, $lang);
			}

			$newcode = $geshi->parse_code();
			$content = substr($content, 0, $START) . $newcode . substr($content, $STOP);

			// Search for next loop
			$START = strpos($content, $fulltag) ;
		}
		
		return $content;
	}

	/**
	 * Converts pure string into a trimmed keyed array
	 *
	 * @param  string $string to convert
	 * @param  string $delimiter
	 * @param  string $kv
	 * @return array
	 */
	private function str2Arr($string, $delimiter = ',', $kv = '=>') {
		$a = explode($delimiter, $string);
		if ($a) { // create parts
			foreach ($a as $s) { // each part
				if ($s) {
					$pos = strpos($s, $kv);
					if ($pos) { // key/value delimiter
						$ka[trim(substr($s, 0, $pos))] = trim(substr($s, $pos + strlen($kv)));
					} else { // key delimiter not found
						$ka[] = trim($s);
					}
				}
			}
		return $ka;
		}
	}
}

?>