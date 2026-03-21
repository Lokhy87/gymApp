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

    #[ORM\ManyToOne(inversedBy: 'exercisesMuscles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Exercises $muscle = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMuscle(): ?Exercises
    {
        return $this->muscle;
    }

    public function setMuscle(?Exercises $muscle): static
    {
        $this->muscle = $muscle;

        return $this;
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
}
