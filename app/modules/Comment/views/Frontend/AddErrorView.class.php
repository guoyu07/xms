<?php

class Comment_Frontend_AddErrorView extends XRXCommentFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		if ( $this->getContainer()->getRequestMethod() == 'read' ) {
			$this->setAttribute('message', $this->tm->_('insufficient arguments', '.comment'));
		} else {
			// Data to forward the container on validation error.
			$data = $this->getAttribute('error');
			FirePHP::getInstance(true)->log($data);
			FirePHP::getInstance(true)->log($this->getAttribute('owner_id'));

			// Set Validation Report for FPF to see the errors in new container
			$report = $this->getContainer()->getValidationManager()->getReport();
			$this->getContext()->getRequest()->setAttribute('validation_report', $report, 'org.agavi.filter.FormPopulationFilter');

			// Display Comment's AddInput as a slot in the owner's page when error happened
			return $this->createForwardContainer(
				$data['module'],
				$data['action'],
				//$data['parameters'],
				array($id=>$this->getAttribute('owner_id')),
				$data['output'],
				$data['method']
			);
		}
	}
}

?>