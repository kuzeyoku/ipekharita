<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Static texts are managed via local file (lang/tr/site.php) without database storage.
    }

    public function down(): void
    {
        // No-op
    }
};
