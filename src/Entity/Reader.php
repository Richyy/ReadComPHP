<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reader
 *
 * @ORM\Table(name="reader")
 * @ORM\Entity
 */
class Reader
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="ip", type="integer", nullable=false)
     */
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="timing_point", type="string", length=255, nullable=false)
     */
    private $timingPoint;

    /**
     * @var int
     *
     * @ORM\Column(name="connection_status", type="integer", nullable=false)
     */
    private $connectionStatus;

    /**
     * @var int
     *
     * @ORM\Column(name="reading_status", type="integer", nullable=false)
     */
    private $readingStatus;

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

    public function getConnectionStatus(): ?int
    {
        return $this->connectionStatus;
    }

    public function setConnectionStatus(int $connectionStatus): self
    {
        $this->connectionStatus = $connectionStatus;

        return $this;
    }

    public function getReadingStatus(): ?int
    {
        return $this->readingStatus;
    }

    public function setReadingStatus(int $readingStatus): self
    {
        $this->readingStatus = $readingStatus;

        return $this;
    }
}
