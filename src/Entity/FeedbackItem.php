<?php

namespace ItkDev\TidyFeedbackBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ItkDev\TidyFeedbackBundle\ItemStatus;
use ItkDev\TidyFeedbackBundle\Repository\FeedbackItemRepository;

#[ORM\Entity(repositoryClass: FeedbackItemRepository::class)]
class FeedbackItem implements \JsonSerializable, \Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(length: 255)]
    private string $status;

    #[ORM\Column(length: 255)]
    private string $subject;

    #[ORM\Column(type: Types::JSON, length: 255)]
    private array $data;

    public function __construct(
        #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
        protected ?string $createdBy = null,
    ) {
        $this->createdAt = new \DateTimeImmutable();
        $this->setStatus(ItemStatus::NEW);
    }

    public function __toString(): string
    {
        return sprintf('%s: %s', $this->id, $this->subject);
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'subject' => $this->subject,
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getStatus(): ItemStatus
    {
        return ItemStatus::from($this->status);
    }

    public function setStatus(ItemStatus $status): static
    {
        $this->status = $status->value;

        return $this;
    }

    public function getData(): array
    {
       return $this->data;
    }

    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }
}
