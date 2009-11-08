<?php

class ModulesModel extends XRXBaseModel implements AgaviISingletonModel
{
	public function retrieveById($id)
	{
		if (empty ($id))
			return null;

		try {
			$sql = "SELECT m.*
					FROM %s AS m
					WHERE m.id = :id";

			$sql	= sprintf($sql, self::MODULES);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);

			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_OBJ);
			
			// No record?
			if (! $result) {
				return null;
			}
			
			return $result;
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}
	}


	public function retrieveAll()
	{
		try {
			$sql = "SELECT m.*
					FROM %s AS m";

			$sql	= sprintf($sql, self::MODULES);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);

			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_OBJ);

			// No module added yet?
			if (! $result) {
				throw new AgaviDatabaseException("There's no module exists in database!");
			}

			return $result;
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}
	}


	public function retrieveCategoryEnabled()
	{
		try {
			$sql = "SELECT m.*
					FROM %s AS m
					WHERE m.use_category = true";

			$sql	= sprintf($sql, self::MODULES);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);

			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_OBJ);

			// No module set to use category yet?
			if (! $result) {
				throw new AgaviDatabaseException("There's no module exists with category-enabled!");
			}

			return $result;
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}
	}
}

?>