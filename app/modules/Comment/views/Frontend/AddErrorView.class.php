<?php

class Comment_Frontend_AddErrorView extends XRXCommentFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);
		
		if ( $this->getContainer()->getRequestMethod() == 'read' ) {
			$this->setAttribute('message', $this->tm->_('insufficient arguments', '.comment'));
		} else {
			// Set Validation Report for FPF to see the errors in new container
			$report = $this->getContainer()->getValidationManager()->getReport();
			$this->rq->setAttribute('validation_report', $report, 'org.agavi.filter.FormPopulationFilter');


			// Display Comment's AddInput as a slot in the owner's page when error happened
			return $this->createForwardContainer(
				'News',
				'Frontend.View',
				array('id' => $this->getAttribute('owner_id')),
				null,
				'read'
			);
		}
	}
}

?>