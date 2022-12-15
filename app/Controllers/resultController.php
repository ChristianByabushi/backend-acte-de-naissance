<?php

namespace App\Controllers;

use \App\Libraries\Oauth;
use \OAuth2\Request;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use App\Models\accountModel;
use App\Models\resultModelActo;

class resultController extends BaseController
{
	use ResponseTrait;
	protected $result;

	public function __construct()
	{
		$this->db = \config\Database::connect();
		$this->resultModel = new resultModelActo($this->db);
	}

	public function countActesWeeks($date = '')
	{
		$data =   $this->resultModel->countActesWeeks($date);
		return $this->respondCreated($data);
	}

	public function listOfActes($id)
	{
		$data =   $this->resultModel->listOfActesDeclarant($id); 
		return $this->respondCreated($data);
	}
}
