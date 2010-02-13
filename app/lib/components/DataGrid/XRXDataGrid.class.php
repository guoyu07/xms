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
		$thead = "<thead><tr>";
		$tbody = "<tbody>";

		foreach ($this->data as $idx => $data) {
			$tbody .= "<tr>";

			foreach ($this->colModel->getColumns() as $column) {
				if ($idx == 0) {
					$thead .= "<th>" . $column->getHeader() . "</th>";
				}
				
				$tbody .= "<td>" . $column->getDataIndex() . "</td>";
			}

			$tbody .= "</tr>";
		}

		$thead .= "</tr></thead>";
		$tbody .= "</tbody>";
		$table  = "<table class='xrx-table-list'>$thead$tbody</table>";

		return $table;
	}

}
?>
