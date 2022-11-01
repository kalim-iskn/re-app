<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use FileUploadInfoDTO;

/**
 * @ORM\Entity(repositoryClass=DoctrineFileUploadRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class FileUpload
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected int $id;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    protected string $fileName;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $linesCount;

    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    protected int $processedLinesCount = 0;

    /**
     * @ORM\Column(type="datetime")
     */
    protected DateTime $createdAt;

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist(): void
    {
        $this->createdAt = new DateTime("now");
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     */
    public function setFileName(string $fileName): void
    {
        $this->fileName = $fileName;
    }

    /**
     * @return int
     */
    public function getLinesCount(): int
    {
        return $this->linesCount;
    }

    /**
     * @param int $linesCount
     */
    public function setLinesCount(int $linesCount): void
    {
        $this->linesCount = $linesCount;
    }

    /**
     * @return int
     */
    public function getProcessedLinesCount(): int
    {
        return $this->processedLinesCount;
    }

    /**
     * @param int $processedLinesCount
     */
    public function setProcessedLinesCount(int $processedLinesCount): void
    {
        $this->processedLinesCount = $processedLinesCount;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function toDto(): FileUploadInfoDTO
    {
        $dto = new FileUploadInfoDTO();
        $dto->id = $this->id;
        $dto->fileName = $this->fileName;
        $dto->linesCount = $this->linesCount;
        $dto->processedLinesCount = $this->processedLinesCount;
        $dto->createdAt = $this->createdAt;

        return $dto;
    }
}
