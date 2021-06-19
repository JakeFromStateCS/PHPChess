<?php

declare(strict_types=1);

namespace PHPChess\Database\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="log")
 */

final class LogModel extends AbstractChessDBModel
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $message;

    /**
     * @ORM\Column(type="json", nullable=false)
     */
    private string $context;

    public function __construct(?string $message = null, array $context = [])
    {
        $this->message = $message;
        $this->context = json_encode($context);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @throws \JsonException
     */
    public function getContext(): array
    {
        return json_decode($this->context, true, 255, JSON_THROW_ON_ERROR);
    }
}
