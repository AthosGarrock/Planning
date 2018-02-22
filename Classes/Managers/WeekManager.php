<?php 
/**
* 
*/
class WeekManager extends CoreManager
{

	public function add(Week $week){
		$sql = ('INSERT INTO week(de_fk, mon, tue, wed, thu, fri, sat, sun) VALUES(:de_fk, :mon, :tue, :wed, :thu, :fri, :sat, :sun)');
		
		$values = $week->getWeek();

		$this->makeStatement($sql, $values);		
	}

	public function update(Week $week){
		$sql = ('UPDATE week SET mon=:mon, tue=:tue, wed=:wed, thu=:thu, fri=:fri, sat=:sat, sun=:sun WHERE de_fk = :de_fk ');
		
		$values = $week->getWeek();
		$this->makeStatement($sql, $values);
	}

	public function get($de_fk){
		$sql = ('SELECT * FROM week WHERE de_fk=:de_fk');
		$values = [":de_fk"=>$de_fk];
		return $this->makeSingleSelect($sql, $values); 
	}

	public function delete($account_id, $date){
		$sql = ('DELETE FROM week WHERE de_fk=:de_fk');
		$values = [":de_fk"=>$de_fk];
		$this->makeStatement($sql, $values);
	}

}

 ?>