<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('meeting_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('availability_id')->constrained()->cascadeOnDelete();
            $table->foreignId('therapist_id')->constrained('users')->cascadeOnDelete();
            $table->text('message');
            $table->unsignedTinyInteger('status'); // MeetingRequestStatus
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meeting_requests');
    }
};
