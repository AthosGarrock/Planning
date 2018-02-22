 <?php 

class DayEntryManager extends CoreManager
{
	
	public function add(DayEntry $entry){
		$sql = ('INSERT INTO day_entry(account_id, d_start, d_end, theme) VALUES(:account_id, :d_start, :d_end, :theme)');
		$values = [	":account_id"	=> $entry->getAccountId(),
					":d_start"		=> $entry->getDStart(),
					":d_end"		=> $entry->getDEnd(),
					":theme"		=> $entry->getTheme()];
		$this->makeStatement($sql, $values);		
	}

	public function update(DayEntry $entry){
		$sql = ('UPDATE day_entry SET theme = :theme WHERE account_id = :account_id AND d_start = :d_start ');
		$values = [	':account_id'	=> $entry->getAccountId(),
					':d_start' 		=> $entry->getDStart(),
					':theme'		=> $entry->getTheme() ];
		$this->makeStatement($sql, $values);
	}

	public function get($account_id, $d_start){
		$sql = ('SELECT * FROM day_entry WHERE account_id=:account_id AND d_start=:d_start');
		$values = [	":account_id"	=> trim($account_id), 
					":d_start"		=> trim($d_start)];
		return $this->makeSingleSelect($sql, $values); 
	}

	//Need to turn it into "monthly query" function to make lighter results
	public function getAllThemes($account_id){
		$sql = ('SELECT id, theme, d_start, d_end FROM day_entry WHERE account_id=:account_id');
		$values = [":account_id"=>$account_id];
		return $this->makeSelect($sql, $values);
	}



	public function getLast($account_id){
		$sql = ('SELECT MAX(id) FROM day_entry WHERE account_id=:account_id');
		$values = [":account_id"=>$account_id];
		return $this->makeSingleSelect($sql, $values);
	}


	public function delete($account_id, $d_start){
		$sql = ('DELETE FROM day_entry WHERE account_id =:account_id AND d_start=:d_start');
		$values = [":account_id"=>$account_id, ":d_start"=>$d_start];
		$this->makeStatement($sql, $values);
	}

	public function getById($id){
		$sql = ('SELECT * FROM day_entry WHERE id=:id');
		$values = [":id"=> $id];
		return $this->makeSingleSelect($sql, $values); 
	}
}

 ?>