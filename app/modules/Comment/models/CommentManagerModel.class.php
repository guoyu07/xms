<?php

class Comment_CommentManagerModel extends XRXCommentBaseModel
{
	public function retrieveByOwnerId($ownerId, $moduleId, $language = null)
	{
		if (empty ($ownerId) || empty ($moduleId)) {
			return null;
		}

		try {
			$sql = "SELECT c.*
					FROM %s AS c
					WHERE c.owner_id = :owner_id AND c.module_id = :module_id ";

			if (isset ($language)) {
				$sql .= "AND c.language = :language";
			}

			$sql	= sprintf($sql, self::COMMENTS);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->bindValue(':owner_id', $ownerId, PDO::PARAM_INT);
			$stmt->bindValue(':module_id', $moduleId, PDO::PARAM_INT);

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
				$comments[] = $this->getContext()->getModel('Comment', 'Comment', array($r));
			}

			return $comments;
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}
	}


	public function retrieveAll($language = null, $limit = 10, $start = 0)
	{
		try {
			$sql = "SELECT
						c.*,
						m.*
					FROM %s AS c
					LEFT JOIN %s AS m ON (c.module_id = m.id)
					LEFT JOIN
					WHERE c.owner_id = :owner_id AND c.module_id = :module_id ";

			if (isset ($language)) {
				$sql .= "AND c.language = :language";
			}

			$sql	= sprintf($sql, self::COMMENTS);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->bindValue(':owner_id', $ownerId, PDO::PARAM_INT);
			$stmt->bindValue(':module_id', $moduleId, PDO::PARAM_INT);

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
				$comments[] = $this->getContext()->getModel('Comment', 'Comment', array($r));
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
			$sql = "INSERT INTO %s (owner_id, module_id, content, date, author_id, author_name, author_email, author_url, language)
					VALUES(:owner_id, :module_id, :content, NOW(), :author_id, :author_name, :author_email, :author_url, :language)";

			$sql	= sprintf($sql, self::COMMENTS);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->bindValue(':owner_id', $comment->getOwnerId(), PDO::PARAM_INT);
			$stmt->bindValue(':module_id', $comment->getModuleId(), PDO::PARAM_INT);
			$stmt->bindValue(':content', $comment->getContent(), PDO::PARAM_STR);
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
}

?>