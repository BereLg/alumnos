<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Usuario as Usuario;

/**
 * Alumno
 *
 * @ORM\Table(name="alumno")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AlumnoRepository")
 */
class Alumno extends Usuario
{
	/**
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Curso", inversedBy="alumnos")
     * @ORM\JoinColumn(name="curso_id", referencedColumnName="id")
	 */
	private $curso;
	
	/**
     * 
     * @ORM\Column(name="dni", type="string", length=8, unique=true)
     */
	private $dni;
	
	/**
     * 
     * @ORM\Column(name="sexo", type="string", length=1)
     */
	private $sexo;
	
    /**
     * Set curso
     *
     * @param Curso $curso
     *
     * @return Alumno
     */
    public function setCurso($curso)
    {
        $this->curso = $curso;

        return $this;
    }

    /**
     * Get curso
     *
     * @return Curso
     */
    public function getCurso()
    {
        return $this->curso;
    }
	
	/**
     * Set dni
     *
     * @param string $dni
     *
     * @return Usuario
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get dni
     *
     * @return string
     */
    public function getDni()
    {
        return $this->dni;
    }
	
	/**
     * Set sexo
     *
     * @param string $sexo
     *
     * @return Usuario
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return string
     */
    public function getSexo()
    {
        return $this->sexo;
    }
	
	public function __construct($dni=null, $nombre=null, $fechaNacimiento=null, $sexo=null, $curso=null){
		parent::__construct($nombre,$fechaNacimiento);
		$this->setDni($dni);
		$this->setCurso($curso);
		$this->setSexo($sexo);
	}
}

