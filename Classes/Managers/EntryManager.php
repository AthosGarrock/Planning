<?php 

class EntryManager extends CoreManager
{
	
	public function add(Entry $entry){
		$sql = ('INSERT INTO entry(de_fk, activite, e_start, content) VALUES(:de_fk, :activite, :e_start, :content)');
		$values = [	":de_fk"	=>$entry->getDeFk(),
					":activite"	=>$entry->getActivite(),
					":e_start"	=>$entry->getEStart(),
					":content"	=>$entry->getContent()	];

		$this->makeStatement($sql, $values);		
	}

	public function update(Entry $entry){
		$sql = ('UPDATE entry SET activite=:activite, e_start=:e_start, content=:content WHERE id=:id');
		$values = [	":id"		=>$entry->getId(),
					":activite"	=>$entry->getActivite(),
					":e_start"	=>$entry->getEStart(),
					":content"	=>$entry->getContent()	];

		$this->makeStatement($sql, $values);
	}

	public function get($id){
		$sql = ('SELECT * FROM entry WHERE id = :id');
		$values = [':id'=> $id];
		
		return new Entry($this->makeSingleSelect($sql, $values));
	}

	public function getAllByDay($de_fk){
		$sql = ('SELECT * FROM entry WHERE de_fk= :de_fk ORDER BY e_start');
		$values = [':de_fk'=> $de_fk];

		return $this->makeSelect($sql, $values);
	}

	public function delete($id){
		$sql = ('DELETE FROM entry WHERE id = :id');
		$values = [':id' => $id];

		$this->makeStatement($sql, $values);
	}
}

 ?>