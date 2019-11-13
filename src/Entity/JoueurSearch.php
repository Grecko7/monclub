<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraint as Assert;

class JoueurSearch {
    /**
    * @var int|null
    */
    private $minPrice;

    /**
    * @var int|null
    */
    private $maxPrice;

    /**
    * @var int|null
    */
    private $minNiveau;
    
    /**
    * @var int|null
    */
    private $maxNiveau;

    /**
    * @var ArrayCollection 
    */
    private $langages;

    public function __construct()
    {
        $this->langages =  new ArrayCollection();
    }

    /**
     * @return  int|null
     */ 
    public function getMinPrice() : ?int
    {
        return $this->minPrice;
    }

    /**
     * @param  int|null  $minPrice
     * @return JoueurSearch
     */ 
    public function setMinPrice(int $minPrice): JoueurSearch
    {
        $this->minPrice = $minPrice;
        return $this;
    }

    /**
     * @return  int|null
     */ 
    public function getMaxPrice() : ?int
    {
        return $this->maxPrice;
    }

    /**
     * @param  int|null  $maxPrice
     *
     * @return JoueurSearch
     */ 
    public function setMaxPrice(int $maxPrice): JoueurSearch
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    /**
     * @return  int|null
     */ 
    public function getMinNiveau() : ?int
    {
        return $this->minNiveau;
    }

    /**
     * @param int|null  $minNiveau
     * @return JoueurSearch
     */ 
    public function setMinNiveau(int $minNiveau): JoueurSearch
    {
        $this->minNiveau = $minNiveau;
        return $this;
    }

    /**
     * @return  int|null
     */ 
    public function getMaxNiveau(): ?int
    {
        return $this->maxNiveau;
    }

    /**
     * @param int|null  $maxNiveau
     * @return JoueurSearch
     */ 
    public function setMaxNiveau(int $maxNiveau): JoueurSearch
    {
        $this->maxNiveau = $maxNiveau;
        return $this;
    }

    /**
     * @return ArrayCollection
     */ 
    public function getLangages(): ArrayCollection
    {
        return $this->langages;
    }

    /**
     * @param ArrayCollection  $langages
     */ 
    public function setLangages(ArrayCollection $langages): void
    {
        $this->langages = $langages;
    }
}