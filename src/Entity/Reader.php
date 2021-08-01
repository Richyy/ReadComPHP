<?php

namespace App\Entity;

use App\Repository\ReaderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReaderRepository::class)
 */
class Reader
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
    private $ip;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $timingPoint;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIp(): ?int
    {
        return $this->ip;
    }

    public function setIp(int $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getTimingPoint(): ?string
    {
        return $this->timingPoint;
    }

    public function setTimingPoint(string $timingPoint): self
    {
        $this->timingPoint = $timingPoint;

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
}
