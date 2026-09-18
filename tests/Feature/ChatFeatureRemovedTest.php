<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ChatFeatureRemovedTest extends TestCase
{
    public function test_chat_routes_are_removed(): void
    {
        $this->assertFalse(Route::has('chat.index'));
        $this->assertFalse(Route::has('messages.index'));
    }
}
