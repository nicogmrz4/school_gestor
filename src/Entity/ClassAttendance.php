<?php

namespace App\Entity;

use App\Repository\ClassAttendanceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClassAttendanceRepository::class)]
class ClassAttendance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'classAttendances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Student $student = null;

    #[ORM\ManyToOne(inversedBy: 'classAttendances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?SubjectClass $subjectClass = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): static
    {
        $this->student = $student;

        return $this;
    }

    public function getSubjectClass(): ?SubjectClass
    {
        return $this->subjectClass;
    }

    public function setSubjectClass(?SubjectClass $subjectClass): static
    {
        $this->subjectClass = $subjectClass;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }
}
