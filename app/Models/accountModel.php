<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class accountModel extends Model
{
	protected $db;
	public $tableaccount;

	public function __construct(ConnectionInterface $db)
	{
		$this->db = $db;
		$this->table_account = $this->db->table('oauth_users');
	}

	public function getAllUsers($type)
	{
		$condscope = '';
		// if ($type != '') {
		// 	$type = " scope = '$type'";
		// }
		if ($type == '')
			$condscope = ' ';
		else
			$condscope = " scope = '$type' and ";

		$query = "SELECT id, firstname, email, lastname, 
		scope, created_at, stateaccount FROM users 
		where " . $condscope . "   scope !='admin' and deleted = 0 order by created_at desc";
		return $this->db->query($query)->getResult();
	}
	public function deleteAccount($id)
	{
		$this->db->table('users')->where('id', $id)->update(['deleted' => 1]);
	}
	public function unandlockAccount($id)
	{
		$this->db->table('users')->where('id', $id)->update(['stateaccount' => 1]);
	}

	public function addUser($data)
	{
		return $this->table_account->insert($data);
	}

	public function addClient($data)
	{
		return $this->db->table('oauth_clients')->insert($data);
	}
	public function addDeclarant($data)
	{
		return $this->db->table('declarant')->insert($data);
	}

	public function getDeclarant($data = '')
	{
		$query = "SELECT declarant.idDeclarant, declarant.residence, 
		declarant.bornin, users.firstname, users.lastname, 
		users.email, declarant.professsion,declarant.etat_civil, 
		sexe FROM  users, declarant 
		WHERE users.id = declarant.idUser AND declarant.deleted = 0 order by idDeclarant desc ";
		$r =  $this->db->query($query)->getResult();
		return $r;
	}
	public function oneDeclarant($id = '')
	{
		$query = "SELECT declarant.idDeclarant, declarant.residence, 
		declarant.bornin, users.firstname, users.lastname,
		users.email, declarant.professsion,declarant.etat_civil, 
		sexe FROM  users, declarant 
		WHERE users.id = declarant.idUser AND declarant.idDeclarant=$id
		and declarant.deleted = 0";
		$r =  $this->db->query($query)->getRow();
		return $r;
	}

	public function deletedDeclarant($id)
	{
		$this->db->table('declarant')->where('idDeclarant', $id)->update(['deleted' => 1]);
		//delete decl inside of users 
		$idUser = $this->db->table('declarant')->select('idUser')->getWhere(["idDeclarant" => $id])->getRow();
		$id = $idUser->idUser;
		$this->db->table('oauth_clients')->delete(['user_id' => $id]);
		return true;
	}


	public function editDeclarant($data, $id)
	{
		$this->db->table('declarant')->where('idDeclarant', $id)->update($data);
		return true;
	}

	public function getInforAccount($email = null)
	{
		$query = "SELECT users.firstname as firstname, users.lastname as
		 lastname, users.id as id, users.email as email, users.scope  from users
		where users.email = '$email' and deleted = 0 and stateaccount = 0";
		return $this->db->query($query)->getRow();
	}
	public function getInfoByid($id = null)
	{
		$query = "SELECT users.id, users.firstname as firstname, users.lastname as
		 lastname, users.id as id, users.email as email, users.scope, users.stateaccount  from users
		where users.id = '$id' and deleted = 0 and stateaccount = 0";
		return $this->db->query($query)->getRow();
	}


	//username is my id according to the structure the token algo used
	public function updateUser($array = [], $id = '')
	{
		$this->table_account->where('username', $id)->update($array);
	}

	public function verifyUserPassword($password, $email)
	{
		$query = "SELECT * FROM `oauth_clients` WHERE `client_id` = '$email' AND `client_secret` = '$password' ";
		return $this->db->query($query)->getRow();
	}

	public function verifyNewEmail($new_email)
	{
		$query = "SELECT * FROM `oauth_clients` WHERE `client_id` = '$new_email'";
		return $this->db->query($query)->getRow();
	}

	public function updateClient($data = [], $email = '')
	{
		$this->db->table('oauth_clients')->where('client_id', $email)->update($data);
	}
}
