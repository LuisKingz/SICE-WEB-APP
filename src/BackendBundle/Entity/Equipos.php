<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Equipos
 *
 * @ORM\Table(name="equipos", uniqueConstraints={@ORM\UniqueConstraint(name="uq_numControl", columns={"numeroControl"})})
 * @ORM\Entity
 * @UniqueEntity(fields="numerocontrol", message="¡Numero de control existente!")
 */
class Equipos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idEquipos", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idequipos;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreEquipo", type="string", length=100, nullable=false)
     */
    private $nombreequipo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", length=65535, nullable=false)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroControl", type="string", length=15, nullable=false)
     */
    private $numerocontrol;

    /**
     * @var integer
     *
     * @ORM\Column(name="estadoEquipo", type="integer", nullable=false)
     */
    private $estadoequipo;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoEquipo", type="string", length=50, nullable=false)
     */
    private $tipoequipo;



    /**
     * Get idequipos
     *
     * @return integer
     */
    public function getIdequipos()
    {
        return $this->idequipos;
    }

    /**
     * Set nombreequipo
     *
     * @param string $nombreequipo
     *
     * @return Equipos
     */
    public function setNombreequipo($nombreequipo)
    {
        $this->nombreequipo = $nombreequipo;

        return $this;
    }

    /**
     * Get nombreequipo
     *
     * @return string
     */
    public function getNombreequipo()
    {
        return $this->nombreequipo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Equipos
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set numerocontrol
     *
     * @param string $numerocontrol
     *
     * @return Equipos
     */
    public function setNumerocontrol($numerocontrol)
    {
        $this->numerocontrol = $numerocontrol;

        return $this;
    }

    /**
     * Get numerocontrol
     *
     * @return string
     */
    public function getNumerocontrol()
    {
        return $this->numerocontrol;
    }

    /**
     * Set estadoequipo
     *
     * @param integer $estadoequipo
     *
     * @return Equipos
     */
    public function setEstadoequipo($estadoequipo)
    {
        $this->estadoequipo = $estadoequipo;

        return $this;
    }

    /**
     * Get estadoequipo
     *
     * @return integer
     */
    public function getEstadoequipo()
    {
        return $this->estadoequipo;
    }

    /**
     * Set tipoequipo
     *
     * @param string $tipoequipo
     *
     * @return Equipos
     */
    public function setTipoequipo($tipoequipo)
    {
        $this->tipoequipo = $tipoequipo;

        return $this;
    }

    /**
     * Get tipoequipo
     *
     * @return string
     */
    public function getTipoequipo()
    {
        return $this->tipoequipo;
    }
}
