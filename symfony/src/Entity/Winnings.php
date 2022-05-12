<?php

namespace App\Entity;

use App\Repository\WinningsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WinningsRepository::class)
 */
class Winnings
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $balance;

    /**
     * @ORM\Column(type="date")
     */
    private $DateEntry;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBalance(): ?int
    {
        return $this->balance;
    }

    public function setBalance(int $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getDateEntry(): ?\DateTimeInterface
    {
        return $this->DateEntry;
    }

    public function setDateEntry(\DateTimeInterface $DateEntry): self
    {
        $this->DateEntry = $DateEntry;

        return $this;
    }
}
