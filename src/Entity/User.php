<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User extends BaseEntity implements PasswordAuthenticatedUserInterface, UserInterface, Stringable
{
    public const DEFAULT_ROLE = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    #[ORM\Column(length: 128)]
    #[Assert\Regex('/^[\w\s.-]+$/', 'Only letters and numbers allowed')]
    private string $firstName;

    #[ORM\Column(length: 128)]
    #[Assert\Regex('/^[\w\s.-]+$/', 'Only letters and numbers allowed')]
    private string $lastName;

    #[ORM\Column(length: 128)]
    #[Assert\Regex('/^[\w\s.-]+$/', 'Only letters and numbers allowed')]
    private string $username;

    #[ORM\Column(length: 255)]
    private string $email;

    #[ORM\Column(type: Types::SMALLINT)]
    private int $isActive = 0;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $password = null;

    #[ORM\OneToMany(targetEntity: Profile::class, mappedBy: 'user')]
    private Collection $profile;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    private ?string $plainPassword = null;

    public function __construct()
    {
        parent::__construct();
        $this->profile = new ArrayCollection();
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getIsActive(): int
    {
        return $this->isActive;
    }

    public function setIsActive(int $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection<int, Profile>
     */
    public function getProfile(): Collection
    {
        return $this->profile;
    }

    public function addProfile(Profile $profile): static
    {
        if (!$this->profile->contains($profile)) {
            $this->profile->add($profile);
            $profile->setUser($this);
        }

        return $this;
    }

    public function removeProfile(Profile $profile): static
    {
        if ($this->profile->removeElement($profile)) {
            // set the owning side to null (unless already changed)
            if ($profile->getUser() === $this) {
                $profile->setUser(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @implements UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = self::DEFAULT_ROLE;

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @implements UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->getEmail();
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): static
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @implements UserInterface
     */
    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    public function __toString()
    {
        return $this->username;
    }
}
