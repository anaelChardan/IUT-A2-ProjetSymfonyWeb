<?php

namespace ProjetWeb\ClassiqueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CompositionDisque
 *
 * @ORM\Table(name="Composition_Disque", indexes={@ORM\Index(name="IDX_6F414DB4B1A3EE1", columns={"Code_Disque"}), @ORM\Index(name="IDX_6F414DB4D990D4F0", columns={"Code_Morceau"})})
 * @ORM\Entity
 */
class CompositionDisque
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Code_Contenir", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeContenir;

    /**
     * @var integer
     *
     * @ORM\Column(name="Position", type="integer", nullable=true)
     */
    private $position;

    /**
     * @var Disque
     *
     * @ORM\ManyToOne(targetEntity="Disque", inversedBy="compositiondisques")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Code_Disque", referencedColumnName="Code_Disque")
     * })
     */
    private $codeDisque;

    /**
     * @var Enregistrement
     *
     * @ORM\ManyToOne(targetEntity="Enregistrement", inversedBy="compositiondisques")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Code_Morceau", referencedColumnName="Code_Morceau")
     * })
     */
    private $codeMorceau;


    /**
     * Get codeContenir
     *
     * @return integer
     */
    public function getCodeContenir()
    {
        return $this->codeContenir;
    }

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return CompositionDisque
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set codeDisque
     *
     * @param Disque $codeDisque
     *
     * @return CompositionDisque
     */
    public function setCodeDisque(Disque $codeDisque = null)
    {
        $this->codeDisque = $codeDisque;

        return $this;
    }

    /**
     * Get codeDisque
     *
     * @return Disque
     */
    public function getCodeDisque()
    {
        return $this->codeDisque;
    }

    /**
     * Set codeMorceau
     *
     * @param Enregistrement $codeMorceau
     *
     * @return CompositionDisque
     */
    public function setCodeMorceau(Enregistrement $codeMorceau = null)
    {
        $this->codeMorceau = $codeMorceau;

        return $this;
    }

    /**
     * Get codeMorceau
     *
     * @return Enregistrement
     */
    public function getCodeMorceau()
    {
        return $this->codeMorceau;
    }
}
