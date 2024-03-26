<?php

namespace App\Entity;

use App\Repository\SubjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubjectRepository::class)]
class Subject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'subjects')]
    private ?Course $course = null;

    #[ORM\ManyToOne]
    private ?User $teacher = null;

    #[ORM\OneToMany(targetEntity: SubjectClass::class, mappedBy: 'subject')]
    private Collection $classes;

    public function __construct()
    {
        $this->classes = new ArrayCollection();
    }

    public function __toString()
    {
        return sprintf("%s - %s", $this->name, $this->teacher->getUsername());
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

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): static
    {
        $this->course = $course;

        return $this;
    }

    public function getTeacher(): ?User
    {
        return $this->teacher;
    }

    public function setTeacher(?User $teacher): static
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * @return Collection<int, SubjectClass>
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClass(SubjectClass $class): static
    {
        if (!$this->classes->contains($class)) {
            $this->classes->add($class);
            $class->setSubject($this);
        }

        return $this;
    }

    public function removeClass(SubjectClass $class): static
    {
        if ($this->classes->removeElement($class)) {
            // set the owning side to null (unless already changed)
            if ($class->getSubject() === $this) {
                $class->setSubject(null);
            }
        }

        return $this;
    }
}
