<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Persona
 *
 * @ORM\Table(name="persona", uniqueConstraints={@ORM\UniqueConstraint(name="uq_matricula", columns={"matricula"})})
 * @ORM\Entity
 * @UniqueEntity(fields="matricula", message="Matrícula ya registrada  ")
 */
class Persona
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idPersona", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpersona;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=45, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="primerApellido", type="string", length=45, nullable=false)
     */
    private $primerapellido;

    /**
     * @var string
     *
     * @ORM\Column(name="segundoApellido", type="string", length=45, nullable=false)
     */
    private $segundoapellido;

    /**
     * @var string
     *
     * @ORM\Column(name="matricula", type="string", length=15, nullable=true)
     */
    private $matricula;



    /**
     * Get idpersona
     *
     * @return integer
     */
    public function getIdpersona()
    {
        return $this->idpersona;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Persona
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
     * Set primerapellido
     *
     * @param string $primerapellido
     *
     * @return Persona
     */
    public function setPrimerapellido($primerapellido)
    {
        $this->primerapellido = $primerapellido;

        return $this;
    }

    /**
     * Get primerapellido
     *
     * @return string
     */
    public function getPrimerapellido()
    {
        return $this->primerapellido;
    }

    /**
     * Set segundoapellido
     *
     * @param string $segundoapellido
     *
     * @return Persona
     */
    public function setSegundoapellido($segundoapellido)
    {
        $this->segundoapellido = $segundoapellido;

        return $this;
    }

    /**
     * Get segundoapellido
     *
     * @return string
     */
    public function getSegundoapellido()
    {
        return $this->segundoapellido;
    }

    /**
     * Set matricula
     *
     * @param string $matricula
     *
     * @return Persona
     */
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;

        return $this;
    }

    /**
     * Get matricula
     *
     * @return string
     */
    public function getMatricula()
    {
        return $this->matricula;
    }
}
