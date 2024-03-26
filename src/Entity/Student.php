<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $alternativePhoneNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'students')]
    private ?Course $course = null;

    #[ORM\OneToMany(targetEntity: ClassAttendance::class, mappedBy: 'student', orphanRemoval: true)]
    private Collection $classAttendances;

    public function __construct()
    {
        $this->classAttendances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getAlternativePhoneNumber(): ?string
    {
        return $this->alternativePhoneNumber;
    }

    public function setAlternativePhoneNumber(string $alternativePhoneNumber): static
    {
        $this->alternativePhoneNumber = $alternativePhoneNumber;

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

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): static
    {
        $this->course = $course;

        return $this;
    }

    /**
     * @return Collection<int, ClassAttendance>
     */
    public function getClassAttendances(): Collection
    {
        return $this->classAttendances;
    }

    public function addClassAttendance(ClassAttendance $classAttendance): static
    {
        if (!$this->classAttendances->contains($classAttendance)) {
            $this->classAttendances->add($classAttendance);
            $classAttendance->setStudent($this);
        }

        return $this;
    }

    public function removeClassAttendance(ClassAttendance $classAttendance): static
    {
        if ($this->classAttendances->removeElement($classAttendance)) {
            // set the owning side to null (unless already changed)
            if ($classAttendance->getStudent() === $this) {
                $classAttendance->setStudent(null);
            }
        }

        return $this;
    }
}
