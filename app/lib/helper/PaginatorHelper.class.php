<?php

/**
 * Helper class
 * Creates pagination bar
 *
 * @author Khashayar Hajian <me@khashayar.me>
 * 
 */
class PaginatorHelper extends XRXHelper
{
    /**
     * Number of total pages records
     *
     * @var integer
     */
	private $totalRecords;

    /**
     * Number of local pages (i.e., the number of discrete page numbers
     * that will be displayed, including the current page number)
     *
     * @var integer
     */
	private $recordPerPage = 10;

    /**
     * Template to show the result with
     *
     * @var string
     */
	private $template;

	
    public function paginator($page = null)
	{
		if (empty ($page)) {
			return $this;
		}

		$this->first	= 1;
		$this->current	= $page;
		$this->last		= (integer) ceil($this->totalRecords / $this->recordPerPage);

        // Previous
        if ($this->current - 1 > 0) {
            $this->previous = $this->current - 1;
        }

		// Next
        if ($this->current + 1 <= $this->last) {
            $this->next = $this->current + 1;
        }
		
		// PageRange
		$origPageRange	= $this->recordPerPage;
		$pageRange		= $this->recordPerPage * 2 - 1;

		if ($origPageRange + $this->current - 1 < $pageRange) {
			$pageRange = $origPageRange + $this->current - 1;
		} else if ($origPageRange + $this->current - 1 > $this->totalRecords) {
			$pageRange = $origPageRange + $this->totalRecords - $this->current;
		}
		
		
		
		// Template
		if ($this->current == $this->first) {
			echo "{$this->first} - ";
		} else {
			echo "<a href='#'>{$this->first}</a> - ";
		}

		for ($i = $this->first + 1; $i < $this->last; ++$i) {
			if ($this->current == $i) {
				echo "$i - ";
			} else {

				$url	 = $this->view->getContext()->getRequest()->getUrl();
				$pattern = '/page\/\d*/i';
				$replace = "page/$i";
				
				if ( preg_match($pattern, $url) ) {
					$url = preg_replace($pattern, $replace, $url);
				} else {
					if (substr($url, -1) == '/') {
						$url .= $replace;
					} else {
						$url .= '/' . $replace;
					}
				}
				echo "<a href='$url'>$i</a> - ";
			}
		}

		/*
		// Numbered page links
		foreach ($pageRange as $page) {
			if ($page != $this->current) {
				echo "<a href='$page'>$page</a>";
			} else {
				echo $page;
			}
		}
		*/

		if ($this->current == $this->last) {
			echo "{$this->last}";
		} else {
			echo "<a href='#'>{$this->last}</a>";
		}
	}

	public function setRecordPerPage($recordPerPage)
	{
		$this->recordPerPage = $recordPerPage;

		return $this;
	}

	public function setTotalRecords($totalRecords)
	{
		$this->totalRecords = $totalRecords;

		return $this;
	}

	public function setTemplate($template)
	{
		$this->template = $template;

		return $this;
	}
}

?>