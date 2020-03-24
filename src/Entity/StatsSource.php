<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StatsSourceRepository")
 */
class StatsSource
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $source;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sourceDescription;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $sourceLicense;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StatsSet", mappedBy="source")
     * @ORM\OrderBy({"lastUpdate" = "DESC"})
     *
     */
    private $statsSets;

    public function __construct()
    {
        $this->statsSets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getSourceDescription(): ?string
    {
        return $this->sourceDescription;
    }

    public function setSourceDescription(string $sourceDescription): self
    {
        $this->sourceDescription = $sourceDescription;

        return $this;
    }

    public function getSourceLicense(): ?string
    {
        return $this->sourceLicense;
    }

    public function setSourceLicense(string $sourceLicense): self
    {
        $this->sourceLicense = $sourceLicense;

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

    public function toArray()
    {
        /** @var StatsSet */
        $lastStats = $this->getStatsSets()->last();
        $data = [
        'code' => $this->getCode(),
        'source' => $this->getSource(),
        'name' => $this->getName(),
        'source_description' => $this->getSourceDescription(),
        'source_license' => $this->getSourceLicense(),
        'last_update' => $lastStats->getLastUpdate()->format(DATE_RFC3339_EXTENDED),
        'entries' => $lastStats->entriesToArray()
        ];

        return $data;
    }

    /**
     * @return Collection|StatsSet[]
     */
    public function getStatsSets(): Collection
    {
        return $this->statsSets;
    }

    public function addStatsSet(StatsSet $statsSet): self
    {
        if (!$this->statsSets->contains($statsSet)) {
            $this->statsSets[] = $statsSet;
            $statsSet->setSource($this);
        }

        return $this;
    }

    public function removeStatsSet(StatsSet $statsSet): self
    {
        if ($this->statsSets->contains($statsSet)) {
            $this->statsSets->removeElement($statsSet);
            // set the owning side to null (unless already changed)
            if ($statsSet->getSource() === $this) {
                $statsSet->setSource(null);
            }
        }

        return $this;
    }
}
