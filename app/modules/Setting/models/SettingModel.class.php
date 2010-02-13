<?php

class Setting_SettingModel extends XRXSettingBaseModel
{
	private $name;
	private $value;
	private $module;



	public function __construct(array $data = null)
	{
		if (! empty($data)) {
			$this->fromArray($data);
		}
	}

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function getValue()
	{
		return $this->value;
	}

	public function setValue($value)
	{
		$this->value = $value;
	}

	public function getModule()
	{
		return $this->module;
	}

	public function setModule($module)
	{
		$this->module = $module;
	}

	public function fromArray(array $data)
	{
		$this->setName($data['name']);
		$this->setValue($data['value']);
		$this->setModule($data['module']);
	}

	public function toArray()
	{
		$data = array();
		$data['name']		= $this->getName();
		$data['value']		= $this->getValue();
		$data['module']		= $this->getModule();

		return $data;
	}
}

?>