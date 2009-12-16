<?php

class User_UserManagerModel extends XRXUserBaseModel
{
	public function getById($id)
	{
		$sql = "SELECT u.*
				FROM %s AS u
				WHERE u.id = :id";

		$sql	= sprintf($sql, self::USERS);
		$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		
		$result = $stmt->fetchObject();
		FirePHP::getInstance(true)->log($result);
	}


	public function getAll()
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


	public function getByUsername($username)
	{
		$sql = "SELECT u.*
				FROM %s AS u
				WHERE username = :username";

		$sql	= sprintf($sql, self::USERS);
		$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
		$stmt->bindValue(':username', $username, PDO::PARAM_STR);
		$stmt->execute();

		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($result != false) {
			return $this->getContext()->getModel('User', 'User', array($result));
		}

		return null;
	}


	public function getByUsernameOrEmail($username, $email)
	{
		$sql = "SELECT u.*
				FROM %s AS u
				WHERE username = :username OR email = :email";

		$sql	= sprintf($sql, self::USERS);
		$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
		$stmt->bindValue(':username', $username, PDO::PARAM_STR);
		$stmt->bindValue(':email', $email, PDO::PARAM_STR);
		$stmt->execute();
		
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if ($result != false) {
			return $this->getContext()->getModel('User', 'User', array($result));
		}

		return null;
	}


	public function add(array $data)
	{
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
}

?>