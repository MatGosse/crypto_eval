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
     * @ORM\Column(type="float", scale=6)
     */
    private $amount;

    /**
     * @ORM\Column(type="float", scale=6)
     */
    private $initial_value;

    /**
     * @ORM\Column(type="date")
     */
    private $creation_date;

    /**
     * @ORM\Column(type="float", scale=6)
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

    /**
     * @ORM\Column(type="float", scale=6)
     */
    private $initialAmount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getInitialValue(): ?float
    {
        return $this->initial_value;
    }

    public function setInitialValue(float $initial_value): self
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

    public function getCurrentValue(): ?float
    {
        return $this->current_value;
    }

    public function setCurrentValue(float $current_value): self
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

    public function getInitialAmount(): ?float
    {
        return $this->initialAmount;
    }

    public function setInitialAmount(float $initialAmount): self
    {
        $this->initialAmount = $initialAmount;

        return $this;
    }
}
