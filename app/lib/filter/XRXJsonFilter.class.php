<?php

class XRXJsonFilter extends AgaviFilter implements AgaviIGlobalFilter, AgaviIActionFilter
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
		$filterChain->execute($container);

		$response	= $container->getResponse();
		$ot			= $response->getOutputType();

		if (!in_array($ot->getName(), $this->getParameter('output_types'))) {
			return;
		}


		$content	= $response->getContent();
		$method		= $container->getContext()->getRequest()->getMethod();
		$vManager	= $container->getValidationManager();

		// Is there any error on submitted form?
		if ($method == 'write' && $vManager->hasErrors()) {
			// Get dirty fields
			$fields = $vManager->getFailedFields();
			$errors = array();
			
			// Create an array of failed fields and append error messages
			foreach ($fields as $field) {
				$e = $vManager->getFieldErrors($field);
				$m = array();

				foreach ($e as $fe) {
					$m[] = $fe->getMessage();
				}

				$errors[$field] = $m;
			}

			$data = array(
				'status'	=> 'failure',
				'errors'	=> $errors
			);

			// Apply $data on recieved array in case of array messed with
			// error messages & status.
			$data = array_merge((array) $content, $data);
			$response->setContent( json_encode($data) );
			return;
		}


		// For other situations
		$data = array(
			'status'	=> 'success',
			/*
			'message'	=> '',		// Message to show
			'msgTarget'	=> '',		// Target element to show the message in it
			'alert'		=> '',		// Message to alert
			'redirect'	=> ''		// URL to redirect
			'content'	=> ''		// Content to append
			'location'	=> ''		// Location to append content [before, after, child]
			'ctTarget'	=> ''		// Target element to show the content in it
			*/
		);

		$data = array_merge($data, (array) $content);
		$response->setContent( json_encode($data) );
	}
}

?>
