<?php

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WalletRepository::class)
 */
class Wallet
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
    private $amount;

    /**
     * @ORM\Column(type="integer")
     */
    private $initial_value;

    /**
     * @ORM\Column(type="date")
     */
    private $creation_date;

    /**
     * @ORM\Column(type="integer")
     */
    private $current_value;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Curency::class, inversedBy="wallets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Currency;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getInitialValue(): ?int
    {
        return $this->initial_value;
    }

    public function setInitialValue(int $initial_value): self
    {
        $this->initial_value = $initial_value;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creation_date;
    }

    public function setCreationDate(\DateTimeInterface $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    public function getCurrentValue(): ?int
    {
        return $this->current_value;
    }

    public function setCurrentValue(int $current_value): self
    {
        $this->current_value = $current_value;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCurrency(): ?Curency
    {
        return $this->Currency;
    }

    public function setCurrency(?Curency $Currency): self
    {
        $this->Currency = $Currency;

        return $this;
    }
}
