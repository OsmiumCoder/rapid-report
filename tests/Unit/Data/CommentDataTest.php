<?php

namespace Tests\Unit\Data;

use App\Data\CommentData;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CommentDataTest extends TestCase
{
    public function test_incident_data_valid_with_correct_values(): void
    {

        $commentData = CommentData::validateAndCreate([
            'content' => 'comments',
        ]);

        $this->assertInstanceOf(CommentData::class, $commentData);
    }

    public function test_comment_data_throws_invalid_if_empty_comment(): void
    {
        $this->expectException(ValidationException::class);

        CommentData::validateAndCreate([
            'content' => '',
        ]);
    }

    public function test_comment_data_throws_invalid_if_no_comment(): void
    {
        $this->expectException(ValidationException::class);

        CommentData::validateAndCreate([]);
    }
}
