<?php

class XRXBrowserFilter extends AgaviFilter implements AgaviIActionFilter
{
	/**
	 * Execute this filter.
	 *
	 * @param      AgaviFilterChain        The filter chain.
	 * @param      AgaviExecutionContainer The current execution container.
	 *
	 * @throws     <b>AgaviFilterException</b> If an error occurs during execution.
	 *
	 * @author     Khashayar Hajian <me@khashayar.me>
	 */
	public function executeOnce(AgaviFilterChain $filterChain, AgaviExecutionContainer $container)
	{
       	$b = new XRXBrowser($container->getRequestData()->getHeader('User-Agent'));
		
       	if ($b->isIE6() || $b->isIE7()) {
			$container->setNext($container->createExecutionContainer('Default', 'Frontend.Browser'));
       	} else {
			$filterChain->execute($container);
		}
	}
}

?>
