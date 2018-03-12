 <?php 

class DayEntryManager extends CoreManager
{
	
	public function add(DayEntry $entry){
		$sql = ('INSERT INTO day_entry(account_id, d_start, theme) VALUES(:account_id, :d_start, :theme)');
		$values = [	":account_id"	=> $entry->getAccountId(),
					":d_start"		=> $entry->getDStart(),
					":theme"		=> $entry->getTheme()];
		$this->makeStatement($sql, $values);
		return true;		
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

		$month = !empty($_GET['month'])?$_GET['month']:date('m');
		$year = !empty($_GET['year'])?$_GET['year']:date('Y');

		$sql = ('SELECT id, theme, d_start FROM day_entry	WHERE account_id=:account_id 	
															AND MONTH(d_start)=:month 
															AND YEAR(d_start)=:year');
		$values = [":account_id"=>$account_id,
					":month"	=>$month,
					":year"		=>$year];
		return $this->makeSelect($sql, $values);
	}

	/**
	 * @param int (id de l'utilisateur)
	 *
	 * @return int (dernière entrée ajoutée par l'utilisateur.)
	 */
	public function getLast($account_id){
		$sql = ('SELECT MAX(id) FROM day_entry WHERE account_id=:account_id');
		$values = [":account_id"=>$account_id];
		return $this->makeSingleSelect($sql, $values)['MAX(id)'];
	}

	//Efface une plage de données si le paramètre d_end est spécifié.
	public function delete($account_id, $d_start, $d_end = NULL){
		if (empty($d_end)) {
			$sql = ('DELETE FROM day_entry WHERE account_id =:account_id AND d_start=:d_start');
			$values = [":account_id"=>$account_id, ":d_start"=>$d_start];
		}
		else{
			$sql = ('DELETE FROM day_entry WHERE account_id =:account_id AND d_start>=:d_start AND d_start<=:d_end');
			$values= [":account_id"=>$account_id, ":d_start"=>$d_start, ":d_end"=>$d_end];
		}


		$this->makeStatement($sql, $values);
	}

	public function getById($id){
		$sql = ('SELECT * FROM day_entry WHERE id=:id');
		$values = [":id"=> $id];
		return $this->makeSingleSelect($sql, $values); 
	}

	public function getCountByTheme($theme, $id){
		$sql = ('SELECT COUNT(*) FROM day_entry WHERE theme=:theme AND account_id=:id');
		$values = [':theme' => $theme, 'id' => $id];
		return $this->makeSingleSelect($sql, $values)['COUNT(*)'];
	}
}

 ?>