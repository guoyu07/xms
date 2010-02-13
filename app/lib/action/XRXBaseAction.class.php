<?php

/**
 * The base action from which all project actions inherit.
 */
class XRXBaseAction extends AgaviAction
{
	/**
	 * @var        AgaviRouting
	 */
	protected $ro;

	/**
	 * @var        AgaviRequest
	 */
	protected $rq;

	/**
	 * @var        AgaviTranslationManager
	 */
	protected $tm;

	/**
	 * @var        AgaviUser
	 */
	protected $us;


	/**
	 * Initialize this action.
	 *
	 * @param      AgaviExecutionContainer This Action's execution container.
	 *
	 * @author     David ZÃ¼lke <dz@bitxtender.com>
	 * @since      0.9.0
	 */
	public function initialize(AgaviExecutionContainer $container)
	{
		parent::initialize($container);

		// Handy Shortcuts
		$this->ro = $this->getContext()->getRouting();
		$this->rq = $this->getContext()->getRequest();
		$this->tm = $this->getContext()->getTranslationManager();
		$this->us = $this->getContext()->getUser();
	}
}

?>