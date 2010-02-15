<?php

class Page_PageModel extends XRXPageBaseModel
{
	private $id;
	private $published;
	private $author_id;



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

	public function getPublished()
	{
		return $this->published;
	}

	public function setPublished($published)
	{
		$this->published = $published;
	}

	public function getAuthorId()
	{
		return $this->author_id;
	}

	public function setAuthorId($author_id)
	{
		$this->author_id = $author_id;
	}

	public function fromArray(array $data)
	{
		$this->setId($data['id']);
		$this->setPublished($data['published']);
		$this->setAuthorId($data['author_id']);
	}

	public function toArray()
	{
		$data = array();
		$data['id']			= $this->getId();
		$data['published']	= $this->getPublished();
		$data['author_id']	= $this->getAuthorId();

		return $data;
	}
}

?>