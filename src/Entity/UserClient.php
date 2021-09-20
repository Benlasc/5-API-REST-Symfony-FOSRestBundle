<?php

namespace App\Entity;

use App\Repository\UserClientRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserClientRepository::class)
 * 
 * @Hateoas\Relation( 
 *      "self", 
 *      href = @Hateoas\Route( 
 *          "showClient",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups={"list"})
 * )
 * 
 * @Hateoas\Relation( 
 *     "user", 
 *     embedded = @Hateoas\Embedded("expr(object.getUser())") 
 * ) 
 * 
 */
class UserClient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"details"})
     * @Assert\NotBlank
     * @Assert\Length(max=20)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"details"})
     * @Assert\NotBlank
     * @Assert\Length(max=20)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"list","details"})
     * @Assert\NotBlank
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"list","details"})
     * @Assert\NotBlank
     * @Assert\Length(min=3)
     */
    private $login;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userClients")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }
}
