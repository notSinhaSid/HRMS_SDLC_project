<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Override;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

    }

    public function test_login_is_locked_after_five_failed_attempts(): void
    {
        //
    }
}
