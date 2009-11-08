<?php

class Category_CategoryModel extends XRXCategoryBaseModel
{
	private $id;
	private $name;
	private $description;
	private $path;
	private $parent_id;



	public function __construct(array $data = null)
	{
		if (!empty($data)) {
			$this->fromArray($data);
		}
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function setDescription($description)
	{
		$this->description = $description;
	}

	public function getPath()
	{
		return $this->path;
	}

	public function setPath($path)
	{
		$this->path = $path;
	}

	public function getParentId()
	{
		return $this->parent_id;
	}

	public function setParentId($parent_id)
	{
		$this->parent_id = $parent_id;
	}

	public function fromArray(array $data)
	{
		$this->setId($data['id']);
		$this->setName($data['name']);
		$this->setDescription($data['description']);
		$this->setPath($data['path']);
		$this->setParentId($data['parent_id']);
	}

	public function toArray()
	{
		$data = array();
		$data['id']				= $this->getId();
		$data['name']			= $this->getName();
		$data['description']	= $this->getDescription();
		$data['path']			= $this->getPath();
		$data['parent_id']		= $this->getParentId();

		return $data;
	}
}

?>