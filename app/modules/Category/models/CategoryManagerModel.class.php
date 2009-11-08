<?php

class Category_CategoryManagerModel extends XRXCategoryBaseModel
{
	public function retrieveById($id)
	{
		if (empty ($id)) {
			return null;
		}
		
		try {
			$sql = "SELECT
						c.*,
						GROUP_CONCAT(m.id) as module_id,
						GROUP_CONCAT(m.name ORDER BY m.name ASC) as module_name
					FROM %s AS c
					LEFT JOIN %s AS cm ON (c.id = cm.category_id)
					LEFT JOIN %s AS m ON (cm.module_id = m.id)
					WHERE c.id = :id";

			$sql	= sprintf($sql, self::CATEGORIES, self::CATEGORY_MODULE, self::MODULES);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			// No record?
			if (! $result['id']) {
				return null;
			}

			$temp = $this->getContext()->getModel('Category', 'Category', array($result))->toArray();
			$temp['modules'] = array_combine(explode(',', $result['module_id']), explode(',', $result['module_name']));
			$category = (object) $temp;
			
			return $category;
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}
	}


	public function retrieveAll($root = null)
	{
		// Return top level root node?
		$id = isset ($root) ? 0 : 1;
		
		try {
			$sql = "SELECT
						c.*,
						(CHAR_LENGTH(c.path) - CHAR_LENGTH(REPLACE(c.path, '/', '')) - 2) AS depth
					FROM %s AS c
					WHERE c.id >= :id
					GROUP BY c.id
					ORDER BY c.path;";

			$sql	= sprintf($sql, self::CATEGORIES);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);

			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			// No record?
			if (! $result) {
				return null;
			}

			foreach ($result as $c) {
				$temp = $this->getContext()->getModel('Category', 'Category', array($c))->toArray();
				$temp['depth'] = $c['depth'];
				$cats[] = (object) $temp;
			}

			return $cats;
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}
	}


	// Returns Assocaited Modules
	public function retrieveAllWithAssociates($root = null)
	{
		// Return top level root node?
		$id = isset ($root) ? 0 : 1;
		
		try {
			$sql = "SELECT
						cat_depth.*,
						GROUP_CONCAT(m.id) AS module_id,
						GROUP_CONCAT(m.name ORDER BY m.name ASC) AS module_name
					FROM (
						SELECT
							c.*,
							(CHAR_LENGTH(c.path) - CHAR_LENGTH(REPLACE(c.path, '/', '')) - 2) AS depth
						FROM %s AS c
						WHERE c.id >= :id
						GROUP BY c.id
					) AS cat_depth
					LEFT JOIN %s AS cm ON(cat_depth.id = cm.category_id)
					LEFT JOIN %s AS m ON(cm.module_id = m.id)
					GROUP BY cat_depth.id
					ORDER BY cat_depth.path;";

			$sql	= sprintf($sql, self::CATEGORIES, self::CATEGORY_MODULE, self::MODULES);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			// No record?
			if (! $result) {
				return null;
			}

			foreach ($result as $c) {
				$temp = $this->getContext()->getModel('Category', 'Category', array($c))->toArray();
				$temp['depth'] = $c['depth'];

				if ($c['module_id']) {
					$temp['modules']	= array_combine(explode(',', $c['module_id']), explode(',', $c['module_name']));
				}
				
				$cats[] = (object) $temp;
			}

			return $cats;
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}
	}


	// Find all categories associated with specific module id
	public function retrieveAssociatedWith($id)
	{
		if (empty ($id))
			return null;

		try {
			$sql = "SELECT
						c.path AS path
					FROM %s AS c
					LEFT JOIN %s AS cm ON(c.id = cm.category_id)
					LEFT JOIN %s AS m ON(cm.module_id = m.id)
					WHERE m.id = :module_id";

			$sql	= sprintf($sql, self::CATEGORIES, self::CATEGORY_MODULE, self::MODULES);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);

			$stmt->bindValue(':module_id', $id, PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			
			// No record?
			if (! $result) {
				return null;
			}

			foreach ($result as $r) {
				$sql = "SELECT
							c.*,
							(CHAR_LENGTH(c.path) - CHAR_LENGTH(REPLACE(c.path, '/', '')) - 2) AS depth
						FROM %s AS c
						WHERE c.path LIKE(:path)
						GROUP BY c.id
						ORDER BY c.path";

				$sql	= sprintf($sql, self::CATEGORIES);
				$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);

				$stmt->bindValue(':path', $r['path'] . '%', PDO::PARAM_STR);
				$stmt->execute();
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

				foreach ($result as $r) {
					$temp[] = $r;
				}
			}
			
			foreach ($temp as $cat) {
				$temp = $this->getContext()->getModel('Category', 'Category', array($cat))->toArray();
				$temp['depth'] = $cat['depth'];

				$cats[] = (object) $temp;
			}
			
			return $cats;
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}
	}


	// Find a category's path by it's id
	public function retrievePathById($id)
	{
		if (empty ($id)) {
			return false;
		}

		try {
			$sql = "SELECT path
					FROM %s
					WHERE id = :id;";

			$sql = sprintf($sql, self::CATEGORIES);
			$stmt = $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetchObject();

			if (! $result) {
				return null;
			}

			return $result->path;
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}
	}


	// Find a category by it's child id
	public function retrieveByChildId($id)
	{
		if (empty ($id)) {
			return null;
		}

		try {
			//	I couldn't push this inside update or delete query as a subquery.
			//	MySQL Doc: 'You can't update a table & select from the same table in a subquery'
			//	http://dev.mysql.com/doc/refman/5.1/en/update.html
			$sql = 'SELECT *
					FROM %1$s
					WHERE id = (
						SELECT parent_id
						FROM %1$s
						WHERE id = :id
					);';

			$sql	= sprintf($sql, self::CATEGORIES);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);

			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetch();
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}

		// No result? kinda weird. let's controller decides what to do?!!!
		if (! $result) {
			return null;
		}

		return $this->getContext()->getModel('Category', 'Category', array($result));
	}


	public function create(array $data)
	{
		$category = $this->getContext()->getModel('Category', 'Category', array($data));
		
		try {
			// Start Transaction
			$this->getContext()->getDatabaseConnection()->beginTransaction();


			// 1. Insert data into Categories Table
			$sql = "INSERT INTO %s (name, description, parent_id)
					VALUES(:name, :description, :parent_id)";

			$sql	= sprintf($sql, self::CATEGORIES);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->bindValue(':name', $category->getName(), PDO::PARAM_STR);
			$stmt->bindValue(':description', $category->getDescription(), PDO::PARAM_STR);
			$stmt->bindValue(':parent_id', $category->getParentId(), PDO::PARAM_INT);
			$stmt->execute();


			// Sync ORM's with new inserted id
			$category->setId( $this->getContext()->getDatabaseConnection()->lastInsertId() );
			$category->setPath( $category->getPath() . $category->getId() . '/' );
			

			// 2. Create the path and update the path field for record just created
			$sql = "UPDATE %s AS c
					SET c.path = :path
					WHERE c.id = :id;";

			$sql	= sprintf($sql, self::CATEGORIES);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->bindValue(':id', $category->getId(), PDO::PARAM_INT);
			$stmt->bindValue(':path', $category->getPath(), PDO::PARAM_STR);
			$stmt->execute();


			// If it's a top level category
			if (! $category->getParentId()) {
				$module_ids	= $data['module_ids'];
				
				// 3. Insert data into Category_Module Table
				$sql = "INSERT INTO %s (category_id, module_id)
						VALUES";

				$sql = sprintf($sql, self::CATEGORY_MODULE);

				// TODO: Change the way module_id appended to query!
				foreach ($module_ids as $mid) {
					$temp[] = "(" . $category->getId() . ", $mid)";
				}

				// Append created statement to base sql
				$sql	.= implode(',', $temp);
				$stmt	 = $this->getContext()->getDatabaseConnection()->prepare($sql);
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


	// Create relation between a category and some modules
	public function createRelations($id, $module_ids)
	{
		if (empty ($id) || empty ($module_ids)) {
			return false;
		}

		// Loop through module_ids
		foreach ($module_ids as $mid) {
			$temp[] = "(" . $id . ", $mid)";
		}

		try {
			$sql = "INSERT INTO %s (category_id, module_id)
					VALUES %s;";

			$sql	= sprintf($sql, self::CATEGORY_MODULE, implode(',', $temp));
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->execute();
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}

		return true;
	}


	public function update(array $data)
	{
		$category = $this->getContext()->getModel('Category', 'Category', array($data));

		try {
			// Start Transaction
			$this->getContext()->getDatabaseConnection()->beginTransaction();

			
			// 1. Update path of all subordinates and the node itself.
			$sql = "UPDATE %s AS c
					SET c.path = (REPLACE(c.path, :prev_parent_path, :parent_path))
					WHERE c.path LIKE :path;";

			$sql	= sprintf($sql, self::CATEGORIES);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->bindValue(':parent_path', $data['parent_path'], PDO::PARAM_STR);
			$stmt->bindValue(':prev_parent_path', $data['prev_parent_path'], PDO::PARAM_INT);
			$stmt->bindValue(':path', '%' . $prev_parent_path . $category->getId() . '/%', PDO::PARAM_STR);
			$stmt->execute();


			// 2. Update other fields of the node
			$sql = "UPDATE %s AS c
					SET c.name = :name,
						c.description = :desc,
						c.parent_id = :parent_id
					WHERE c.id = :id";

			$sql	= sprintf($sql, self::CATEGORIES);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->bindValue(':id', $category->getId(), PDO::PARAM_INT);
			$stmt->bindValue(':name', $category->getName(), PDO::PARAM_STR);
			$stmt->bindValue(':desc', $category->getDescription(), PDO::PARAM_STR);
			$stmt->bindValue(':parent_id', $category->getParentId(), PDO::PARAM_INT);
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


	public function deleteById($id)
	{
		if (empty ($id)) {
			return false;
		}

		// Find the category's path
		$path = $this->retrievePathById($id);

		// No path? it means there's no category with passed id
		// or it's the root node. in both cases return false.
		if ($path == null) {
			return false;
		}

		try {
			$sql = "DELETE c
					FROM %s AS c
					WHERE c.path LIKE(:path)";

			$sql	= sprintf($sql, self::CATEGORIES);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
			$stmt->bindValue(':path', $path . '%', PDO::PARAM_STR);
			$stmt->execute();
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}

		return true;
	}


	// Delete all category-module relations by specific category id
	public function deleteRelationsById($id)
	{
		if (empty ($id)) {
			return false;
		}

		try {
			$sql = "DELETE cm
					FROM %s AS cm
					WHERE cm.category_id = :id;";

			$sql	= sprintf($sql, self::CATEGORY_MODULE);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);

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