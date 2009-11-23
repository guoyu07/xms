<?php

class Comment_CommentManagerModel extends XRXCommentBaseModel
{
	public function retrieveByOwnerId($owner_id, $module_id, $language = null)
	{
		if (empty ($owner_id) || empty ($module_id)) {
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
			$stmt->bindValue(':owner_id', $owner_id, PDO::PARAM_INT);
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
				$comments[] = $this->getContext()->getModel('Comment', 'Comment', array($r));
			}

			return $comments;
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}
	}


	public function retrieveAllByModuleId($module_id, $tables, $language = null, $limit = 10, $start = 0)
	{
		try {
			$sql = "SELECT
						c.*,
						m.*
					FROM %s AS c
					WHERE c.module_id = :module_id ";

			foreach ($tables as $c => $table) {
				$sql .= "LEFT JOIN " . 'xxx' . " AS t$c ";

				if ($c < 1) {
					$sql .= "ON (c.module_id = t$c." . $table['field'] . ") ";
				} else {
					// Previous table
					$pt = $tables[$c-1];
					
					$sql .= "ON (t" . $c-1 . "." . $pt['field'] . "= t$c." . $table['field'] . ") ";
				}
			}
			echo $sql;
			return;
			
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