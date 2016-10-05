<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Curso
 *
 * @ORM\Table(name="curso")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CursoRepository")
 */
class Curso
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="anio", type="string", length=10)
     */
    private $anio;

    /**
     * @var string
     * 
     * @ORM\Column(name="division", type="string", length=10)
     */
    private $division;

	 /**
     * @var decimal
     *
     * @ORM\Column(name="ciclo", type="decimal", precision=4, scale=0)
     */
    private $ciclo;
	
	/**
	 * @var array
	 *
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Alumno", mappedBy="curso")
	 */
	private $alumnos;
	
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set año
     *
     * @param string $año
     *
     * @return Curso
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Get anio
     *
     * @return string
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Set division
     *
     * @param string $division
     *
     * @return Curso
     */
    public function setDivision($division)
    {
        $this->division = $division;

        return $this;
    }

    /**
     * Get division
     *
     * @return string
     */
    public function getDivision()
    {
        return $this->division;
    }
	
	/**
     * Set ciclo
     *
     * @param decimal $ciclo
     *
     * @return Curso
     */
    public function setCiclo($ciclo)
    {
        $this->ciclo = $ciclo;

        return $this;
    }

    /**
     * Get ciclo
     *
     * @return decimal
     */
    public function getCiclo()
    {
        return $this->ciclo;
    }
	
	/**
     * Set alumnos
     *
     * @param array $alumnos
     *
     * @return Curso
     */
    public function setAlumnos($alumnos)
    {
        $this->alumnos = $alumnos;

        return $this;
    }

    /**
     * Get alumnos
     *
     * @return array
     */
    public function getAlumnos()
    {
        return $this->alumnos;
    }
	
	public function __construct($anio = null, $div = null, $ciclo = null){
		$this->setAnio($anio);
		$this->setDivision($div);
		$this->setCiclo($ciclo);
		$this->alumnos = new \Doctrine\Common\Collections\ArrayCollection();
	}
	
	public function addAlumno($alumno){
		$this->getAlumnos()[]=$alumno;
		return $this;
	}
	
	public function removeAlumno($alumno){
		$this->getAlumnos()->remove($alumno->getId());
		return $this;
	}
	
	public function __toString(){
		return $this->getAnio()." ".$this->getDivision()." - Ciclo ".$this->getCiclo();
	}
}