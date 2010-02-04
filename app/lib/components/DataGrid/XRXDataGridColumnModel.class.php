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

class XRXDataGridColumnModel
{
	const DATE		= 'date';
	const NUMBER	= 'number';
	const CURRENCY	= 'currency';
	const TEMPLATE	= 'template';

	private $columns = array();


	public function  __construct(array $config)
	{
		if (isset ( $config['columns'] )) {
			$columns	= $config['columns'];
			$defaults	= $config['defaults'];
		} else {
			$columns = $config;
		}

		$this->setConfig($columns, $defaults);
	}

	public function setConfig($columns, $defaults)
	{
		// Apply Defaults
		if (empty ($defaults)) {
			$defaults = array();
		}

		// Make sure Defaults passed as array
		if (is_array($defaults)) {

			foreach ($columns as $column) {
				// Apply without overwriting values
				$column += $defaults;

				switch ($column['type']) {
					case self::DATE:
						$class = 'XRXDataGridDateColumn';
						break;

					case self::NUMBER:
						$class = 'XRXDataGridNumberColumn';
						break;

					case self::CURRENCY:
						$class = 'XRXDataGridCurrencyColumn';
						break;

					case self::TEMPLATE:
						$class = 'XRXDataGridTemplateColumn';
						break;

					default:
						$class = 'XRXDataGridColumn';
				}

				$this->columns[] = new $class($column);
			}

		} else {
			throw new AgaviException("defaults should be type of array.");
		}
	}

	public function getColumns()
	{
		return $this->columns;
	}
}
?>
