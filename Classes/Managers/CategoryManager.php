<?php 

class CategoryManager extends CoreManager
{
	
	public function add(Category $category){
		$sql = ('INSERT INTO categories(name, initials, type, color) VALUES(:name, :initials, :type, :color)');
		$values = [	":name"		=> $category->getName(),
					":initials" => $category->getInitials(),
					":type"		=> $category->getType(),
					":color"	=> $category->getColor()];
		$this->makeStatement($sql, $values);		
	}

	public function update(Category $category){
		$sql = ('UPDATE categories SET name = :name, initials = :initials, color = :color WHERE id = :id');
		$values = [	':name' => $category->getName(),
					":initials" => $category->getInitials(),
					':color' => $category->getColor(),
					':id' =>$category->getId()];

		$this->makeStatement($sql, $values);
	}

	public function get($val){
		if (ctype_digit($val) OR is_int($val)) {
			$sql = ('SELECT * FROM categories WHERE id = :id ');
			$values = [":id"=> trim($val)];
			return new Category($this->makeSingleSelect($sql, $values)); 
		} else{
			$sql = ('SELECT * FROM categories WHERE name = :name ');
			$values = [":name"=> trim($val)];
			return new Category($this->makeSingleSelect($sql, $values)); 			
		}
	}

	//Retourne l'alias d'une catégorie
	public function getThemeIni($name){
		$sql = ('SELECT initials FROM categories WHERE name = :name AND type="theme"');
		$values = [":name"=> trim($name)];
		return $this->makeSingleSelect($sql, $values)['initials']; 
	}

	//Retourne tout.
	public function getAll(){
		return $this->makeSelect(('SELECT * FROM categories'));
	}

	//Retourne tous les thèmes quotidiens
	public function getAllThemes(){
		return $this->makeSelect(('SELECT * FROM categories WHERE type="theme"'));
	}


	//Retourne toutes les activités
	public function getAllActivites(){
		return $this->makeSelect(('SELECT * FROM categories WHERE type="activite"'));
	}

	//Retourne les nom d'activité.
	public function getAllActNames(){
		return $this->makeSelect(('SELECT name FROM categories WHERE type="activite"'));
	}

	public function delete($id){
		$sql = ('DELETE FROM categories WHERE id = :id');
		$values = [":id"=>$id];
		$this->makeStatement($sql, $values);
	}

}


 ?>