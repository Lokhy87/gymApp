<?php

namespace App\Entity;

use App\Repository\TrainingLevelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrainingLevelRepository::class)]
class TrainingLevel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    /**
     * @var Collection<int, WorkPlan>
     */
    #[ORM\OneToMany(targetEntity: WorkPlan::class, mappedBy: 'trainingLevel')]
    private Collection $workPlans;

    public function __construct()
    {
        $this->workPlans = new ArrayCollection();
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
     * @return Collection<int, WorkPlan>
     */
    public function getWorkPlans(): Collection
    {
        return $this->workPlans;
    }

    public function addWorkPlan(WorkPlan $workPlan): static
    {
        if (!$this->workPlans->contains($workPlan)) {
            $this->workPlans->add($workPlan);
            $workPlan->setTrainingLevel($this);
        }

        return $this;
    }

    public function removeWorkPlan(WorkPlan $workPlan): static
    {
        if ($this->workPlans->removeElement($workPlan)) {
            // set the owning side to null (unless already changed)
            if ($workPlan->getTrainingLevel() === $this) {
                $workPlan->setTrainingLevel(null);
            }
        }

        return $this;
    }
}
