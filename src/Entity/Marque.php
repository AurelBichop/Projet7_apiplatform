<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MarqueRepository")
 * @ApiResource(
 *     itemOperations={"get"},
 *     collectionOperations={"get"}
 * )
 */
class Marque
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Telephone", mappedBy="marque")
     */
    private $telephone;

    public function __construct()
    {
        $this->telephone = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Telephone[]
     */
    public function getTelephone(): Collection
    {
        return $this->telephone;
    }

    public function addTelephone(Telephone $telephone): self
    {
        if (!$this->telephone->contains($telephone)) {
            $this->telephone[] = $telephone;
            $telephone->setMarque($this);
        }

        return $this;
    }

    public function removeTelephone(Telephone $telephone): self
    {
        if ($this->telephone->contains($telephone)) {
            $this->telephone->removeElement($telephone);
            // set the owning side to null (unless already changed)
            if ($telephone->getMarque() === $this) {
                $telephone->setMarque(null);
            }
        }

        return $this;
    }
}
