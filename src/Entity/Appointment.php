<?php

namespace App\Entity;

use App\Repository\AppointmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppointmentRepository::class)]
class Appointment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'created_appointments')]
    private $user_created;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'booked_appointments')]
    private $booked_user;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'appointments')]
    private $customer;

    #[ORM\Column(type: 'datetime')]
    private $start_time;

    #[ORM\Column(type: 'datetime')]
    private $expected_end;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $end_time;

    #[ORM\ManyToOne(targetEntity: ServiceJob::class, inversedBy: 'appointments')]
    private $service_job;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $approved_by_client;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $is_cancelled;

    #[ORM\Column(type: 'text', nullable: true)]
    private $cancellation_reason;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $updated_at;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $appointment_address;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $appointment_zipcode;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $appointment_city;

    #[ORM\Column(type: 'text', nullable: true)]
    private $appointment_reason;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUserCreated(): ?User
    {
        return $this->user_created;
    }

    public function setUserCreated(?User $user_created): self
    {
        $this->user_created = $user_created;

        return $this;
    }

    public function getBookedUser(): ?User
    {
        return $this->booked_user;
    }

    public function setBookedUser(?User $booked_user): self
    {
        $this->booked_user = $booked_user;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->start_time;
    }

    public function setStartTime(\DateTimeInterface $start_time): self
    {
        $this->start_time = $start_time;

        return $this;
    }

    public function getExpectedEnd(): ?\DateTimeInterface
    {
        return $this->expected_end;
    }

    public function setExpectedEnd(\DateTimeInterface $expected_end): self
    {
        $this->expected_end = $expected_end;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->end_time;
    }

    public function setEndTime(?\DateTimeInterface $end_time): self
    {
        $this->end_time = $end_time;

        return $this;
    }

    public function getServiceJob(): ?ServiceJob
    {
        return $this->service_job;
    }

    public function setServiceJob(?ServiceJob $service_job): self
    {
        $this->service_job = $service_job;

        return $this;
    }

    public function getApprovedByClient(): ?bool
    {
        return $this->approved_by_client;
    }

    public function setApprovedByClient(?bool $approved_by_client): self
    {
        $this->approved_by_client = $approved_by_client;

        return $this;
    }

    public function getIsCancelled(): ?bool
    {
        return $this->is_cancelled;
    }

    public function setIsCancelled(?bool $is_cancelled): self
    {
        $this->is_cancelled = $is_cancelled;

        return $this;
    }

    public function getCancellationReason(): ?string
    {
        return $this->cancellation_reason;
    }

    public function setCancellationReason(?string $cancellation_reason): self
    {
        $this->cancellation_reason = $cancellation_reason;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getAppointmentAddress(): ?string
    {
        return $this->appointment_address;
    }

    public function setAppointmentAddress(?string $appointment_address): self
    {
        $this->appointment_address = $appointment_address;

        return $this;
    }

    public function getAppointmentZipcode(): ?string
    {
        return $this->appointment_zipcode;
    }

    public function setAppointmentZipcode(?string $appointment_zipcode): self
    {
        $this->appointment_zipcode = $appointment_zipcode;

        return $this;
    }

    public function getAppointmentCity(): ?string
    {
        return $this->appointment_city;
    }

    public function setAppointmentCity(?string $appointment_city): self
    {
        $this->appointment_city = $appointment_city;

        return $this;
    }

    public function getAppointmentReason(): ?string
    {
        return $this->appointment_reason;
    }

    public function setAppointmentReason(?string $appointment_reason): self
    {
        $this->appointment_reason = $appointment_reason;

        return $this;
    }
}
