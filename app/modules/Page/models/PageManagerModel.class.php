<?php

class Page_PageManagerModel extends XRXPageBaseModel
{
	public function retrieveById($id, $language = null)
	{
		if (empty ($id)) {
			return null;
		}

		$sql = "SELECT
					p.*,
					pi.*,
					u.username
				FROM %s AS p
				LEFT JOIN %s AS pi ON (p.id = pi.page_id)
				LEFT JOIN %s AS u ON (p.author_id = u.id)
				WHERE p.id = :id ";

		if (isset ($language)) {
			$sql .= "AND pi.language = :language";
		}

		$sql	= sprintf($sql, self::PAGES, self::PAGES_I18N, self::USERS);
		$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);

		if (isset ($language)) {
			$stmt->bindValue(':language', $language, PDO::PARAM_STR);
		}

		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

		// No record?
		if (! $result) {
			return null;
		}

		foreach ($result as $p) {
			$t = array('username' => $p['username']);

			$t = array_merge($t, $this->getContext()->getModel('Page', 'Page', array($p))->toArray());
			$t = array_merge($t, $this->getContext()->getModel('PageI18n', 'Page', array($p))->toArray());

			$page[$t['language']] = (object) $t;
		}

		return $page;
	}


	public function retrieveAll(array $filters = null)
	{
		if (isset ($filters['language'])) {
			$language = $filters['language'];
		}

		if (isset ($filters['start'])) {
			$start = (integer) $filters['start'];
		}

		if (isset ($filters['limit'])) {
			$limit = (integer) $filters['limit'];
		}

		if (isset ($filters['published'])) {
			$published = (boolean) $filters['published'];
		}


		try {
			$sql = "SELECT
						SQL_CALC_FOUND_ROWS *,
						p.*,
						pi.*,
						u.username
					FROM %s AS p
					LEFT JOIN %s AS pi ON (p.id = pi.page_id)
					LEFT JOIN %s AS u ON (p.author_id = u.id) ";

			// Language
			if (isset ($language)) {
				$sql.= "WHERE pi.language = :language ";
			}

			// Published
			if (isset ($published)) {
				$sql .= (strpos($sql, "WHERE") != false) ? "AND " : "WHERE ";
				$sql .= "p.published = :published ";
			}

			// Start, Limit
			if (isset ($start) && isset($limit)) {
				$sql .= "LIMIT :start, :limit";
			}
			
			$sql	= sprintf($sql, self::PAGES, self::PAGES_I18N, self::USERS);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);

			if (isset ($start) && isset($limit)) {
				$stmt->bindValue(':start', $start, PDO::PARAM_INT);
				$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
			}

			if (isset ($language)) {
				$stmt->bindValue(':language', $language, PDO::PARAM_STR);
			}

			if (isset ($published)) {
				$stmt->bindValue(':published', $published, PDO::PARAM_BOOL);
			}


			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			// No record?
			if (! $result) {
				return null;
			}

			foreach ($result as $p) {
				$t = array('username' => $p['username']);

				$t = array_merge($t, $this->getContext()->getModel('PageI18n', 'Page', array($p))->toArray());
				$t = array_merge($t, $this->getContext()->getModel('Page', 'Page', array($p))->toArray());
				$pages[] = (object) $t;
			}

			return $pages;
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}
	}


	public function create(array $data)
	{
		$page		= $this->getContext()->getModel('Page', 'Page', array($data));
		$pageI18n	= array();

		foreach ($data['translations'] as $field) {
			$pageI18n[] = $this->getContext()->getModel('PageI18n', 'Page', array($field));
		}

		try {
			// Start Transaction
			$this->getContext()->getDatabaseConnection()->beginTransaction();


			// 1. Insert data into Pages Table
			$sql = "INSERT INTO %s (published, author_id)
					VALUES(:published, :author_id)";

			$sql	= sprintf($sql, self::PAGES);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->bindValue(':published', $page->getPublished(), PDO::PARAM_BOOL);
			$stmt->bindValue(':author_id', $page->getAuthorId(), PDO::PARAM_INT);
			$stmt->execute();

			// Sync ORM's with new inserted id
			$page->setId( $this->getContext()->getDatabaseConnection()->lastInsertId() );


			// 2. Insert data into Pages_I18N Table
			$sql = "INSERT INTO %s (page_id, title, content, language)
					VALUES";

			$sql = sprintf($sql, self::PAGES_I18N);

			// Create Values clause for each language
			foreach ($pageI18n as $pi) {
				$l		= $pi->getLanguage();
				$temp[] = "(:page_id_$l, :title_$l, :content_$l, :language_$l)";

				// To prevent extra loop, it's better to update id here
				$pi->setPageId( $page->getId() );
			}

			// Append created statement to base sql
			$sql .= implode(',', $temp);
			$stmt = $this->getContext()->getDatabaseConnection()->prepare($sql);

			// Add values for each language in PDO way
			foreach ($pageI18n as $pi) {
				$l = $pi->getLanguage();

				$stmt->bindValue(":page_id_$l", $pi->getPageId(), PDO::PARAM_INT);
				$stmt->bindValue(":title_$l", $pi->getTitle(), PDO::PARAM_STR);
				$stmt->bindValue(":content_$l", $pi->getContent(), PDO::PARAM_STR);
				$stmt->bindValue(":language_$l", $pi->getLanguage(), PDO::PARAM_STR);
			}

			$stmt->execute();

			// Finally Commit the Transaction
			$this->getContext()->getDatabaseConnection()->commit();
		}
		catch (PDOException $e) {
			$this->getContext()->getDatabaseConnection()->rollBack();
			throw new AgaviDatabaseException($e->getMessage());
		}

		return true;
	}


	public function update(array $data)
	{
		$page		= $this->getContext()->getModel('Page', 'Page', array($data));
		$pageI18n	= array();

		foreach ($data['translations'] as $field) {
			$field['page_id'] = $page->getId();
			$pageI18n[] = $this->getContext()->getModel('PageI18n', 'Page', array($field));
		}

		try {
			// Start Transaction
			$this->getContext()->getDatabaseConnection()->beginTransaction();

			// 1. Update Page Table data
			$sql = "UPDATE
						%s AS p
					SET
						p.published = :published
					WHERE
						p.id = :id";

			$sql	= sprintf($sql, self::PAGES);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->bindValue(':id', $page->getId(), PDO::PARAM_INT);
			$stmt->bindValue(':published', $page->getPublished(), PDO::PARAM_BOOL);
			$stmt->execute();


			// Update each translation
			foreach ($pageI18n as $pi) {
				// 2. Insert/Update data into Page_I18N Table
				$sql = "INSERT INTO %s (page_id, title, content, language)
						VALUES (:page_id, :title, :content, :language)
						ON DUPLICATE KEY UPDATE
							title = VALUES(title),
							content = VALUES(content)";

				$sql	= sprintf($sql, self::PAGES_I18N);
				$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
				$stmt->bindValue(':page_id', $pi->getPageId(), PDO::PARAM_INT);
				$stmt->bindValue(':title', $pi->getTitle(), PDO::PARAM_STR);
				$stmt->bindValue(':content', $pi->getContent(), PDO::PARAM_STR);
				$stmt->bindValue(':language', $pi->getLanguage(), PDO::PARAM_STR);
				$stmt->execute();
			}

			// Finally Commit the Transaction
			$this->getContext()->getDatabaseConnection()->commit();
		}
		catch (PDOException $e) {
			$this->getContext()->getDatabaseConnection()->rollBack();
			throw new AgaviDatabaseException($e->getMessage());
		}

		return true;
	}


	public function deleteByIds(array $ids)
	{
		try {
			$sql = "DELETE p
					FROM %s AS p
					WHERE p.id IN (%s)";
			
			$sql	= sprintf($sql, self::PAGES, implode(",", $ids));
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->execute();
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}

		return true;
	}


	public function deleteByLang($id, array $language)
	{
		if (empty ($id) || empty ($language))
			return false;

		try {
			$sql = "DELETE pi
					FROM %s AS pi
					WHERE pi.page_id = :id AND pi.language IN (%s)";

			$languages	= "'" . implode("','", $language) . "'";
			$sql		= sprintf($sql, self::PAGES_I18N, $languages);
			$stmt		= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}

		return true;
	}
}

?>