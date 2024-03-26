<?php

namespace App\Entity;

use App\Repository\SubjectClassRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubjectClassRepository::class)]
class SubjectClass
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'classes')]
    private ?Subject $subject = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\OneToMany(targetEntity: ClassAttendance::class, mappedBy: 'subjectClass', orphanRemoval: true)]
    private Collection $classAttendances;

    public function __construct()
    {
        $this->classAttendances = new ArrayCollection();
    }

    public function __toString()
    {
        return (string) $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?Subject
    {
        return $this->subject;
    }

    public function setSubject(?Subject $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

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
            $classAttendance->setSubjectClass($this);
        }

        return $this;
    }

    public function removeClassAttendance(ClassAttendance $classAttendance): static
    {
        if ($this->classAttendances->removeElement($classAttendance)) {
            // set the owning side to null (unless already changed)
            if ($classAttendance->getSubjectClass() === $this) {
                $classAttendance->setSubjectClass(null);
            }
        }

        return $this;
    }
}
