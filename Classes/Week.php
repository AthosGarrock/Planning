<?php 

require_once ("Hydrator.trait.php");

class Week
{
	
	private $_de_fk;

	private $_mon;
	private $_tue;
	private $_wed;
	private $_thu;
	private $_fri;
	private $_sat;
	private $_sun;

	use Hydrator;

	function __construct(array $data)
	{
		$this->hydrate($data);
	}


    public function getWeek(){
        $days =              [  ":de_fk"        => $this->_de_fk,
                                ":mon"          => $this->_mon,
                                ":tue"          => $this->_tue,
                                ":wed"          => $this->_wed,
                                ":thu"          => $this->_thu,
                                ":fri"          => $this->_fri,
                                ":sat"          => $this->_sat,
                                ":sun"          => $this->_sun];
        return $days;
    }


    /**
     * @param mixed $_mon
     *
     * @return self
     */
    public function setMon($_mon)
    {
        $this->_mon = $_mon;

        return $this;
    }

    /**
     * @param mixed $_tue
     *
     * @return self
     */
    public function setTue($_tue)
    {
        $this->_tue = $_tue;

        return $this;
    }

    /**
     * @param mixed $_wed
     *
     * @return self
     */
    public function setWed($_wed)
    {
        $this->_wed = $_wed;

        return $this;
    }

    /**
     * @param mixed $_thu
     *
     * @return self
     */
    public function setThu($_thu)
    {
        $this->_thu = $_thu;

        return $this;
    }

    /**
     * @param mixed $_fri
     *
     * @return self
     */
    public function setFri($_fri)
    {
        $this->_fri = $_fri;

        return $this;
    }

    /**
     * @param mixed $_sat
     *
     * @return self
     */
    public function setSat($_sat)
    {
        $this->_sat = $_sat;

        return $this;
    }

    /**
     * @param mixed $_sun
     *
     * @return self
     */
    public function setSun($_sun)
    {
        $this->_sun = $_sun;

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
}

 ?>