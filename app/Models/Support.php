<?php

namespace App\Models;

use App\Enums\SupportRole;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Support extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'role'
    ];

    protected $casts = [
        'role' => SupportRole::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
