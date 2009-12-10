<?php

class News_NewsModel extends XRXNewsBaseModel
{
	private $id;
	private $date;
	private $modified;
	private $published;
	private $comment_status;
	private $image;
	private $author_id;
	private $category_id;



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

	public function getDate()
	{
		return $this->date;
	}

	public function setDate($date)
	{
		$this->date = $date;
	}

	public function getModified()
	{
		return $this->modified;
	}

	public function setModified($modified)
	{
		$this->modified = $modified;
	}

	public function getPublished()
	{
		return $this->published;
	}

	public function setPublished($published)
	{
		$this->published = $published;
	}

	public function getCommentStatus()
	{
		return $this->comment_status;
	}

	public function setCommentStatus($comment_status)
	{
		$this->comment_status = $comment_status;
	}

	public function getImage()
	{
		return $this->image;
	}

	public function setImage($image)
	{
		$this->image = $image;
	}

	public function getAuthorId()
	{
		return $this->author_id;
	}

	public function setAuthorId($author_id)
	{
		$this->author_id = $author_id;
	}

	public function getCategoryId()
	{
		return $this->category_id;
	}

	public function setCategoryId($category_id)
	{
		$this->category_id = $category_id;
	}

	public function fromArray(array $data)
	{
		$this->setId($data['id']);
		$this->setDate($data['date']);
		$this->setModified($data['modified']);
		$this->setPublished($data['published']);
		$this->setCommentStatus($data['comment_status']);
		$this->setImage($data['image']);
		$this->setAuthorId($data['author_id']);
		$this->setCategoryId($data['category_id']);
	}

	public function toArray()
	{
		$data = array();
		$data['id']				= $this->getId();
		$data['date']			= $this->getDate();
		$data['modified']		= $this->getModified();
		$data['published']		= $this->getPublished();
		$data['comment_status']	= $this->getCommentStatus();
		$data['image']			= $this->getImage();
		$data['author_id']		= $this->getAuthorId();
		$data['category_id']	= $this->getCategoryId();

		return $data;
	}
}

?>