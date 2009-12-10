<?php

/**
 * The base view from which all project views inherit.
 */
class XRXBaseView extends AgaviView
{
	const SLOT_LAYOUT_NAME = 'slot';

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
	 * @var bool
	 */
	protected $isSlot = false;

	/**
	 * Initialize this view.
	 *
	 * @param      AgaviExecutionContainer This View's execution container.
	 */
	public function initialize(AgaviExecutionContainer $container)
	{
		parent::initialize($container);

		// Handy Shortcuts
		$this->ro = $this->getContext()->getRouting();
		$this->rq = $this->getContext()->getRequest();
		$this->tm = $this->getContext()->getTranslationManager();
		$this->us = $this->getContext()->getUser();

		$this->isSlot = $container->hasParameter('is_slot');

		// Pass Info About Page Align & Direction
		list($dir, $align, $xalign) = ($this->tm->getCurrentLocale()->getCharacterOrientation() == 'right-to-left')
										? array('rtl', 'right', 'left')
										: array('ltr', 'left', 'right');

		$this->setAttribute('_dir', $dir);
		$this->setAttribute('_align', $align);
		$this->setAttribute('_xalign', $xalign);
		$this->setAttribute('_language', $this->tm->getCurrentLocale()->getLocaleLanguage());
	}

	/**
	 * Handles output types that are not handled elsewhere in the view. The
	 * default behavior is to simply throw an exception.
	 *
	 * @param      AgaviRequestDataHolder The request data associated with
	 *                                    this execution.
	 *
	 * @throws     AgaviViewException if the output type is not handled.
	 */
	public final function execute(AgaviRequestDataHolder $rd)
	{
		throw new AgaviViewException(sprintf(
			'The view "%1$s" does not implement an "execute%3$s()" method to serve '.
			'the output type "%2$s", and the base view "%4$s" does not implement an '.
			'"execute%3$s()" method to handle this situation.',
			get_class($this),
			$this->container->getOutputType()->getName(),
			ucfirst(strtolower($this->container->getOutputType()->getName())),
			get_class()
		));
	}

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

		// now load the layout
		// this method returns an array containing the parameters that were declared on the layout (not on a layer!) in output_types.xml
		// you could use this, for instance, to automatically set a bunch of CSS or Javascript includes based on layout parameters -->
		$this->loadLayout($layoutName);
	}
}

?>