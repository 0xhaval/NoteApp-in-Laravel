<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Note extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'user_id',
        'content',
        'type',
        'image',
        // add all other fields
    ];

    /**
     * Get the user that owns the Note
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}