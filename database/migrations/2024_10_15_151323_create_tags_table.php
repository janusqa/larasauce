<?php

use App\Models\Job;
use App\Models\Tag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('job_tag', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('job_id');
            // $table->unsignedBigInteger('tag_id');

            // can set the name of the foreign key column instead of excepting the default which would be 'job_id'
            $table->foreignIdFor(Job::class, 'job_listing_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Tag::class)->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_tag');
        Schema::dropIfExists('tags');
    }
};
