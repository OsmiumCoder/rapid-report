<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class CommentData extends Data
{
    public function __construct(
        public string $content,
    ) {
    }
}
