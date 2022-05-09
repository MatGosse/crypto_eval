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
     * @ORM\Column(type="string", length=255)
     */
    private $crypto_name;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCryptoName(): ?string
    {
        return $this->crypto_name;
    }

    public function setCryptoName(string $crypto_name): self
    {
        $this->crypto_name = $crypto_name;

        return $this;
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
}
