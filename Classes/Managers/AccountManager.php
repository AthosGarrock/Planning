<?php 

/**
* 
*/
class AccountManager extends CoreManager
{
	public function get($nom){
		$sql = ('SELECT nom, prenom FROM account_details WHERE nom LIKE :nom OR prenom LIKE :prenom ORDER BY prenom, nom');
		$values = [	":nom"		=> '%'.ucfirst(trim($nom)).'%',
					":prenom"	=> '%'.ucfirst(trim($nom)).'%'];
		return $this->makeSelect($sql, $values); 
	}
}

 ?>