<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dataGridclass
 *
 * @author Administrator
 */

class XRXDataGrid
{
	private $url = null;

	private $data = null;

	private $colModel = null;


	public function  __construct(array $config)
	{
		$this->url		= $config['url'];
		$this->data		= $config['data'];
		$this->colModel = new XRXDataGridColumnModel($config);
	}

	public function  __toString() {
		$thead = "";
		$tbody = "<table width='100%'>";

		foreach ($this->data as $data) {
			$tbody .= "<tr>";

			foreach ($this->colModel->getColumns() as $column) {
				$dataIndex = $column->getDataIndex();
				
				$tbody .= "<td>" . $data->$dataIndex . "</td>";
			}

			$tbody .= "</tr>";
		}
		
		$tbody .= "</table>";
		
		return $tbody;
	}

}
?>
