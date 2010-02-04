<?php

class News_Backend_IndexSuccessView extends XRXNewsBackendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);
		
		$config = array(
			'data'		=> $this->getAttribute('news'),
			'columns'	=> array(
				array(
					'dataIndex'	=> 'title',
					'header'	=> 'Title'
				),
				array(
					'dataIndex'	=> 'category_name',
					'header'	=> 'Category'
				),
				array(
					'dataIndex'	=> 'date',
					'header'	=> 'Date'
				),
				array(
					'dataIndex'	=> 'username',
					'header'	=> 'Author'
				),
				array(
					'dataIndex'	=> 'published',
					'header'	=> 'Published'
				)
			)
		);
		
		$dataGrid = new XRXDataGrid($config);
		
		$this->setAttribute('_title', $this->tm->_('news list', '.news'));
		$this->setAttribute('grid', $dataGrid);
	}
}

?>