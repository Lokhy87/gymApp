<?php

namespace App\Entity;

use App\Repository\WorkPlanRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkPlanRepository::class)]
class WorkPlan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $daysPerWeek = null;

    #[ORM\Column(nullable: true)]
    private ?int $durationWeeks = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\ManyToOne(inversedBy: 'workPlans')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TrainingGoal $trainingGoal = null;

    #[ORM\ManyToOne(inversedBy: 'workPlans')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TrainingLevel $trainingLevel = null;

    #[ORM\ManyToOne(inversedBy: 'workPlans')]
    #[ORM\JoinColumn(nullable: false)]
    private ?WorkSplit $workSplit = null;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDaysPerWeek(): ?int
    {
        return $this->daysPerWeek;
    }

    public function setDaysPerWeek(int $daysPerWeek): static
    {
        $this->daysPerWeek = $daysPerWeek;

        return $this;
    }

    public function getDurationWeeks(): ?int
    {
        return $this->durationWeeks;
    }

    public function setDurationWeeks(?int $durationWeeks): static
    {
        $this->durationWeeks = $durationWeeks;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getTrainingGoal(): ?TrainingGoal
    {
        return $this->trainingGoal;
    }

    public function setTrainingGoal(?TrainingGoal $trainingGoal): static
    {
        $this->trainingGoal = $trainingGoal;

        return $this;
    }

    public function getTrainingLevel(): ?TrainingLevel
    {
        return $this->trainingLevel;
    }

    public function setTrainingLevel(?TrainingLevel $trainingLevel): static
    {
        $this->trainingLevel = $trainingLevel;

        return $this;
    }

    public function getWorkSplit(): ?WorkSplit
    {
        return $this->workSplit;
    }

    public function setWorkSplit(?WorkSplit $workSplit): static
    {
        $this->workSplit = $workSplit;

        return $this;
    }
}
