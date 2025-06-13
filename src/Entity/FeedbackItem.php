<?php

namespace ItkDev\TidyFeedbackBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ItkDev\TidyFeedbackBundle\Repository\FeedbackItemRepository;

#[ORM\Entity(repositoryClass: FeedbackItemRepository::class)]
class FeedbackItem implements \JsonSerializable, \Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    protected \DateTimeImmutable $createdAt;

    #[ORM\Column(length: 255)]
    private ?string $subject = null;

    public function __construct(
        #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
        protected ?string $createdBy = null,
    ) {
        $this->createdAt = new \DateTimeImmutable();
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
}
