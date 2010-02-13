<?php

class Comment_CommentManagerModel extends XRXCommentBaseModel
{
	public function retrieveById($id, $language)
	{
		if (empty ($id) || empty ($language)) {
			return null;
		}

		try {
			$sql = "SELECT
						c.*,
						IF (ISNULL(u.username), c.author_name, u.username) AS author_name,
						IF (ISNULL(u.email), c.author_email, u.email) AS author_email
					FROM %s AS c
					LEFT JOIN %s AS u ON (u.id = c.author_id)
					WHERE c.id = :id AND c.language = :language";

			$sql	= sprintf($sql, self::COMMENTS, self::USERS);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->bindValue(':language', $language, PDO::PARAM_STR);

			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			// No record?
			if (! $result) {
				return null;
			}

			$comment = $this->getContext()->getModel('Comment', 'Comment', array($result))->toArray();
			
			return (object) $comment;
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}
	}

	
	public function retrieveByOwnerId($owner_id, $module_id, $language = null, $status = null)
	{
		if (empty ($owner_id) || empty ($module_id)) {
			return null;
		}

		try {
			$sql = "SELECT 
						c.*,
						IF (ISNULL(u.username), c.author_name, u.username) AS author_name,
						IF (ISNULL(u.email), c.author_email, u.email) AS author_email
					FROM %s AS c
					LEFT JOIN %s AS u ON (u.id = c.author_id)
					WHERE c.owner_id = :owner_id AND c.module_id = :module_id ";

			// Language?
			if (isset ($language)) {
				$sql .= "AND c.language = :language ";
			}
			
			// Status?
			if (isset ($language)) {
				$sql .= "AND c.status = :status";
			}

			$sql	= sprintf($sql, self::COMMENTS, self::USERS);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->bindValue(':owner_id', $owner_id, PDO::PARAM_INT);
			$stmt->bindValue(':module_id', $module_id, PDO::PARAM_INT);

			if (isset ($language)) {
				$stmt->bindValue(':language', $language, PDO::PARAM_STR);
			}

			if (isset ($status)) {
				$stmt->bindValue(':status', $status, PDO::PARAM_STR);
			}

			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			// No record?
			if (! $result) {
				return null;
			}
			
			foreach ($result as $r) {
				$comments[] = $this->getContext()->getModel('Comment', 'Comment', array($r));
			}

			return $comments;
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}
	}


	public function retrieveAllByModuleId($module_id, $table_info, $language = null, $limit = 10, $start = 0)
	{
		$table	= $table_info['table'];
		$id		= $table_info['id'];
		$title	= $table_info['title'];

		try {
			$sql = "SELECT
						c.*,
						IF (ISNULL(u.username), c.author_name, u.username) AS author_name,
						IF (ISNULL(u.email), c.author_email, u.email) AS author_email,
						tbl.%s AS owner_title
					FROM %s AS c
					LEFT JOIN %s AS u ON (u.id = c.author_id)
					LEFT JOIN %s AS tbl ON (c.owner_id = tbl.%s)
					WHERE c.module_id = :module_id AND c.language = tbl.language ";
			
			if (isset ($language)) {
				$sql .= "AND c.language = :language ";
			}

			$sql .= "ORDER BY c.date DESC";

			$sql	= sprintf($sql, $title, self::COMMENTS, self::USERS, $table, $id);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->bindValue(':module_id', $module_id, PDO::PARAM_INT);

			if (isset ($language)) {
				$stmt->bindValue(':language', $language, PDO::PARAM_STR);
			}

			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			// No record?
			if (! $result) {
				return null;
			}

			foreach ($result as $r) {
				$temp = $this->getContext()->getModel('Comment', 'Comment', array($r))->toArray();
				$temp['owner_title'] = $r['owner_title'];
				$comments[] = (object) $temp;
			}
			
			return $comments;
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}
	}


	public function create(array $data, $language)
	{
		// I need to know it
		if (empty ($language)) {
			return null;
		}

		$comment = $this->getContext()->getModel('Comment', 'Comment', array($data));

		try {
			$sql = "INSERT INTO %s (owner_id, module_id, content, date, status, author_id, author_name, author_email, author_url, language)
					VALUES(:owner_id, :module_id, :content, NOW(), :status, :author_id, :author_name, :author_email, :author_url, :language)";

			$sql	= sprintf($sql, self::COMMENTS);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->bindValue(':owner_id', $comment->getOwnerId(), PDO::PARAM_INT);
			$stmt->bindValue(':module_id', $comment->getModuleId(), PDO::PARAM_INT);
			$stmt->bindValue(':content', $comment->getContent(), PDO::PARAM_STR);
			$stmt->bindValue(':status', $comment->getStatus(), PDO::PARAM_STR);
			$stmt->bindValue(':author_id', $comment->getAuthorId(), PDO::PARAM_INT);
			$stmt->bindValue(':author_name', $comment->getAuthorName(), PDO::PARAM_STR);
			$stmt->bindValue(':author_email', $comment->getAuthorEmail(), PDO::PARAM_STR);
			$stmt->bindValue(':author_url', $comment->getAuthorUrl(), PDO::PARAM_STR);
			$stmt->bindValue(':language', $language, PDO::PARAM_STR);
			$stmt->execute();
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}

		return true;
	}


	public function update(array $data)
	{
		$comment = $this->getContext()->getModel('Comment', 'Comment', array($data));

		try {
			$sql = "UPDATE %s AS c
					SET c.content = :content,
						c.date = :date,
						c.status = :status,
						c.author_id = :author_id,
						c.author_name = :author_name,
						c.author_email = :author_email,
						c.author_url = :author_url
					WHERE c.id = :id";

			$sql	= sprintf($sql, self::COMMENTS);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->bindValue(':content', $comment->getContent(), PDO::PARAM_STR);
			$stmt->bindValue(':date', $comment->getDate(), PDO::PARAM_STR);
			$stmt->bindValue(':status', $comment->getStatus(), PDO::PARAM_STR);
			$stmt->bindValue(':author_id', $comment->getAuthorId(), PDO::PARAM_INT);
			$stmt->bindValue(':author_name', $comment->getAuthorName(), PDO::PARAM_STR);
			$stmt->bindValue(':author_email', $comment->getAuthorEmail(), PDO::PARAM_STR);
			$stmt->bindValue(':author_url', $comment->getAuthorUrl(), PDO::PARAM_STR);
			$stmt->bindValue(':id', $comment->getId(), PDO::PARAM_INT);
			$stmt->execute();
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}

		return true;
	}


	public function deleteById($id)
	{
		if (empty ($id)) {
			return false;
		}

		if (! is_array($id)) {
			$id = array($id);
		}

		try {
			$sql = "DELETE c
					FROM %s AS c
					WHERE c.id IN (%s)";

			$id		= "'" . implode("','", $id) . "'";
			$sql	= sprintf($sql, self::COMMENTS, $id);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->execute();
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}

		return true;
	}
}

?>