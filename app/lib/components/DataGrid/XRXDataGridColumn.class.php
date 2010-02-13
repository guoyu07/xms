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

class XRXDataGridColumn
{
	/**
	 * {String} align (optional) Set the CSS text-align property of the column.
	 */
	protected $align = null;

	/**
	 * {String} dataIndex (required) The name of the field in the grid's store's
     * record definition from which to draw the column's value.
	 */
	protected $dataIndex = null;

	/**
	 * (String) header (optional) The header text to be used as innerHTML
     * (html tags are accepted) to display in the Grid view.
	 */
	protected $header = null;

	/**
	 * {Boolean} hidden (optional) true to hide the column.
	 */
	protected $hidden = false;
	

	public function  __construct(array $config)
	{
		$this->align		= $config['align'];
		$this->dataIndex	= $config['dataIndex'];
		$this->header		= $config['header'];
		$this->hidden		= $config['hidden'];


		if (empty ($this->dataIndex)) {
			throw new AgaviException("dataIndex should be specified in column's config");
		}
	}

	public function getAlign()
	{
		return $this->align;
	}

	public function getDataIndex()
	{
		return $this->dataIndex;
	}

	public function getHeader()
	{
		return $this->header;
	}

	public function isHidden()
	{
		return $this->hidden;
	}

}
?>
