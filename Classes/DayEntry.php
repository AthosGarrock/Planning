<?php 

require_once('Hydrator.trait.php');
/**
* 
*/
class DayEntry
{	
    private $_id;
	private $_account_id;
    private $_d_start;
    private $_theme;

    use Hydrator;

	function __construct(array $data)
	{
        $this->hydrate($data);
	}

    /**
     * @return mixed
     */


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

    /**
     * @return mixed
     */
    public function getAccountId()
    {
        return $this->_account_id;
    }

    /**
     * @param mixed $_account_id
     *
     * @return self
     */
    public function setAccountId($_account_id)
    {
        $this->_account_id = $_account_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTheme()
    {
        return $this->_theme;
    }

    /**
     * @param mixed $_theme
     *
     * @return self
     */
    public function setTheme($_theme)
    {
        $this->_theme = $_theme;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDStart()
    {
        return $this->_d_start;
    }

    /**
     * @param mixed $_d_start
     *
     * @return self
     */
    public function setDStart($_d_start)
    {
        $this->_d_start = $_d_start;

        return $this;
    }
}

 ?>