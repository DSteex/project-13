<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['link_id', 'ip_address'])]

class LinkClick extends Model
{
    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class);
    }
}
