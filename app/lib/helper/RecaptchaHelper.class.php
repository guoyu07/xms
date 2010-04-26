<?php

/**
 * Helper class
 * ReCAPTCHA helper. generate reCaptcha content and pass it to caller.
 *
 * @author Khashayar Hajian <me@khashayar.me>
 * 
 */
class RecaptchaHelper extends XRXHelper
{
    /**
     * URI to the regular API
     *
     * @var string
     */
    const API_SERVER = 'http://api.recaptcha.net';

    /**
     * URI to the secure API
     *
     * @var string
     */
    const API_SECURE_SERVER = 'https://api-secure.recaptcha.net';
	
    /**
     * Public key used when displaying the captcha
     *
     * @var string
     */
    protected $publicKey = null;

    /**
     * Private key used when verifying user input
     *
     * @var string
     */
    protected $privateKey = null;

    /**
     * Parameters for the object
     *
     * @var array
     */
    protected $params = array(
        'ssl'	=> false,	/* Use SSL or not when generating the recaptcha */
        'error' => null,	/* The error message to display in the recaptcha */
        'xhtml' => true		/* Enable XHTML output (this will not be XHTML Strict
								compliant since the IFRAME is necessary when
								Javascript is disabled) */
    );

    /**
     * Options for tailoring reCaptcha
     *
     * See the different options on http://recaptcha.net/apidocs/captcha/client.html
     *
     * @var array
     */
    protected $options = array(
        'theme' => 'clean',
        'lang'	=> 'en',
    );


    public function Recaptcha($publicKey = null, $privateKey = null,
							  $params = null, $options = null)
	{
		if (isset ($publicKey)) {
			$this->setPublicKey($publicKey);
		}

		if (isset ($privateKey)) {
			$this->setPrivateKey($privateKey);
		}

        if (isset ($params)) {
            $this->setParams($params);
        }

        if (isset ($options)) {
            $this->setOptions($options);
        }

		return $this;
	}

    /**
     * Set a single parameter
     *
     * @param string $key
     * @param string $value
     * @return RecaptchaHelper
     */
    public function setParam($key, $value)
    {
        $this->params[$key] = $value;

        return $this;
    }

    /**
     * Set parameters
     *
     * @param array $params
     * @return RecaptchaHelper
     * @throws AgaviException
     */
    public function setParams($params)
    {
        if (is_array($params)) {
            foreach ($params as $k => $v) {
                $this->setParam($k, $v);
            }
        } else {
            throw new AgaviException('Expected array');
        }

        return $this;
    }

    /**
     * Get a single parameter
     *
     * @param string $key
     * @return mixed
     */
    public function getParam($key)
    {
        return $this->params[$key];
    }

    /**
     * Get the parameter array
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Set a single option
     *
     * @param string $key
     * @param string $value
     * @return RecaptchaHelper
     */
    public function setOption($key, $value)
    {
        $this->options[$key] = $value;

        return $this;
    }

    /**
     * Set options
     *
     * @param array $options
     * @return RecaptchaHelper
     * @throws AgaviException
     */
    public function setOptions($options)
    {
		if (is_array($options)) {
			foreach ($options as $k => $v) {
				$this->setOption($k, $v);
			}
		} else {
			throw new AgaviException('Expected array');
		}

		return $this;
    }

    /**
     * Get the options array
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Get a single option
     *
     * @param string $key
     * @return mixed
     */
    public function getOption($key)
    {
        return $this->options[$key];
    }

    /**
     * Get the public key
     *
     * @return string
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * Set the public key
     *
     * @param string $publicKey
     * @return RecaptchaHelper
     */
    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;

        return $this;
    }

    /**
     * Get the private key
     *
     * @return string
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * Set the private key
     *
     * @param string $privateKey
     * @return RecaptchaHelper
     */
    public function setPrivateKey($privateKey)
    {
        $this->privateKey = $privateKey;
		
        return $this;
    }

    /**
     * Serialize as string
     *
     * When the instance is used as a string it will display the recaptcha.
     * Since we can't throw exceptions within this method we will trigger
     * a user warning instead.
     *
     * @return string
     */
    public function __toString()
    {
        try {
            $return = $this->getHtml();
        } catch (Exception $e) {
            $return = '';
        }

        return $return;
    }

    /**
     * Get the HTML code for the captcha
     *
     * This method uses the public key to fetch a recaptcha form.
     *
     * @return string
     * @throws Zend_Service_ReCaptcha_Exception
     */
    public function getHtml()
    {
		$user			 = $this->view->getContext()->getUser();
		$this->publicKey = $user->getAttribute('recaptcha_public_key', 'setting.general');
		
        if ($this->publicKey === null) {
            return 'Missing public key';
        }

        $host	= self::API_SERVER;
		$return = '';

        if ($this->params['ssl'] === true) {
            $host = self::API_SECURE_SERVER;
        }

		// Custom Template Handling
		$template = $this->getOption('template');
		if ($this->getOption('theme') == 'custom') {
			if ($template != null && is_readable($template)) {
				// Remove the template from options to prevent it to pass to javascript
				unset ($this->options['template']);
				$return .= file_get_contents($template);
			} else {
				// Rollback to default theme
				$this->setOption('theme', 'clean');
			}
		}

        $htmlBreak = '<br>';
        $htmlInputClosing = '>';

        if ($this->params['xhtml'] === true) {
            $htmlBreak = '<br />';
            $htmlInputClosing = '/>';
        }

        $errorPart = '';

        if (!empty($this->params['error'])) {
            $errorPart = '&error=' . urlencode($this->params['error']);
        }

        $reCaptchaOptions = '';

        if (!empty($this->options)) {
            $encoded = json_encode($this->options);
            $reCaptchaOptions = <<<SCRIPT
<script type="text/javascript">
    var RecaptchaOptions = {$encoded};
</script>
SCRIPT;
        }

        $return .= $reCaptchaOptions;
        $return .= <<<HTML
<script type="text/javascript"
   src="{$host}/challenge?k={$this->publicKey}{$errorPart}">
</script>
HTML;

		$return .= <<<HTML
<noscript>
   <iframe src="{$host}/noscript?k={$this->publicKey}{$errorPart}"
       height="300" width="500" frameborder="0"></iframe>{$htmlBreak}
   <textarea name="recaptcha_challenge_field" rows="3" cols="40">
   </textarea>
   <input type="hidden" name="recaptcha_response_field"
       value="manual_challenge"{$htmlInputClosing}
</noscript>
HTML;

        return $return;
    }
}

?>