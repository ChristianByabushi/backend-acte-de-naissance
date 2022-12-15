<?php

namespace App\Controllers;

use \App\Libraries\Oauth;
use \OAuth2\Request;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use App\Models\accountModel;
use App\Models\acteModel;

class actenaissance extends BaseController
{
	use ResponseTrait;
	protected $acteModel;

	public function __construct()
	{
		$this->db = \config\Database::connect();
		$this->accountModel = new accountModel($this->db);
		$this->acteModel = new acteModel($this->db);
	}

	public function getAllActes()
	{
		$data = $this->acteModel->getAllActes();
		return $this->respond($data);
	} 

	public function getActeInfo($id)
	{
		$data = $this->acteModel->getActeInfo($id);
		return $this->respond($data);
	}
	public function getActeInfoWithUserInfo($id)
	{
		$data = $this->acteModel->getActeInfoWithUserInfo($id);
		return $this->respond($data);
	}
	
	public function addActe()
	{
		helper('form');
		$rules = [
			'idDeclarant' =>  'is_not_unique[declarant.idDeclarant]',
		];
		if (!$this->validate($rules)) {
			$data = [
				'error' => implode('<br>', $this->validator->getErrors()),
				'errorstate' => true
			];
			return $this->respond($data);
		} else {
			$data = [
				"idActe" => null,
				"nom" => $this->request->getVar("nom"),
				"postnom" => $this->request->getVar("postnom"),
				"prenom" => $this->request->getVar("prenom"),
				"sexe" => $this->request->getVar("sexe"),
				"dateNaissance" => $this->request->getVar("dateNaissance"),
				"lieuNaissance" => $this->request->getVar("lieuNaissance"),
				"nationalite" => $this->request->getVar("nationalite"),
				"nomPere" => $this->request->getVar("nomPere"),
				"nomMere" => $this->request->getVar("nomMere"),
				"province" => $this->request->getVar("province"),
				"ville" => $this->request->getVar("ville"),
				"origine" => $this->request->getVar("origine"),
				"commune" => $this->request->getVar("commune"),
				"territoire" => $this->request->getVar("territoire"),
				"quartier" => $this->request->getVar("quartier"),
				"avenue" => $this->request->getVar("avenue"),
				"numero" => $this->request->getVar("numero"),
				"dateEnregistrement" => $this->request->getVar("dateEnregistrement"),
				"idDeclarant" => $this->request->getVar("idDeclarant"),
				"deleted" => 0,
			];
			$this->acteModel->addActes($data);
		}
		return $this->respond($data);
	}
	public function editActe($id)
	{
		helper('form');
		$rules = [
			'idActe' =>  'is_not_unique[acte.idActe]',
			'idDeclarant' =>  'is_not_unique[declarant.idDeclarant]',
		];
		if (!$this->validate($rules)) {
			$data = [
				'error' => implode('<br>', $this->validator->getErrors()),
				'errorstate' => true
			];
			return $this->respond($data);
		} else {
			$data = [
				"nom" => $this->request->getVar("nom"),
				"postnom" => $this->request->getVar("postnom"),
				"prenom" => $this->request->getVar("prenom"),
				"sexe" => $this->request->getVar("sexe"),
				"dateNaissance" => $this->request->getVar("dateNaissance"),
				"lieuNaissance" => $this->request->getVar("lieuNaissance"),
				"nationalite" => $this->request->getVar("nationalite"),
				"nomPere" => $this->request->getVar("nomPere"),
				"nomMere" => $this->request->getVar("nomMere"),
				"province" => $this->request->getVar("province"),
				"ville" => $this->request->getVar("ville"),
				"origine" => $this->request->getVar("origine"),
				"commune" => $this->request->getVar("commune"),
				"territoire" => $this->request->getVar("territoire"),
				"quartier" => $this->request->getVar("quartier"),
				"avenue" => $this->request->getVar("avenue"),
				"numero" => $this->request->getVar("numero"),
				"dateEnregistrement" => $this->request->getVar("dateEnregistrement"),
				"idDeclarant" => $this->request->getVar("idDeclarant"),
			];
		}

		$this->acteModel->editActe($data, $id);
		return $this->respond($data);
	}
	public function deleteActe($id)
	{
		$this->acteModel->deleteActe($id);
		return $this->respond("item removed");
	}
}
