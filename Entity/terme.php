<?php

namespace OVE\ThesaurusBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * terme
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="OVE\ThesaurusBundle\Entity\termeRepository")
 */
class terme
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_thesaurus", type="integer")
     */
    private $id_thesaurus;

    /**
     * @var string
     *
     * @ORM\Column(name="terme", type="string", length=255)
     */
    private $terme;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_terme_parent", type="integer", nullable=true)
     */
    private $id_terme_parent;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_terme_associe", type="integer", nullable=true)
     */
    private $id_terme_associe;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id_thesaurus
     *
     * @param integer $idThesaurus
     * @return terme
     */
    public function setIdThesaurus($idThesaurus)
    {
        $this->id_thesaurus = $idThesaurus;

        return $this;
    }

    /**
     * Get id_thesaurus
     *
     * @return integer 
     */
    public function getIdThesaurus()
    {
        return $this->id_thesaurus;
    }

    /**
     * Set terme
     *
     * @param string $terme
     * @return terme
     */
    public function setTerme($terme)
    {
        $this->terme = $terme;

        return $this;
    }

    /**
     * Get terme
     *
     * @return string 
     */
    public function getTerme()
    {
        return $this->terme;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return terme
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set id_terme_parent
     *
     * @param integer $idTermeParent
     * @return terme
     */
    public function setIdTermeParent($idTermeParent)
    {
        $this->id_terme_parent = $idTermeParent;

        return $this;
    }

    /**
     * Get id_terme_parent
     *
     * @return integer 
     */
    public function getIdTermeParent()
    {
        return $this->id_terme_parent;
    }

    /**
     * Set id_terme_associe
     *
     * @param integer $idTermeAssocie
     * @return terme
     */
    public function setIdTermeAssocie($idTermeAssocie)
    {
        $this->id_terme_associe = $idTermeAssocie;

        return $this;
    }

    /**
     * Get id_terme_associe
     *
     * @return integer 
     */
    public function getIdTermeAssocie()
    {
        return $this->id_terme_associe;
    }
}
