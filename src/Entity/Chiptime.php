<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chiptime
 *
 * @ORM\Table(name="chiptimes")
 * @ORM\Entity
 */
class Chiptime
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
     * @ORM\Column(name="antennaNo", type="integer", nullable=false)
     */
    private $antennano;

    /**
     * @var string
     *
     * @ORM\Column(name="chipCode", type="string", length=250, nullable=false)
     */
    private $chipcode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="chipTimeDt", type="datetime", nullable=false)
     */
    private $chiptimedt;

    /**
     * @var int
     *
     * @ORM\Column(name="chipTimeRaw", type="integer", nullable=false)
     */
    private $chiptimeraw;

    /**
     * @var int
     *
     * @ORM\Column(name="chipTimeRawMillisec", type="integer", nullable=false)
     */
    private $chiptimerawmillisec;

    /**
     * @var int
     *
     * @ORM\Column(name="isRewind", type="integer", nullable=false)
     */
    private $isrewind;

    /**
     * @var int
     *
     * @ORM\Column(name="logId", type="integer", nullable=false)
     */
    private $logid;

    /**
     * @var int
     *
     * @ORM\Column(name="readerNo", type="integer", nullable=false)
     */
    private $readerno;

    /**
     * @var int
     *
     * @ORM\Column(name="readerTime", type="integer", nullable=false)
     */
    private $readertime;

    /**
     * @var int
     *
     * @ORM\Column(name="rssi", type="integer", nullable=false)
     */
    private $rssi;

    /**
     * @var int
     *
     * @ORM\Column(name="startTime", type="integer", nullable=false)
     */
    private $starttime;

    /**
     * @var int
     *
     * @ORM\Column(name="ultraId", type="integer", nullable=false)
     */
    private $ultraid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAntennano(): ?int
    {
        return $this->antennano;
    }

    public function setAntennano(int $antennano): self
    {
        $this->antennano = $antennano;

        return $this;
    }

    public function getChipcode(): ?string
    {
        return $this->chipcode;
    }

    public function setChipcode(string $chipcode): self
    {
        $this->chipcode = $chipcode;

        return $this;
    }

    public function getChiptimedt(): ?\DateTimeInterface
    {
        return $this->chiptimedt;
    }

    public function setChiptimedt(\DateTimeInterface $chiptimedt): self
    {
        $this->chiptimedt = $chiptimedt;

        return $this;
    }

    public function getChiptimeraw(): ?int
    {
        return $this->chiptimeraw;
    }

    public function setChiptimeraw(int $chiptimeraw): self
    {
        $this->chiptimeraw = $chiptimeraw;

        return $this;
    }

    public function getChiptimerawmillisec(): ?int
    {
        return $this->chiptimerawmillisec;
    }

    public function setChiptimerawmillisec(int $chiptimerawmillisec): self
    {
        $this->chiptimerawmillisec = $chiptimerawmillisec;

        return $this;
    }

    public function getIsrewind(): ?int
    {
        return $this->isrewind;
    }

    public function setIsrewind(int $isrewind): self
    {
        $this->isrewind = $isrewind;

        return $this;
    }

    public function getLogid(): ?int
    {
        return $this->logid;
    }

    public function setLogid(int $logid): self
    {
        $this->logid = $logid;

        return $this;
    }

    public function getReaderno(): ?int
    {
        return $this->readerno;
    }

    public function setReaderno(int $readerno): self
    {
        $this->readerno = $readerno;

        return $this;
    }

    public function getReadertime(): ?int
    {
        return $this->readertime;
    }

    public function setReadertime(int $readertime): self
    {
        $this->readertime = $readertime;

        return $this;
    }

    public function getRssi(): ?int
    {
        return $this->rssi;
    }

    public function setRssi(int $rssi): self
    {
        $this->rssi = $rssi;

        return $this;
    }

    public function getStarttime(): ?int
    {
        return $this->starttime;
    }

    public function setStarttime(int $starttime): self
    {
        $this->starttime = $starttime;

        return $this;
    }

    public function getUltraid(): ?int
    {
        return $this->ultraid;
    }

    public function setUltraid(int $ultraid): self
    {
        $this->ultraid = $ultraid;

        return $this;
    }


}
