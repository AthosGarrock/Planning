<?php 

/**
* 
*/
class AccountManager extends CoreManager
{
	public function get($nom){
		$sql = ('SELECT nom, prenom FROM account_details WHERE nom LIKE :nom OR prenom LIKE :prenom ORDER BY prenom, nom LIMIT 10');
		$values = [	":nom"		=> '%'.ucfirst(trim($nom)).'%',
					":prenom"	=> '%'.ucfirst(trim($nom)).'%'];
		return $this->makeSelect($sql, $values); 
	}

	public function getId($fullname){
		$sql = ('SELECT account_id FROM account_details WHERE nom = :nom AND prenom LIKE :prenom');

		$fn = explode(' ', $fullname);

		$values = [	":nom"		=> ucfirst(trim($fn[1])),
					":prenom"	=> ucfirst(trim($fn[0]))];
		return $this->makeSingleSelect($sql, $values)['account_id']; 
	}
}

 ?>