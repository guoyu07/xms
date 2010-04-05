<?php

class News_Frontend_IndexSuccessView extends XRXNewsFrontendView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		$this->setupHtml($rd);

		// Create a Slot to view categories
		$layer = $this->getLayer('content');
		$layer->setSlot('categories',
			$this->createSlotContainer('Category', 'Frontend.List', array(
				'module_id'	=> AgaviConfig::get('modules.news.id')
			))
		);

		$this->setAttribute('_title', $this->tm->_('lastest news', '.news'));
	}

	public function executeRss(AgaviRequestDataHolder $rd)
	{
		$entries = array();

		if ($this->getAttribute('news')) {
			foreach ($this->getAttribute('news') as $n) {
				$entries[] = array(
					'title'			=> $n->title,
					'link'			=> $this->ro->gen('default', array('path'=>'news/view', 'id'=>$n->id), array('relative' => false)), //required
					'lastUpdate'	=> $n->modified,
					'charset'		=> 'UTF-8',
					'published'		=> $n->date,
					'description'	=> $n->summary ? $n->summary : $n->content,
					'content'		=> $n->content,
					'author'		=> $n->author,
					'language'		=> $this->tm->getCurrentLocale()->getLocaleLanguage()
				);
			}
		}

		$data = array(
			'title'			=> $this->tm->_('lastest news', '.news'),
			'link'			=> $this->ro->gen(null, array(), array('relative' => false)),
			'charset'		=> 'UTF-8',
			'lastUpdate'	=> null,
			'published'		=> time(),
			'description'	=> sprintf($this->tm->_('the latest news from %s website', '.news'), $this->us->getAttribute('website_title', 'setting.general')),
			'author'		=> null,
			'language'		=> $this->tm->getCurrentLocale()->getLocaleLanguage(),
			'entries'		=> $entries
		);

		require 'Zend/Feed.php';
		$feed = Zend_Feed::importArray($data, 'rss');

		return $feed->saveXml();
	}
}

?>