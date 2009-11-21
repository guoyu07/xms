<?php

class Comment_CommentModel extends XRXCommentBaseModel
{
	private $id;
	private $owner_id;
	private $module_id;
	private $content;
	private $date;
	private $status;
	private $author_id;
	private $author_name;
	private $author_email;
	private $author_url;



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

	public function getOwnerId()
	{
		return $this->owner_id;
	}

	public function setOwnerId($owner_id)
	{
		$this->owner_id = $owner_id;
	}

	public function getModuleId()
	{
		return $this->module_id;
	}

	public function setModuleId($module_id)
	{
		$this->module_id = $module_id;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function setContent($content)
	{
		$this->content = $content;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function setStatus($status)
	{
		$this->status = $status;
	}

	public function getDate()
	{
		return $this->date;
	}

	public function setDate($date)
	{
		$this->date = $date;
	}

	public function getAuthorId()
	{
		return $this->author_id;
	}

	public function setAuthorId($author_id)
	{
		$this->author_id = $author_id;
	}

	public function getAuthorName()
	{
		return $this->author_name;
	}

	public function setAuthorName($author_name)
	{
		$this->author_name = $author_name;
	}

	public function getAuthorEmail()
	{
		return $this->author_email;
	}

	public function setAuthorEmail($author_email)
	{
		$this->author_email = $author_email;
	}

	public function getAuthorUrl()
	{
		return $this->author_url;
	}

	public function setAuthorUrl($author_url)
	{
		$this->author_url = $author_url;
	}

	public function fromArray(array $data)
	{
		$this->setId($data['id']);
		$this->setOwnerId($data['owner_id']);
		$this->setModuleId($data['module_id']);
		$this->setContent($data['content']);
		$this->setDate($data['date']);
		$this->setStatus($data['status']);
		$this->setAuthorId($data['author_id']);
		$this->setAuthorName($data['author_name']);
		$this->setAuthorEmail($data['author_email']);
		$this->setAuthorUrl($data['author_url']);
	}

	public function toArray()
	{
		$data = array();
		$data['id']				= $this->getId();
		$data['owner_id']		= $this->getOwnerId();
		$data['module_id']		= $this->getModuleId();
		$data['content']		= $this->getContent();
		$data['date']			= $this->getDate();
		$data['status']			= $this->getStatus();
		$data['author_id']		= $this->getAuthorId();
		$data['author_name']	= $this->getAuthorName();
		$data['author_email']	= $this->getAuthorEmail();
		$data['author_url']		= $this->getAuthorUrl();

		return $data;
	}
}

?>