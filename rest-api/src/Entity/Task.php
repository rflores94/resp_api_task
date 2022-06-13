<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task implements \JsonSerializable
{
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'datetime')]
    private $created_data;

    #[ORM\Column(type: 'datetime')]
    private $updated_data;

    #[ORM\Column(type: 'boolean')]
    private $done;

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedData(): ?\DateTimeInterface
    {
        return $this->created_data;
    }

    public function setCreatedData(\DateTimeInterface $created_data): self
    {
        $this->created_data = $created_data;

        return $this;
    }

    public function getUpdatedData(): ?\DateTimeInterface
    {
        return $this->updated_data;
    }

    public function setUpdatedData(\DateTimeInterface $updated_data): self
    {
        $this->updated_data = $updated_data;

        return $this;
    }

    public function isDone(): ?bool
    {
        return $this->done;
    }

    public function setDone(bool $done): self
    {
        $this->done = $done;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'created_data' => $this->getCreatedData(),
            'updated_data' => $this->getUpdatedData(),
            'done' => $this->isDone(),
        ];
    }
}
