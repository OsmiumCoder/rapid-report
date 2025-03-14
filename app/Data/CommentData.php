<?php

namespace App\Data;

use Spatie\LaravelData\Data;

/**
 * Request data object for creating and attaching comments to other models.
 */
class CommentData extends Data
{
    /**
     * @param string $content The comment string the user has given.
     */
    public function __construct(
        public string $content,
    ) {
    }
}
