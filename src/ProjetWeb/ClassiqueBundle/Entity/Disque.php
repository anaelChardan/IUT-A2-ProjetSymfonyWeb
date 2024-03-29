<?php

namespace ProjetWeb\ClassiqueBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Disque
 *
 * @ORM\Table(name="Disque", indexes={@ORM\Index(name="IDX_F200E9945B515BDB", columns={"Code_Album"})})
 * @ORM\Entity(repositoryClass="ProjetWeb\ClassiqueBundle\Repository\Disque")
 */
class Disque
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Code_Disque", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeDisque;

    /**
     * @var string
     *
     * @ORM\Column(name="Référence_Album", type="string", length=200, nullable=false)
     */
    private $référenceAlbum;

    /**
     * @var string
     *
     * @ORM\Column(name="Référence_Disque", type="string", length=10, nullable=true)
     */
    private $référenceDisque;

    /**
     * @var Album
     *
     * @ORM\ManyToOne(targetEntity="Album", inversedBy="disques")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Code_Album", referencedColumnName="Code_Album")
     * })
     */
    private $codeAlbum;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="CompositionDisque", mappedBy="codeDisque")
     */
    private $compositiondisques;


    public function __construct()
    {
        $this->compositiondisques = new ArrayCollection();
    }

    /**
     * Get codeDisque
     *
     * @return integer
     */
    public function getCodeDisque()
    {
        return $this->codeDisque;
    }

    /**
     * Set référenceAlbum
     *
     * @param string $référenceAlbum
     *
     * @return Disque
     */
    public function setReferenceAlbum($référenceAlbum)
    {
        $this->référenceAlbum = $référenceAlbum;

        return $this;
    }

    /**
     * Get référenceAlbum
     *
     * @return string
     */
    public function getReferenceAlbum()
    {
        return $this->référenceAlbum;
    }

    /**
     * Set référenceDisque
     *
     * @param string $référenceDisque
     *
     * @return Disque
     */
    public function setReferenceDisque($référenceDisque)
    {
        $this->référenceDisque = $référenceDisque;

        return $this;
    }

    /**
     * Get référenceDisque
     *
     * @return string
     */
    public function getReferenceDisque()
    {
        return $this->référenceDisque;
    }

    /**
     * Set codeAlbum
     *
     * @param Album $codeAlbum
     *
     * @return Disque
     */
    public function setCodeAlbum(Album $codeAlbum = null)
    {
        $this->codeAlbum = $codeAlbum;

        return $this;
    }

    /**
     * Get codeAlbum
     *
     * @return Album
     */
    public function getCodeAlbum()
    {
        return $this->codeAlbum;
    }

    /**
     * @return array
     */
    public function getCompositiondisques()
    {
        return $this->compositiondisques;
    }

    /**
     * @param array $compositiondisques
     */
    public function setCompositiondisques($compositiondisques)
    {
        $this->compositiondisques = $compositiondisques;

        return $this;
    }

    public function getPrice()
    {
        return $this->getNbEnregistrement();
    }

    public function getNbEnregistrement()
    {
        return count($this->compositiondisques);
    }
}
