<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSnapshotsTable extends Migration
{
    public function up(): void
    {
        Schema::create('snapshots', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->uuid('aggregate_uuid');
            $table->unsignedInteger('aggregate_version');
            $table->json('state');

            $table->timestamps();

            $table->index('aggregate_uuid');
        });
    }
}
