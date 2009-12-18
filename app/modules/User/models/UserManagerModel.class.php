<?php

class User_UserManagerModel extends XRXUserBaseModel
{
	public function retrieveById($id)
	{
		try {
			$sql = "SELECT u.*
					FROM %s AS u
					WHERE u.id = :id";

			$sql	= sprintf($sql, self::USERS);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);

			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			// No record?
			if (! $result) {
				return null;
			}

			$user = $this->getContext()->getModel('User', 'User', array($result))->toArray();

			return (object) $user;
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}
	}


	public function retrieveAll()
	{
		try {
			$sql = "SELECT u.*
					FROM %s AS u
					ORDER BY u.username ASC";

			$sql	= sprintf($sql, self::USERS);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);

			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			// No record?
			if (! $result) {
				return null;
			}

			foreach ($result as $r) {
				$users[] = (object) $this->getContext()->getModel('User', 'User', array($r))->toArray();
			}

			return $users;
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}
	}


	public function retrieveByUsername($username)
	{
		try {
			$sql = "SELECT u.*
					FROM %s AS u
					WHERE username = :username";

			$sql	= sprintf($sql, self::USERS);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->bindValue(':username', $username, PDO::PARAM_STR);

			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			// No record?
			if (! $result) {
				return null;
			}

			return $this->getContext()->getModel('User', 'User', array($result));
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}
	}


	public function retrieveByUsernameOrEmail($username, $email)
	{
		try {
			$sql = "SELECT u.*
					FROM %s AS u
					WHERE username = :username OR email = :email";

			$sql	= sprintf($sql, self::USERS);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->bindValue(':username', $username, PDO::PARAM_STR);
			$stmt->bindValue(':email', $email, PDO::PARAM_STR);

			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			// No record?
			if (! $result) {
				return null;
			}

			return $this->getContext()->getModel('User', 'User', array($result));
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}
	}


	public function create(array $data)
	{
		try {
			$user = $this->getContext()->getModel('User', 'User', array($data));

			$sql = "INSERT INTO %s (username, password, email)
					VALUES(:username, :password, :email)";

			$sql	= sprintf($sql, self::USERS);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->bindValue(':username', $user->getUsername(), PDO::PARAM_STR);
			$stmt->bindValue(':password', $user->getPassword(), PDO::PARAM_STR);
			$stmt->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
			$stmt->execute();

			return true;
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}
	}


	public function update(array $data)
	{
		$user = $this->getContext()->getModel('User', 'User', array($data));
		
		try {
			$sql = "UPDATE %s AS u
					SET u.username = :username,";

			if ($user->getPassword()) {
				$sql .= "u.password = :password,";
			}

			$sql .= "u.email = :email
					WHERE u.id = :id";

			$sql	= sprintf($sql, self::USERS);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->bindValue(':username', $user->getUsername(), PDO::PARAM_STR);

			if ($user->getPassword()) {
				$stmt->bindValue(':password', $user->getPassword(), PDO::PARAM_STR);
			}
			
			$stmt->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
			$stmt->bindValue(':id', $user->getId(), PDO::PARAM_INT);
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
			$sql = "DELETE u
					FROM %s AS u
					WHERE u.id IN (%s)";

			$id		= "'" . implode("','", $id) . "'";
			$sql	= sprintf($sql, self::USERS, $id);
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