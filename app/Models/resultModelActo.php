<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class resultModelActo extends Model
{
	protected $db;
	public $session;
	public $tableResult;

	public function __construct(ConnectionInterface $db)
	{
		$this->db = $db;
		$this->tableResult = $this->db->table('servicemessage');
	}
	public function countActesWeeks($date='')
	{
		$query1 = "SELECT COUNT(DISTINCT acte.idActe) AS numberActe FROM acte 
		WHERE acte.dateEnregistrement >= '$date'";
		$query2 = "SELECT COUNT(DISTINCT users.id) AS numberDeclarant FROM users 
		WHERE users.scope LIKE '%decl%'";
		$data = [
			'totaldeclarant' => $this->db->query($query2)->getRow(),
			'totalactenaissance' => $this->db->query($query1)->getRow(),
		];
		return $data;
	}
	public function listOfActesDeclarant($id){
		$query ="SELECT acte.idActe, acte.postnom, acte.nom, acte.lieuNaissance, acte.sexe, acte.nomPere, acte.nomMere
		,acte.ville
		 FROM acte, declarant, users
		WHERE 
		acte.idDeclarant = declarant.idDeclarant AND 
		declarant.idUser = users.id AND 
		users.id = $id";
		$this->db->query($query)->getResult();
	}
}
