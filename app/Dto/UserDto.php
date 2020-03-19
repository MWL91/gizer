<?php
namespace App\Dto;

use stdClass;
use Ramsey\Uuid\Uuid;
use App\Dto\DtoInterface;
use Ramsey\Uuid\UuidInterface;

class UserDto implements DtoInterface
{
    private UuidInterface $id;
    private string $name;

    public function __construct(stdClass $data)
    {
        $this->id = Uuid::fromString($data->id);
        $this->name = $data->name;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function toArray(): array
    {
        return [
            'id' => (string) $this->id,
            'name' => $this->name
        ];
    }

}