<?php

namespace App\Entity;

use App\Repository\CategoriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoriaRepository::class)
 */
class Categoria
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codigo;

    /**
     * @ORM\OneToMany(targetEntity=Lista::class, mappedBy="categoria")
     */
    private $listas;

    public function __construct()
    {
        $this->listas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * @return Collection<int, Lista>
     */
    public function getListas(): Collection
    {
        return $this->listas;
    }

    public function addLista(Lista $lista): self
    {
        if (!$this->listas->contains($lista)) {
            $this->listas[] = $lista;
            $lista->setCategoria($this);
        }

        return $this;
    }

    public function removeLista(Lista $lista): self
    {
        if ($this->listas->removeElement($lista)) {
            // set the owning side to null (unless already changed)
            if ($lista->getCategoria() === $this) {
                $lista->setCategoria(null);
            }
        }

        return $this;
    }
}
