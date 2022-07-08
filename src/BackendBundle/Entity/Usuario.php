<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario", uniqueConstraints={@ORM\UniqueConstraint(name="uq_nombreUsuario", columns={"nombreUsuario"})}, indexes={@ORM\Index(name="fk_persona", columns={"idPersona"})})
 * @ORM\Entity
 * @UniqueEntity(fields="nombreusuario", message="¡Este usuario  ya existe!")
 */
class Usuario implements UserInterface, EquatableInterface, \Serializable {

    /**
     * @var integer
     *
     * @ORM\Column(name="idUsuario", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idusuario;

    /**
     * @var string
     *
     * @ORM\Column(name="nombreUsuario", type="string", length=45, nullable=false, unique=true)
     */
    private $nombreusuario;

    /**
     * @var string
     *
     * @ORM\Column(name="contrasena", type="string", length=20, nullable=false)
     */
    private $contrasena;

    /**
     * @var string
     *
     * @ORM\Column(name="rol", type="string", length=20, nullable=false)
     */
    private $rol;

    /**
     * @var \Persona
     *
     * @ORM\ManyToOne(targetEntity="Persona")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idPersona", referencedColumnName="idPersona")
     * })
     */
    private $idpersona;

    /**
     * Get idusuario
     *
     * @return integer
     */
    public function getIdusuario() {
        return $this->idusuario;
    }

    /**
     * Set nombreusuario
     *
     * @param string $nombreusuario
     *
     * @return Usuario
     */
    public function setNombreusuario($nombreusuario) {
        $this->nombreusuario = $nombreusuario;

        return $this;
    }

    /**
     * Get nombreusuario
     *
     * @return string
     */
    public function getNombreusuario() {
        return $this->nombreusuario;
    }

    /**
     * Set contrasena
     *
     * @param string $contrasena
     *
     * @return Usuario
     */
    public function setContrasena($contrasena) {
        $this->contrasena = $contrasena;

        return $this;
    }

    /**
     * Get contrasena
     *
     * @return string
     */
    public function getContrasena() {
        return $this->contrasena;
    }

    /**
     * Set rol
     *
     * @param string $rol
     *
     * @return Usuario
     */
    public function setRol($rol) {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return string
     */
    public function getRol() {
        return $this->rol;
    }

    /**
     * Set idpersona
     *
     * @param \BackendBundle\Entity\Persona $idpersona
     *
     * @return Usuario
     */
    public function setIdpersona(\BackendBundle\Entity\Persona $idpersona = null) {
        $this->idpersona = $idpersona;

        return $this;
    }

    /**
     * Get idpersona
     *
     * @return \BackendBundle\Entity\Persona
     */
    public function getIdpersona() {
        return $this->idpersona;
    }

    
    public function eraseCredentials() {
        
    }

    public function getPassword() {
        return $this->contrasena;
    }

    public function getRoles() {
        return array($this->getRol());
    }

    public function getSalt() {
        return null;
    }

    public function getUsername() {
        return $this->idpersona->getNombre() . ' ' . $this->idpersona->getPrimerapellido() . ' ' .  $this->idpersona->getSegundoapellido();
    }

    public function isEqualTo(UserInterface $user) {
        if ($user->getUsername() && $this->getNombreusuario()) {
            return true;
        } else {
            return false;
        }
    }

    public function serialize() {
        return serialize(array($this->idusuario, $this->nombreusuario, $this->idpersona, $this->contrasena));
    }

    public function unserialize($serialized) {
        list($this->idusuario, $this->nombreusuario, $this->idpersona, $this->contrasena) = unserialize($serialized);
    }

################################################################


}
