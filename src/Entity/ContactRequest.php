<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\ContactRequestRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=RequestRepository::class)
 */
class ContactRequest
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Veuillez renseigner votre nom")
     * @Assert\Length(
     *     min=2,
     *     max=15,
     *     minMessage="Votre nom doit contenir au moins deux lettres",
     *     maxMessage="Votre nom ne peut pas contenir plus de {{ limit }} lettres"
     * )
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Veuillez renseigner votre email")
     * @Assert\Email(message="Veuillez renseigner un email valide")
     */
    private string $email;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Veuillez nous indiquer votre question")
     * @Assert\Length(
     *     min= 20,
     *     minMessage="Veuillez être plus explicite concernant votre question"
     * )
     */
    private string $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isRequestFinished = false;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getIsRequestFinished(): ?bool
    {
        return $this->isRequestFinished;
    }

    public function setIsRequestFinished(bool $isRequestFinished): self
    {
        $this->isRequestFinished = $isRequestFinished;

        return $this;
    }
}
