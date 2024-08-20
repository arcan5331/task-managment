<?php

namespace App\Models;

use App\Casts\JalaliDateCast;
use App\Enums\TaskType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\TaskSuperiority;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'superiority',
        'du_date',
        'type',
    ];

    protected $casts = [
        'du_date' => JalaliDateCast::class
    ];

    protected function superiority(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->getSuperiority($value),
            set: fn($value) => $this->setSuperiority($value)
        );
    }

    protected function type(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->getType($value),
            set: fn($value) => $this->setType($value)
        );
    }

    protected function setSuperiority($type): int
    {
        return match ($type) {
            TaskSuperiority::insignificant->value => 0,
            TaskSuperiority::normal->value => 1,
            TaskSuperiority::critical->value => 2,
            default => 1,
        };
    }

    protected function getSuperiority($value): string
    {
        return match ($value) {
            0 => TaskSuperiority::insignificant->value,
            1 => TaskSuperiority::normal->value,
            2 => TaskSuperiority::critical->value,
            default => TaskSuperiority::normal->value,
        };
    }

    protected function setType($type): int
    {
        return match ($type) {
            TaskType::overDu->value => 0,
            TaskType::onGoing->value => 1,
            TaskType::completed->value => 2,
            default => 1,
        };
    }

    protected function getType($value): string
    {
        return match ($value) {
            0 => TaskType::overDu->value,
            1 => TaskType::onGoing->value,
            2 => TaskType::completed->value,
            default => TaskType::onGoing->value,
        };
    }

    public function complete(): bool
    {
        return $this->update([
            'type' => 'completed'
        ]);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
