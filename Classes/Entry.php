<?php 

require_once('Hydrator.trait.php');
/**
* 
*/
class Entry implements JsonSerializable
{
    private $_id;
	private $_de_fk;
	private $_activite;
	private $_e_start;
	private $_content;

    use Hydrator;

	function __construct(array $data)
	{
		$this->hydrate($data);
	}

    //Retourne un tableau utilisable par la fonction json_encode
    public function jsonSerialize(){
        $array = [];
        foreach ($this as $key => $value) {
            $array[str_replace('_', '', $key)] = $value;
        }

        return $array;
    }




    /**
     * @return mixed
     */
    public function getActivite()
    {
        return $this->_activite;
    }

    /**
     * @param mixed $_activite
     *
     * @return self
     */
    public function setActivite($_activite)
    {
        $this->_activite = $_activite;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEStart()
    {
        return $this->_e_start;
    }

    /**
     * @param mixed $_start
     *
     * @return self
     */
    public function setEStart($_e_start)
    {
        $this->_e_start = $_e_start;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEEnd()
    {
        return $this->_e_end;
    }

    /**
     * @param mixed $_end
     *
     * @return self
     */
    public function setEEnd($_e_end)
    {
        $this->_e_end = $_e_end;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->_content;
    }

    /**
     * @param mixed $_content
     *
     * @return self
     */
    public function setContent($_content)
    {
        $this->_content = $_content;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeFk()
    {
        return $this->_de_fk;
    }

    /**
     * @param mixed $_de_fk
     *
     * @return self
     */
    public function setDeFk($_de_fk)
    {
        $this->_de_fk = $_de_fk;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param mixed $_id
     *
     * @return self
     */
    public function setId($_id)
    {
        $this->_id = $_id;

        return $this;
    }
}

 ?>