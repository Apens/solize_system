<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $company_name;

    #[ORM\Column(type: 'string', length: 255)]
    private $company_address;

    #[ORM\Column(type: 'string', length: 30)]
    private $company_zipcode;

    #[ORM\Column(type: 'string', length: 190)]
    private $company_city;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $company_phone;

    #[ORM\OneToMany(mappedBy: 'user_company', targetEntity: User::class)]
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyName(): ?string
    {
        return $this->company_name;
    }

    public function setCompanyName(string $company_name): self
    {
        $this->company_name = $company_name;

        return $this;
    }

    public function getCompanyAddress(): ?string
    {
        return $this->company_address;
    }

    public function setCompanyAddress(string $company_address): self
    {
        $this->company_address = $company_address;

        return $this;
    }

    public function getCompanyZipcode(): ?string
    {
        return $this->company_zipcode;
    }

    public function setCompanyZipcode(string $company_zipcode): self
    {
        $this->company_zipcode = $company_zipcode;

        return $this;
    }

    public function getCompanyCity(): ?string
    {
        return $this->company_city;
    }

    public function setCompanyCity(string $company_city): self
    {
        $this->company_city = $company_city;

        return $this;
    }

    public function getCompanyPhone(): ?string
    {
        return $this->company_phone;
    }

    public function setCompanyPhone(?string $company_phone): self
    {
        $this->company_phone = $company_phone;

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
            $user->setUserCompany($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getUserCompany() === $this) {
                $user->setUserCompany(null);
            }
        }

        return $this;
    }
}
