<?php 

abstract class CoreManager
{
	
	static protected $_pdo;

	public function __construct(){
		if (empty(self::$_pdo)){
			try{
				self::$_pdo = new PDO('mysql:host=localhost;dbname=nouas_account;charset=utf8', 'nouas_BDD', 'fEr7S9nED3X47pC7', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
				// self::$_pdo = new PDO('mysql:host=localhost;dbname=planning;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

			}
			catch(Exception $e){
	      	  die('Erreur : '.$e->getMessage());
			}
		}
	}

	//Execute une requête préparée
	public function makeStatement($sql, $values){
		$req = self::$_pdo->prepare($sql);
		return $req->execute($values);
	}


	//Récupère de multiples entrées de la base de données.
	public function makeSelect($sql, $values = null){
		if ($values !== null) {
			$req = self::$_pdo->prepare($sql);
			$req->execute($values);
		} else{
			$req = self::$_pdo->query($sql);
		}

		return $req->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * Same function as makeSelect, but use it only for requests meant to have  a single result.
	 */
	public function makeSingleSelect($sql, $values = null){
		if ($values !== null) {
			$req = self::$_pdo->prepare($sql);
			
			foreach ($values as $key => $value) {
				$req->bindValue($key, $value);
			}

			$req->execute();

		} else{
			$req = self::$_pdo->query($sql);
		}

		return $req->fetch(PDO::FETCH_ASSOC);
	}

}

 ?>