<?php

class Setting_SettingManagerModel extends XRXSettingBaseModel
{
	public function retrieveAll()
	{
		try {
			$sql = "SELECT s.*
					FROM %s AS s";

			$sql	= sprintf($sql, self::SETTINGS);
			$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);

			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			// No record?
			if (! $result) {
				return null;
			}

			foreach ($result as $s) {
				$t = $this->getContext()->getModel('Setting', 'Setting', array($s))->toArray();
				$setting[] = (object) $t;
			}

			return $setting;
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}
	}


	public function update(array $data)
	{
		foreach ($data as $dt) {
			$settings[] = $this->getContext()->getModel('Setting', 'Setting', array($dt));
		}

		try {
			foreach ($settings as $setting) {
				$sql = "UPDATE %s AS s
						SET s.value = :value
						WHERE
							s.name = :name
						AND
							s.module = :module;";

				$sql	= sprintf($sql, self::SETTINGS);
				$stmt	= $this->getContext()->getDatabaseConnection()->prepare($sql);
				$stmt->bindValue(':value', $setting->getValue(), PDO::PARAM_STR);
				$stmt->bindValue(':name', $setting->getName(), PDO::PARAM_STR);
				$stmt->bindValue(':module', $setting->getModule(), PDO::PARAM_STR);
				$stmt->execute();
			}
		}
		catch (PDOException $e) {
			throw new AgaviDatabaseException($e->getMessage());
		}

		return true;
	}
}

?>