<?php

class News_NewsI18nModel extends XRXNewsBaseModel
{
	const TABLE = "news_i18n";

	private $news_id;
	private $title;
	private $summary;
	private $content;
	private $language;



	public function __construct(array $data = null)
	{
		if(!empty($data)) {
			$this->fromArray($data);
		}
	}

	public function getNewsId()
	{
		return $this->news_id;
	}

	public function setNewsId($news_id)
	{
		$this->news_id = $news_id;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function getSummary()
	{
		return $this->summary;
	}

	public function setSummary($summary)
	{
		$this->summary = $summary;
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
		$this->setNewsId($data['news_id']);
		$this->setTitle($data['title']);
		$this->setSummary($data['summary']);
		$this->setContent($data['content']);
		$this->setLanguage($data['language']);
	}

	public function toArray()
	{
		$data = array();
		$data['news_id']	= $this->getNewsId();
		$data['title']		= $this->getTitle();
		$data['summary']	= $this->getSummary();
		$data['content']	= $this->getContent();
		$data['language']	= $this->getLanguage();

		return $data;
	}
}

?>