<?php

/**
 * The base model from which all project models inherit.
 */
class XRXBaseModel extends AgaviModel
{
	const CATEGORIES		= "categories";

	const CATEGORY_MODULE	= "category_module";

	const COMMENTS			= "comments";

	const MODULES			= "modules";

	const NEWS				= "news";

	const NEWS_I18N			= "news_i18n";

	const PAGES				= "pages";

	const PAGES_I18N		= "pages_i18n";

	const SETTINGS			= "settings";

	const USERS				= "users";
	
	
	public function getTotalCount()
	{
		try {
			$sql = "SELECT FOUND_ROWS() as c;";

			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			// No record?
			if (! $result) {
				return null;
			}

			return $result['c'];
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}
	}
}

?>