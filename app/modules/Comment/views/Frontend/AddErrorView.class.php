<?php

class Comment_Frontend_AddErrorView extends XRXCommentFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		
		if ( $this->getContainer()->getRequestMethod() == 'read' ) {

			return $this->createForwardContainer(
				AgaviConfig::get('actions.error404_module'),
				AgaviConfig::get('actions.error404_action')
			);

		} else {

			// Set Validation Report for FPF to see the errors in new container
			$report = $this->getContainer()->getValidationManager()->getReport();
			$this->rq->setAttribute('validation_report', $report, 'org.agavi.filter.FormPopulationFilter');


			// Prepare data for forward container
			$module_id	= $this->getAttribute('module_id');
			$owner_id	= $this->getAttribute('owner_id');
			$params		= $this->us->getAttribute($module_id . $owner_id, 'comment');
			
			// Oops!
			if (empty ($params)) {
				// Redirect user to main page if there's no data in session.
				$this->getContainer()->getResponse()->setRedirect( $this->ro->gen('index') );
				return;
			}

			// Display Comment's AddInput as a slot in the owner's page when error happened
			return $this->createForwardContainer(
				$params['module_name'],
				$params['action_name'],
				$params['arguments'],
				null,
				'read'
			);
		}
		
	}
}

?>