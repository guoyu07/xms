<?php

class XRXBrowser
{
	/**
	 * @var        User Agent
	 */
	protected $userAgent;

	/**
	 * @var        Opera
	 */
	protected $isOpera;

	/**
	 * @var        Chrome
	 */
	protected $isChrome;

	/**
	 * @var        Webkit
	 */
	protected $isWebkit;

	/**
	 * @var        Safari
	 */
	protected $isSafari;

	/**
	 * @var        Safari 3
	 */
	protected $isSafari3;

	/**
	 * @var        Safari 4
	 */
	protected $isSafari4;

	/**
	 * @var        Internet Explorer
	 */
	protected $isIE;

	/**
	 * @var        Internet Explorer 6
	 */
	protected $isIE6;

	/**
	 * @var        Internet Explorer 7
	 */
	protected $isIE7;

	/**
	 * @var        Internet Explorer 8
	 */
	protected $isIE8;

	/**
	 * @var        Gecko
	 */
	protected $isGecko;

	/**
	 * @var        Gecko 3
	 */
	protected $isGecko3;

	/**
	 * @var        Windows
	 */
	protected $isWindows;

	/**
	 * @var        Mac
	 */
	protected $isMac;

	/**
	 * @var        Linux
	 */
	protected $isLinux;


	public function __construct($user_agent) {
        $this->userAgent = strtolower($user_agent);

		$this->isOpera	= (bool) preg_match('/opera/', $this->userAgent);
		$this->isChrome	= (bool) preg_match('/chrome/', $this->userAgent);
		$this->isWebKit	= (bool) preg_match('/webkit/', $this->userAgent);
		$this->isSafari	= !$this->isChrome && (bool) preg_match('/safari/', $this->userAgent);
		$this->isSafari3= $this->isSafari && (bool) preg_match('/version\/3/', $this->userAgent);
		$this->isSafari4= $this->isSafari && (bool) preg_match('/version\/4/', $this->userAgent);
		$this->isIE		= !$this->isOpera && (bool) preg_match('/msie/', $this->userAgent);
		$this->isIE7	= $this->isIE && (bool) preg_match('/msie 7/', $this->userAgent);
		$this->isIE8	= $this->isIE && (bool) preg_match('/msie 8/', $this->userAgent);
		$this->isIE6	= $this->isIE && !$this->isIE7 && !$this->isIE8;
		$this->isGecko	= !$this->isWebKit && (bool) preg_match('/gecko/', $this->userAgent);
		$this->isGecko3	= $this->isGecko && (bool) preg_match('/rv:1\.9/', $this->userAgent);
		$this->isWindows= (bool) preg_match('/windows|win32/', $this->userAgent);
		$this->isMac	= (bool) preg_match('/macintosh|mac os x/', $this->userAgent);
		$this->isLinux	= (bool) preg_match('/linux/', $this->userAgent);
    }

	public function __call($name, $arguments) {
        return $this->$name;
    }

}

?>
