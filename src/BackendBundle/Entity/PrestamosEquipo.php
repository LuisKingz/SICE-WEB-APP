<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PrestamosEquipo
 *
 * @ORM\Table(name="prestamos_equipo", indexes={@ORM\Index(name="fk_equipo", columns={"idEquipo"}), @ORM\Index(name="fk_prestador", columns={"idPrestador"}), @ORM\Index(name="fk_solicitante", columns={"idSolicitante"})})
 * @ORM\Entity
 */
class PrestamosEquipo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idPrestamo", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idprestamo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaPrestamo", type="datetime", nullable=false)
     */
    private $fechaprestamo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaEntrega", type="datetime", nullable=true)
     */
    private $fechaentrega;

    /**
     * @var \Equipos
     *
     * @ORM\ManyToOne(targetEntity="Equipos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEquipo", referencedColumnName="idEquipos")
     * })
     */
    private $idequipo;

    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idPrestador", referencedColumnName="idUsuario")
     * })
     */
    private $idprestador;

    /**
     * @var \Persona
     *
     * @ORM\ManyToOne(targetEntity="Persona")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idSolicitante", referencedColumnName="idPersona")
     * })
     */
    private $idsolicitante;



    /**
     * Get idprestamo
     *
     * @return integer
     */
    public function getIdprestamo()
    {
        return $this->idprestamo;
    }

    /**
     * Set fechaprestamo
     *
     * @param \DateTime $fechaprestamo
     *
     * @return PrestamosEquipo
     */
    public function setFechaprestamo($fechaprestamo)
    {
        $this->fechaprestamo = $fechaprestamo;

        return $this;
    }

    /**
     * Get fechaprestamo
     *
     * @return \DateTime
     */
    public function getFechaprestamo()
    {
        return $this->fechaprestamo;
    }

    /**
     * Set fechaentrega
     *
     * @param \DateTime $fechaentrega
     *
     * @return PrestamosEquipo
     */
    public function setFechaentrega($fechaentrega)
    {
        $this->fechaentrega = $fechaentrega;

        return $this;
    }

    /**
     * Get fechaentrega
     *
     * @return \DateTime
     */
    public function getFechaentrega()
    {
        return $this->fechaentrega;
    }

    /**
     * Set idequipo
     *
     * @param \BackendBundle\Entity\Equipos $idequipo
     *
     * @return PrestamosEquipo
     */
    public function setIdequipo(\BackendBundle\Entity\Equipos $idequipo = null)
    {
        $this->idequipo = $idequipo;

        return $this;
    }

    /**
     * Get idequipo
     *
     * @return \BackendBundle\Entity\Equipos
     */
    public function getIdequipo()
    {
        return $this->idequipo;
    }

    /**
     * Set idprestador
     *
     * @param \BackendBundle\Entity\Usuario $idprestador
     *
     * @return PrestamosEquipo
     */
    public function setIdprestador(\BackendBundle\Entity\Usuario $idprestador = null)
    {
        $this->idprestador = $idprestador;

        return $this;
    }

    /**
     * Get idprestador
     *
     * @return \BackendBundle\Entity\Usuario
     */
    public function getIdprestador()
    {
        return $this->idprestador;
    }

    /**
     * Set idsolicitante
     *
     * @param \BackendBundle\Entity\Persona $idsolicitante
     *
     * @return PrestamosEquipo
     */
    public function setIdsolicitante(\BackendBundle\Entity\Persona $idsolicitante = null)
    {
        $this->idsolicitante = $idsolicitante;

        return $this;
    }

    /**
     * Get idsolicitante
     *
     * @return \BackendBundle\Entity\Persona
     */
    public function getIdsolicitante()
    {
        return $this->idsolicitante;
    }
}
