<?php 


require_once('Hydrator.trait.php');
/**
* 
*/
class Category
{
	private $name;
	private $type;
	private $color;
	
	function __construct($data)
	{
		$this->hydrate($data);
	}

	use Hydrator;


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = strip_tags(trim($name));

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     *
     * @return self
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }
}

 ?>