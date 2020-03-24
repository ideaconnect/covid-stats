<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StatsSetRepository")
 */
class StatsSet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $lastUpdate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StatsEntry", mappedBy="statsSet", orphanRemoval=true, indexBy="code")
     */
    private $statsEntries;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\StatsSource", inversedBy="statsSets")
     */
    private $source;

    public function __construct()
    {
        $this->statsEntries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastUpdate(): ?\DateTimeInterface
    {
        return $this->lastUpdate;
    }

    public function setLastUpdate(\DateTimeInterface $lastUpdate): self
    {
        $this->lastUpdate = $lastUpdate;

        return $this;
    }

    public function entriesToArray()
    {
        $entries = [];
        foreach($this->getStatsEntries() as $entry)
        {
            $entries[$entry->getCode()] = $entry->toArray();
        }

        return $entries;
    }

    /**
     * @return Collection|StatsEntry[]
     */
    public function getStatsEntries(): Collection
    {
        return $this->statsEntries;
    }

    public function addStatsEntry(StatsEntry $statsEntry): self
    {
        if (!$this->statsEntries->contains($statsEntry)) {
            $this->statsEntries[] = $statsEntry;
            $statsEntry->setStatsSet($this);
        }

        return $this;
    }

    public function removeStatsEntry(StatsEntry $statsEntry): self
    {
        if ($this->statsEntries->contains($statsEntry)) {
            $this->statsEntries->removeElement($statsEntry);
            // set the owning side to null (unless already changed)
            if ($statsEntry->getStatsSet() === $this) {
                $statsEntry->setStatsSet(null);
            }
        }

        return $this;
    }

    public function getSource(): ?StatsSource
    {
        return $this->source;
    }

    public function setSource(?StatsSource $source): self
    {
        $this->source = $source;

        return $this;
    }
}
