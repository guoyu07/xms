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
     * Number of items per page
     *
     * @var integer
     */
	private $itemCountPerPage = 10;

    /**
     * Number of local pages (i.e., the number of discrete page numbers
     * that will be displayed, including the current page number)
     *
     * @var integer
     */
    protected $pageRange = 5;

    /**
     * Template to show the result with
     *
     * @var string
     */
	private $template;

	
    public function paginator($page = null, $totalRecords = null, $itemsPerPage = null)
	{
		if (empty ($page)) {
			return $this;
		}

		if (isset ($totalRecords)) {
			$this->setTotalRecords($totalRecords);
		}

		if (isset ($itemsPerPage)) {
			$this->setItemCountPerPage($itemsPerPage);
		}
		
		// Don't show anything if there's no need!
		if ($this->totalRecords <= $this->itemCountPerPage) {
			return;
		}

		
		$this->first	= 1;
		$this->current	= (integer) $page;
		$this->last		= (integer) ceil($this->totalRecords / $this->itemCountPerPage);
		
        // Previous
        if ($this->current - 1 > 0) {
            $this->previous = $this->current - 1;
        }

		// Next
        if ($this->current + 1 <= $this->last) {
            $this->next = $this->current + 1;
        }

		
		$pages = $this->getPages( $this->pageRange );
		$this->out($pages);
	}

    /**
     * Sets the page range (see property declaration above).
     *
     * @param  integer $pageRange
     * @return PaginatorHelper $this
     */
	public function setPageRange($pageRange)
	{
        $this->pageRange = (integer) $pageRange;

        return $this;
	}

    /**
     * Sets the number of items per page.
     *
     * @param  integer $itemCountPerPage
     * @return PaginatorHelper $this
     */
	public function setItemCountPerPage($itemCountPerPage)
	{
		$this->itemCountPerPage = (integer) $itemCountPerPage;

		if ($this->itemCountPerPage < 1) {
			$this->itemCountPerPage = 1;
		}

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

	/**
	 * Returns an array of "local" pages given a page number and range.
	 *
	 * @param  integer $pageRange Page range
	 * @return array
	 */
    public function getPages($pageRange)
    {
        $pageNumber = $this->current;
        $pageCount  = $this->totalRecords;

        if ($pageRange > $pageCount) {
            $pageRange = $pageCount;
        }

        $delta = ceil($pageRange / 2);

        if ($pageNumber - $delta > $pageCount - $pageRange) {
            $lowerBound = $pageCount - $pageRange + 1;
            $upperBound = $pageCount;
        } else {
            if ($pageNumber - $delta < 0) {
                $delta = $pageNumber;
            }

            $offset     = $pageNumber - $delta;
            $lowerBound = $offset + 1;
            $upperBound = $offset + $pageRange;
        }

		return $this->getPagesInRange($lowerBound, $upperBound);
    }

	/**
	 * Returns a subset of pages within a given range.
	 *
	 * @param  integer $lowerBound Lower bound of the range
	 * @param  integer $upperBound Upper bound of the range
	 * @return array
	 */
    public function getPagesInRange($lowerBound, $upperBound)
    {
        $lowerBound = $this->normalizePageNumber($lowerBound);
        $upperBound = $this->normalizePageNumber($upperBound);

        $pages = array();

        for ($pageNumber = $lowerBound; $pageNumber <= $upperBound; $pageNumber++) {
            $pages[$pageNumber] = $pageNumber;
        }

        return $pages;
    }

	/**
	 * Brings the page number in range of the paginator.
	 *
	 * @param  integer $pageNumber
	 * @return integer
	 */
    public function normalizePageNumber($pageNumber)
    {
        if ($pageNumber < 1) {
            $pageNumber = 1;
        }

        $pageCount = $this->last;
		
        if ($pageCount > 0 && $pageNumber > $pageCount) {
            $pageNumber = $pageCount;
        }

        return $pageNumber;
    }

	public function createURL($pageNumber)
	{
		$url	 = $this->view->getContext()->getRequest()->getUrl();
		$pattern = '/_p\/\d*/i';
		$replace = "_p/$pageNumber";

		if ( preg_match($pattern, $url) ) {
			$url = preg_replace($pattern, $replace, $url);
		} else {
			if (substr($url, -1) == '/') {
				$url .= $replace;
			} else {
				$url .= '/' . $replace;
			}
		}
		return $url;
	}

	public function out($pages)
	{
		// - - - - - -
		// Template
		// - - - - - -

		$tm	= $this->view->getContext()->getTranslationManager();
		
		if (isset ($this->previous)) {
			echo "<a href='{$this->createURL($this->previous)}'>{$tm->_('previous entries', '.widgets')}</a>";
		}

		if (isset ($this->next)) {
			echo "<a href='{$this->createURL($this->next)}'>{$tm->_('next entries', '.widgets')}</a>";
		}
	}

	public function outOriginal($pages)
	{
		// - - - - - -
		// Template
		// - - - - - -

		// Display Info
		$tm		= $this->view->getContext()->getTranslationManager();
		$status = "<span class='xrx-page-status'>displaying %s&ndash;%s of %s</span>";

		$iStart	= ($this->current - 1) * $this->itemCountPerPage + 1;
		$iEnd	= $this->current * $this->itemCountPerPage;
		$iEnd	= ($iEnd < $this->totalRecords) ? $iEnd : $this->totalRecords;
		echo sprintf($tm->_($status), $iStart, $iEnd, $this->totalRecords);



		// First page link
		if (isset ($this->previous)) {
			echo "<a href='{$this->createURL($this->first)}'>&laquo;</a>";
		} else {
			echo "<span class='xrx-hidden'>&laquo;</span>";
		}

		/*
		// Previous page link
		if (isset ($this->previous)) {
			echo '<a href="' . $this->createURL($this->previous) . '">&lt;</a>';
		} else {
			echo "<span class='xrx-hidden'>&lt;</span>";
		}
		*/

		// Numbered page links
		foreach ($pages as $page) {
			if ($page != $this->current) {
				echo "<a class='xrx-page-number' href='{$this->createURL($page)}'>$page</a>";
			} else {
				echo "<span class='xrx-current xrx-page-number'>$page</span>";
			}
		}

		/*
		// Next page link
		if (isset ($this->next)) {
			echo '<a href="' . $this->createURL($this->next) . '">&gt;</a>';
		} else {
			echo '<span class="disabled">&gt;</span>';
		}
		*/

		// Last page link
		if (isset ($this->next)) {
			echo "<a class='xrx-page-number' href='{$this->createURL($this->last)}'>&raquo;</a>";
		} else {
			echo '<span class="xrx-hidden">&raquo;</span>';
		}
		
	}
}

?>