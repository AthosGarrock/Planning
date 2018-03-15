<?php 


require_once('Hydrator.trait.php');
/**
* 
*/
class Category
{
    private $id;
	private $name;
    private $initials;
	private $type;
	private $color;
	
	function __construct($data)
	{
		$this->hydrate($data);
	}

	use Hydrator;


    /**
     * @return mixed. Replaces spaces without underscores if option is true.
     */
    public function getName($opt = false)
    {
        if (!$opt) {
            return $this->name;
        }else{
            return str_replace('_', ' ', $this->name);
        }
        
    }


    /**
     * @param mixed $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = str_replace(' ', '_', strip_tags(trim($name)));

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

    /**
     * @return mixed
     */
    public function getInitials()
    {
        return $this->initials;
    }

    /**
     * @param mixed $initials
     *
     * @return self
     */
    public function setInitials($initials)
    {
        $this->initials = $initials;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}

 ?>