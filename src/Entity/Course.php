<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Subjet::class, mappedBy: 'course')]
    private Collection $subjets;

    #[ORM\OneToMany(targetEntity: Student::class, mappedBy: 'course')]
    private Collection $students;

    public function __construct()
    {
        $this->subjets = new ArrayCollection();
        $this->students = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Subjet>
     */
    public function getSubjets(): Collection
    {
        return $this->subjets;
    }

    public function addSubjet(Subjet $subjet): static
    {
        if (!$this->subjets->contains($subjet)) {
            $this->subjets->add($subjet);
            $subjet->setCourse($this);
        }

        return $this;
    }

    public function removeSubjet(Subjet $subjet): static
    {
        if ($this->subjets->removeElement($subjet)) {
            // set the owning side to null (unless already changed)
            if ($subjet->getCourse() === $this) {
                $subjet->setCourse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): static
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
            $student->setCourse($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): static
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getCourse() === $this) {
                $student->setCourse(null);
            }
        }

        return $this;
    }
}
