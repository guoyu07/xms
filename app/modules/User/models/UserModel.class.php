<?php

class User_UserModel extends XRXUserBaseModel
{
	private $id;
	private $username;
	private $password;
	private $email;

	public function __construct(array $data = null)
	{
		if(!empty($data)) {
			$this->fromArray($data);
		}
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function setUsername($username)
	{
		$this->username = $username;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function fromArray(array $data)
	{
		$this->setId($data['id']);
		$this->setUsername($data['username']);
		$this->setPassword($data['password']);
		$this->setEmail($data['email']);
	}

	public function toArray()
	{
		$data = array();
		$data['id']			= $this->getId();
		$data['username']	= $this->getUsername();
		$data['password']	= $this->getPassword();
		$data['email']		= $this->getEmail();

		return $data;
	}
}

?>