<?php

namespace App\Models;

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
        'du_date'
    ];

    protected $casts = [
        'du_date' => 'date'
    ];

    protected function superiority(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->getSuperiority($value),
            set: fn($value) => $this->setSuperiority($value)
        );
    }

    protected function setSuperiority($type): int
    {
        return match ($type) {
            TaskSuperiority::insignificant => 0,
            TaskSuperiority::normal => 1,
            TaskSuperiority::critical => 2,
            default => 1,
        };
    }

    protected function getSuperiority($value): string
    {
        return match ($value) {
            0 => TaskSuperiority::insignificant->name,
            1 => TaskSuperiority::normal->name,
            2 => TaskSuperiority::critical->name,
            default => TaskSuperiority::normal->name,
        };
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
