<?php

/**
 * The base model from which all News module models inherit.
 */
class XRXNewsBaseModel extends XRXBaseModel
{
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