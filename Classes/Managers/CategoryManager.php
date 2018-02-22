<?php 

class CategoryManager extends CoreManager
{
	
	public function add(Category $category){
		$sql = ('INSERT INTO categories(name, type, color) VALUES(:name, :type, :color)');
		$values = [	":name"		=> $category->getName(),
					":type"		=> $category->getType(),
					":color"	=> $category->getColor()];
		$this->makeStatement($sql, $values);		
	}

	// public function update(DayEntry $category, $fname){
	// 	$sql = ('UPDATE categories SET name = :name, type = :type, color = :color WHERE name = :f_name');
	// 	$values = [	':name' => $category->getName(),
	// 				':type' => $category->getType(),
	// 				':color' => $category->getColor(),
	//				':'];

	// 	$this->makeStatement($sql, $values);
	// }

	public function get($name){
		$sql = ('SELECT * FROM categories WHERE name = :name ');
		$values = [":name"=> trim($name)];
		return $this->makeSingleSelect($sql, $values); 
	}

	public function getAll(){
		return $this->makeSelect(('SELECT * FROM categories'));
	}

	public function getAllThemes(){
		return $this->makeSelect(('SELECT * FROM categories WHERE type="theme"'));
	}

	public function getAllActivites(){
		return $this->makeSelect(('SELECT * FROM categories WHERE type="activite"'));
	}

	public function getAllActNames(){
		return $this->makeSelect(('SELECT name FROM categories WHERE type="activite"'));
	}

	public function delete($name){
		$sql = ('DELETE FROM categories WHERE name = :name');
		$values = [":name"=>trim($name)];
		$this->makeStatement($sql, $values);
	}

}


 ?>