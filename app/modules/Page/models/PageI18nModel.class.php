<?php

class Page_PageI18nModel extends XRXPageBaseModel
{
	private $page_id;
	private $title;
	private $content;
	private $language;



	public function __construct(array $data = null)
	{
		if(!empty($data)) {
			$this->fromArray($data);
		}
	}

	public function getPageId()
	{
		return $this->page_id;
	}

	public function setPageId($page_id)
	{
		$this->page_id = $page_id;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function setContent($content)
	{
		$this->content = $content;
	}

	public function getLanguage()
	{
		return $this->language;
	}

	public function setLanguage($language)
	{
		$this->language = $language;
	}

	public function fromArray(array $data)
	{
		$this->setPageId($data['page_id']);
		$this->setTitle($data['title']);
		$this->setContent($data['content']);
		$this->setLanguage($data['language']);
	}

	public function toArray()
	{
		$data = array();
		$data['page_id']	= $this->getPageId();
		$data['title']		= $this->getTitle();
		$data['content']	= $this->getContent();
		$data['language']	= $this->getLanguage();

		return $data;
	}
}

?>