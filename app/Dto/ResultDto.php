<?php
namespace App\Dto;

use stdClass;
use Carbon\Carbon;
use App\Dto\UserDto;
use Ramsey\Uuid\Uuid;
use App\Dto\DtoInterface;
use Ramsey\Uuid\UuidInterface;

class ResultDto implements DtoInterface
{
    private UuidInterface $id;
    private UserDto $user;
    private int $score;
    private Carbon $finishedAt;

    public function __construct(stdClass $data)
    {
        $this->id = Uuid::fromString($data->id);
        $this->user = new UserDto($data->user);
        $this->score = $data->score;
        $this->finishedAt = new Carbon($data->finished_at);
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getUser(): UserDto
    {
        return $this->user;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function getFinishedAt(): Carbon
    {
        return $this->finishedAt;
    }
    
    public function toArray(): array
    {
        return [
            'id' => (string) $this->id,
            'user' => $this->user->toArray(),
            'score' => $this->score,
            'finished_at' => $this->finishedAt->toIso8601String(),
        ];
    }

}