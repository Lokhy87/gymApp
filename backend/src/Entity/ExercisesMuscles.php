<?php

namespace App\Entity;

use App\Repository\ExercisesMusclesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExercisesMusclesRepository::class)]
class ExercisesMuscles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    #[ORM\ManyToOne(targetEntity: Exercises::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Exercises $exercise = null;

    #[ORM\ManyToOne(targetEntity: Muscles::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Muscles $muscle = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getExercise(): ?Exercises
    {
        return $this->exercise;
    }

    public function setExercise(?Exercises $exercise): static
    {
        $this->exercise = $exercise;

        return $this;
    }

    public function getMuscle(): ?Muscles
    {
        return $this->muscle;
    }

    public function setMuscle(?Muscles $muscle): static
    {
        $this->muscle = $muscle;

        return $this;
    }
}
