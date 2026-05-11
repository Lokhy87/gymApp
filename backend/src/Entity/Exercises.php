<?php

namespace App\Entity;

use App\Repository\ExercisesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExercisesRepository::class)]
class Exercises
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'exercises')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MuscleGroups $muscleGroup = null;

    /**
     * @var Collection<int, ExercisesMuscles>
     */
    #[ORM\OneToMany(targetEntity: ExercisesMuscles::class, mappedBy: 'exercise')]
    private Collection $exercisesMuscles;

    /**
     * @var Collection<int, ExercisesVariants>
     */
    #[ORM\OneToMany(targetEntity: ExercisesVariants::class, mappedBy: 'exercise')]
    private Collection $exercisesVariants;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    public function __construct()
    {
        $this->exercisesMuscles = new ArrayCollection();
        $this->exercisesVariants = new ArrayCollection();
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

    public function getMuscleGroup(): ?MuscleGroups
    {
        return $this->muscleGroup;
    }

    public function setMuscleGroup(?MuscleGroups $muscleGroup): static
    {
        $this->muscleGroup = $muscleGroup;

        return $this;
    }

    /**
     * @return Collection<int, ExercisesMuscles>
     */
    public function getExercisesMuscles(): Collection
    {
        return $this->exercisesMuscles;
    }

public function addExercisesMuscle(ExercisesMuscles $exercisesMuscle): static
{
    if (!$this->exercisesMuscles->contains($exercisesMuscle)) {
        $this->exercisesMuscles->add($exercisesMuscle);
        $exercisesMuscle->setExercise($this); // <-- CAMBIADO A setExercise
    }
    return $this;
}

    public function removeExercisesMuscle(ExercisesMuscles $exercisesMuscle): static
    {
        if ($this->exercisesMuscles->removeElement($exercisesMuscle)) {
            if ($exercisesMuscle->getExercise() === $this) { // <-- CAMBIADO A getExercise
                $exercisesMuscle->setExercise(null); // <-- CAMBIADO A setExercise
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, ExercisesVariants>
     */
    public function getExercisesVariants(): Collection
    {
        return $this->exercisesVariants;
    }

    public function addExercisesVariant(ExercisesVariants $exercisesVariant): static
    {
        if (!$this->exercisesVariants->contains($exercisesVariant)) {
            $this->exercisesVariants->add($exercisesVariant);
            $exercisesVariant->setExercise($this);
        }

        return $this;
    }

    public function removeExercisesVariant(ExercisesVariants $exercisesVariant): static
    {
        if ($this->exercisesVariants->removeElement($exercisesVariant)) {
            // set the owning side to null (unless already changed)
            if ($exercisesVariant->getExercise() === $this) {
                $exercisesVariant->setExercise(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }
}
