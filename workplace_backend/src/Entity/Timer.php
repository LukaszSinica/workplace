<?php

namespace App\Entity;

use App\Repository\TimerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TimerRepository::class)]
class Timer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $user_id = null;

    #[ORM\Column]
    private ?\DateTime $start = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $stop = null;

    #[ORM\Column(nullable: true)]
    private ?float $hours = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getStart(): ?\DateTime
    {
        return $this->start;
    }

    public function setStart(\DateTime $start): static
    {
        $this->start = $start;

        return $this;
    }

    public function getStop(): ?\DateTime
    {
        return $this->stop;
    }

    public function setStop(?\DateTime $stop): static
    {
        $this->stop = $stop;

        return $this;
    }

    public function getHours(): ?float
    {
        return $this->hours;
    }

    public function setHours(?float $hours): static
    {
        $this->hours = $hours;

        return $this;
    }
}
