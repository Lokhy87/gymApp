<?php

namespace App\Entity;

use App\Repository\MuscleGroupsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MuscleGroupsRepository::class)]
class MuscleGroups
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    /**
     * @var Collection<int, Muscles>
     */
    #[ORM\OneToMany(targetEntity: Muscles::class, mappedBy: 'muscleGroup')]
    private Collection $muscles;

    /**
     * @var Collection<int, Exercises>
     */
    #[ORM\OneToMany(targetEntity: Exercises::class, mappedBy: 'muscleGroup')]
    private Collection $exercises;

    public function __construct()
    {
        $this->muscles = new ArrayCollection();
        $this->exercises = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Muscles>
     */
    public function getMuscles(): Collection
    {
        return $this->muscles;
    }

    public function addMuscle(Muscles $muscle): static
    {
        if (!$this->muscles->contains($muscle)) {
            $this->muscles->add($muscle);
            $muscle->setMuscleGroup($this);
        }

        return $this;
    }

    public function removeMuscle(Muscles $muscle): static
    {
        if ($this->muscles->removeElement($muscle)) {
            // set the owning side to null (unless already changed)
            if ($muscle->getMuscleGroup() === $this) {
                $muscle->setMuscleGroup(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Exercises>
     */
    public function getExercises(): Collection
    {
        return $this->exercises;
    }

    public function addExercise(Exercises $exercise): static
    {
        if (!$this->exercises->contains($exercise)) {
            $this->exercises->add($exercise);
            $exercise->setMuscleGroup($this);
        }

        return $this;
    }

    public function removeExercise(Exercises $exercise): static
    {
        if ($this->exercises->removeElement($exercise)) {
            // set the owning side to null (unless already changed)
            if ($exercise->getMuscleGroup() === $this) {
                $exercise->setMuscleGroup(null);
            }
        }

        return $this;
    }
}
