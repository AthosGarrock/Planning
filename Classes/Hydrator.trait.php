<?php 

	trait Hydrator{
		public function hydrate(array $data){
	        foreach ($data as $key => $value) {
	            $method = 'set'.str_replace(' ', '',ucwords(str_replace('_',' ',$key)));
	            if (method_exists($this, $method)) {
	                $this->$method($value);
	            }       
	        }
    	}
	}

 ?>