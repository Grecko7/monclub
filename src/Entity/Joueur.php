<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JoueurRepository")
 * @UniqueEntity("Nom")
 * @Vich\Uploadable()
 */
class Joueur
{
    public function __LibretoString()
    {
        return $this->Libre;
    }
    
/*     const PAYS = [
        0 => 'France',
        1 => 'Bresil',
        2 => 'Allemagne',
        3 => 'Argentine',
        4 => 'Mexique',
        5 => 'Japon'
    ]; */

    const LIBRE = [
        0 => 'Libre',
        1 => 'Sous-contrat',
        2 => 'En discussion',
        3 => 'Joueur posséder',
        4 => 'Retraité',
        5 => 'Innaccessible'
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @var File|null
     * @Assert\Image(mimeTypes="image/jpeg")
     * @Vich\UploadableField(mapping="joueur_image", fileNameProperty="filename")
     */
    private $imageFile;

    /**
     * @Assert\Length(min=5, max=255)
     * @ORM\Column(type="string", length=255)
     * )
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Caract;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Regex("/^[0-9]{2}$/")
     */
    private $Age;

    /**
     * @ORM\Column(type="float")
     * @Assert\Range(min=0.9, max=2.6)
     */
    private $Taille;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(min=1, max=99)
     */
    private $Niveau;

    /**
     * 
     * @ORM\Column(type="integer")
     */
    private $Libre;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateEnregistrement;


    /**
     * @ORM\Column(type="integer")
     */
    private $Prix;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Langage", inversedBy="joueurs")
     */
    private $langages;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pays", inversedBy="joueurs")
     */
    private $pays;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="joueur", orphanRemoval=true)
     */
    private $comments;

    public function __construct()
    {
        $this->DateEnregistrement = new \DateTime();
        $this->langages = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getSlug() : string
    {
        return (new Slugify())->slugify($this->Nom);
    }

    public function getCaract(): ?string
    {
        return $this->Caract;
    }

    public function setCaract(?string $Caract): self
    {
        $this->Caract = $Caract;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->Age;
    }

    public function setAge(int $Age): self
    {
        $this->Age = $Age;

        return $this;
    }

    public function getTaille(): ?float
    {
        return $this->Taille;
    }

    public function setTaille(float $Taille): self
    {
        $this->Taille = $Taille;

        return $this;
    }

    public function getNiveau(): ?int
    {
        return $this->Niveau;
    }

    public function setNiveau(int $Niveau): self
    {
        $this->Niveau = $Niveau;

        return $this;
    }

    public function getLibre(): ?int
    {
        return $this->Libre;
    }

    public function setLibre(int $Libre): self
    {
        $this->Libre = $Libre;

        return $this;
    }

    public function getLibreType(): string 
    {
        return self::LIBRE[$this->Libre];
    }

    public function getDateEnregistrement(): ?\DateTimeInterface
    {
        return $this->DateEnregistrement;
    }

    public function setDateEnregistrement(\DateTimeInterface $DateEnregistrement): self
    {
        $this->DateEnregistrement = $DateEnregistrement;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->Prix;
    }

    public function setPrix(int $Prix): self
    {
        $this->Prix = $Prix;

        return $this;
    }

    public function getFormattedPrix(): string
    {
        return \number_format($this->Prix, 0, ' ', ' ');
    }

    /**
     * @return Collection|Langage[]
     */
    public function getLangages(): Collection
    {
        return $this->langages;
    }

    public function addLangage(Langage $langage): self
    {
        if (!$this->langages->contains($langage)) {
            $this->langages[] = $langage;
            $langage->addJoueur($this);
        }

        return $this;
    }

    public function removeLangage(Langage $langage): self
    {
        if ($this->langages->contains($langage)) {
            $this->langages->removeElement($langage);
            $langage->removeJoueur($this);
        }

        return $this;
    }

    /**
     * @return  string|null
     */ 
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @param string|null  $filename
     * @return Joueur
     */ 
    public function setFilename(?string $filename): Joueur
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return  File|null
     */ 
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param  File|null  $imageFile
     * @return Joueur
     */ 
    public function setImageFile(?File $imageFile): Joueur
    {
        $this->imageFile = $imageFile;
        if ($this->imageFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(?Pays $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setJoueur($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getJoueur() === $this) {
                $comment->setJoueur(null);
            }
        }

        return $this;
    }
}
