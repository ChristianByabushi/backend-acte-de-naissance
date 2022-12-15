<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class acteModel extends Model
{
	protected $db;
	public $session;
	public $tableinvoice;

	public function __construct(ConnectionInterface $db)
	{
		$this->db = $db;
		$this->tableact = $this->db->table('acte');
	}
	// public function getAllActes()
	// {
	// 	$query = "SELECT * FROM acte where deleted = 0";
	// 	return $this->db->query($query)->getResult();
	// }
	public function getActeInfo($id = '')
	{
		$query = "SELECT * FROM acte where idActe = $id and deleted =0";
		return $this->db->query($query)->getRow();
	}
	public function getActeInfoWithUserInfo($id = '')
	{
		$query = " SELECT * FROM users,acte, declarant WHERE 
		users.id = declarant.idUser AND 
		declarant.idDeclarant = acte.idDeclarant and				
		idActe = $id and declarant.deleted =0 AND acte.deleted =0";
		return $this->db->query($query)->getRow();
	}

	public function getAllActes()
	{
		$data =  $this->tableact->select('*')->orderBy("dateEnregistrement", 'desc')
			->getWhere(['deleted' => 0])->getResult();

		return $data;
	}
	public function addActes($data)
	{
		$this->tableact->insert($data);
		return true;
	}
	public function editActe($data, $id)
	{
		$this->db->table('acte')->where('idActe', $id)->update($data);
		return true;
	}
	public function deleteActe($id)
	{
		$this->tableact->where('idActe', $id)->update(["deleted" => 1]);
		return true;
	}
}
