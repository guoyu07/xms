<?php

/**
 * Interface for model of modules that use category.
 *
 * @author     Khashayar Hajian <me@khashayar.me>
 *
 */
interface XRXICategoryModel
{
	/**
	 * Changes category_id with value of NULL to 1 (Uncategorized).
	 *
	 * @param      AgaviFilterChain A FilterChain instance.
	 * @param      AgaviExecutionContainer The current execution container.
	 *
	 * @author     Khashayar Hajian <me@khashayar.me>
	 */
	public function resetCategoryId();
}

?>