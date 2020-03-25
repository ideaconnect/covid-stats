<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StatsEntryRepository")
 */
class StatsEntry
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\StatsSet", inversedBy="statsEntries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $statsSet;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $confirmed;

    /**
     * @ORM\Column(type="integer")
     */
    private $confirmedDelta;

    /**
     * @ORM\Column(type="integer")
     */
    private $confirmedYesterday;

    /**
     * @ORM\Column(type="integer")
     */
    private $deaths;

    /**
     * @ORM\Column(type="integer")
     */
    private $deathsDelta;

    /**
     * @ORM\Column(type="integer")
     */
    private $deathsYesterday;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $recovered;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $recoveredDelta;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $recoveredYesterday;
    public function toArray()
    {
        return [
            'code' => $this->getCode(),
            'name' => $this->getName(),
            'confirmed' => $this->getConfirmed(),
            'confirmed_delta' => $this->getConfirmedDelta(),
            'confirmed_since_yesterday' => $this->getConfirmedYesterday(),
            'deaths' => $this->getDeaths(),
            'deaths_delta' => $this->getDeathsDelta(),
            'deaths_since_yesterday' => $this->getDeathsYesterday(),
            'recovered' => $this->getRecovered(),
            'recovered_delta' => $this->getRecoveredDelta(),
            'recovered_since_yesterday' => $this->getRecoveredYesterday()
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatsSet(): ?StatsSet
    {
        return $this->statsSet;
    }

    public function setStatsSet(?StatsSet $statsSet): self
    {
        $this->statsSet = $statsSet;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getConfirmed(): ?int
    {
        return $this->confirmed;
    }

    public function setConfirmed(int $confirmed): self
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    public function getConfirmedDelta(): ?int
    {
        return $this->confirmedDelta;
    }

    public function setConfirmedDelta(int $confirmedDelta): self
    {
        $this->confirmedDelta = $confirmedDelta;

        return $this;
    }

    public function getConfirmedYesterday(): ?int
    {
        return $this->confirmedYesterday;
    }

    public function setConfirmedYesterday(int $confirmedYesterday): self
    {
        $this->confirmedYesterday = $confirmedYesterday;

        return $this;
    }

    public function getDeaths(): ?int
    {
        return $this->deaths;
    }

    public function setDeaths(int $deaths): self
    {
        $this->deaths = $deaths;

        return $this;
    }

    public function getDeathsDelta(): ?int
    {
        return $this->deathsDelta;
    }

    public function setDeathsDelta(int $deathsDelta): self
    {
        $this->deathsDelta = $deathsDelta;

        return $this;
    }

    public function getDeathsYesterday(): ?int
    {
        return $this->deathsYesterday;
    }

    public function setDeathsYesterday(int $deathsYesterday): self
    {
        $this->deathsYesterday = $deathsYesterday;

        return $this;
    }

    public function getRecovered(): ?int
    {
        return $this->recovered;
    }

    public function setRecovered(int $recovered): self
    {
        $this->recovered = $recovered;

        return $this;
    }

    public function getRecoveredDelta(): ?int
    {
        return $this->recoveredDelta;
    }

    public function setRecoveredDelta(?int $recoveredDelta): self
    {
        $this->recoveredDelta = $recoveredDelta;

        return $this;
    }

    public function getRecoveredYesterday(): ?int
    {
        return $this->recoveredYesterday;
    }

    public function setRecoveredYesterday(?int $recoveredYesterday): self
    {
        $this->recoveredYesterday = $recoveredYesterday;

        return $this;
    }
}
