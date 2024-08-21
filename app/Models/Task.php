<?php

namespace App\Models;

use App\Casts\JalaliDateCast;
use App\Enums\TaskStatus;
use App\Observers\TaskObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\TaskSuperiority;
use Illuminate\Database\Eloquent\Casts\Attribute;

#[ObservedBy(TaskObserver::class)]
class Task extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'superiority',
        'du_date',
        'status',
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

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->getStatus($value),
            set: fn($value) => $this->setStatus($value)
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

    protected function setStatus($type): int
    {
        return match ($type) {
            TaskStatus::overDu->value => 0,
            TaskStatus::onGoing->value => 1,
            TaskStatus::completed->value => 2,
            default => 1,
        };
    }

    protected function getStatus($value): string
    {
        return match ($value) {
            0 => TaskStatus::overDu->value,
            1 => TaskStatus::onGoing->value,
            2 => TaskStatus::completed->value,
            default => TaskStatus::onGoing->value,
        };
    }

    public function complete(): bool
    {
        return $this->update([
            'type' => 'completed'
        ]);
    }

    public function toggleCompletionStatus(): bool
    {
        return $this->update([
            'status' => $this->status === TaskStatus::completed->value
                ? TaskStatus::onGoing->value
                : TaskStatus::completed->value
        ]);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
