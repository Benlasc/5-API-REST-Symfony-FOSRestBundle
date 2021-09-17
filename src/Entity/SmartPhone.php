<?php

namespace App\Entity;

use App\Repository\SmartPhoneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity(repositoryClass=SmartPhoneRepository::class)
 * 
 * @Hateoas\Relation( 
 *      "self", 
 *      href = @Hateoas\Route( 
 *          "show", 
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups={"list"}) 
 * ) 
 */
class SmartPhone
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"list","details"})
     */
    private $brand;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"list","details"})
     */
    private $model;

    /**
     * @ORM\Column(type="text")
     * @Serializer\Groups({"details"})
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2)
     * @Serializer\Groups({"list","details"})
     */
    private $price;

    /**
     * @ORM\Column(type="date")
     * @Serializer\Groups({"list","details"})
     */
    private $releaseDate;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="smartPhones")
     */
    private $users;

    /**
     * @ORM\Column(type="string", length=50)
     * @Serializer\Groups({"details"})
     */
    private $color;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"details"})
     */
    private $size;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addSmartPhone($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeSmartPhone($this);
        }

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }
}
