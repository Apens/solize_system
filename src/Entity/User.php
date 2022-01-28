<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $firstname;

    #[ORM\Column(type: 'string', length: 255)]
    private $lastname;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $phone;

    #[ORM\Column(type: 'text', nullable: true)]
    private $descrition;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'users')]
    private $user_company;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Schedule::class)]
    private $schedules;

    #[ORM\OneToMany(mappedBy: 'user_created', targetEntity: Appointment::class)]
    private $created_appointments;

    #[ORM\OneToMany(mappedBy: 'booked_user', targetEntity: Appointment::class)]
    private $booked_appointments;

    public function __construct()
    {
        $this->schedules = new ArrayCollection();
        $this->created_appointments = new ArrayCollection();
        $this->booked_appointments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getDescrition(): ?string
    {
        return $this->descrition;
    }

    public function setDescrition(?string $descrition): self
    {
        $this->descrition = $descrition;

        return $this;
    }

    public function getUserCompany(): ?Company
    {
        return $this->user_company;
    }

    public function setUserCompany(?Company $user_company): self
    {
        $this->user_company = $user_company;

        return $this;
    }

    /**
     * @return Collection|Schedule[]
     */
    public function getSchedules(): Collection
    {
        return $this->schedules;
    }

    public function addSchedule(Schedule $schedule): self
    {
        if (!$this->schedules->contains($schedule)) {
            $this->schedules[] = $schedule;
            $schedule->setUserId($this);
        }

        return $this;
    }

    public function removeSchedule(Schedule $schedule): self
    {
        if ($this->schedules->removeElement($schedule)) {
            // set the owning side to null (unless already changed)
            if ($schedule->getUserId() === $this) {
                $schedule->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Appointment[]
     */
    public function getCreatedAppointments(): Collection
    {
        return $this->created_appointments;
    }

    public function addCreatedAppointment(Appointment $createdAppointment): self
    {
        if (!$this->created_appointments->contains($createdAppointment)) {
            $this->created_appointments[] = $createdAppointment;
            $createdAppointment->setUserCreated($this);
        }

        return $this;
    }

    public function removeCreatedAppointment(Appointment $createdAppointment): self
    {
        if ($this->created_appointments->removeElement($createdAppointment)) {
            // set the owning side to null (unless already changed)
            if ($createdAppointment->getUserCreated() === $this) {
                $createdAppointment->setUserCreated(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Appointment[]
     */
    public function getBookedAppointments(): Collection
    {
        return $this->booked_appointments;
    }

    public function addBookedAppointment(Appointment $bookedAppointment): self
    {
        if (!$this->booked_appointments->contains($bookedAppointment)) {
            $this->booked_appointments[] = $bookedAppointment;
            $bookedAppointment->setBookedUser($this);
        }

        return $this;
    }

    public function removeBookedAppointment(Appointment $bookedAppointment): self
    {
        if ($this->booked_appointments->removeElement($bookedAppointment)) {
            // set the owning side to null (unless already changed)
            if ($bookedAppointment->getBookedUser() === $this) {
                $bookedAppointment->setBookedUser(null);
            }
        }

        return $this;
    }
}
