<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"usuario" = "Usuario", "alumno" = "Alumno"})
 * 
 */
class Usuario extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * 
     * @ORM\Column(name="nombre", type="string", length=50,nullable=true)
     */
	protected $nombre;
	
	/**
     * 
     * @ORM\Column(name="fecha_nacimiento", type="date",nullable=true)
     */
	protected $fechaNacimiento;
	
	public function __construct($nombre="usuario",$fechaNacimiento=null)
    {
        parent::__construct();
		$this->setNombre($nombre);
		$this->setFechaNacimiento($fechaNacimiento);
    }
	
	public function getId(){
		return $this->id;
	}
	

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Usuario
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set fecha_nacimiento
     *
     * @param Date $fechaNacimiento
     *
     * @return Usuario
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fecha_nacimiento
     *
     * @return Date
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }
	
	public function edad(){
		$hoy = new \DateTime('NOW');
		$diff = $hoy->diff($this->getFechaNacimiento());
		return $diff->format('%y años');
	}
	
	public function clase(){
		return get_class($this);
	}
}
