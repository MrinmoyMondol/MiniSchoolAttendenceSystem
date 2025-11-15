<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('attendances', function (Blueprint $table) {
        $table->id();
        $table->foreignId('student_id')->constrained()->cascadeOnDelete();
        $table->date('date')->index();
        $table->enum('status', ['present','absent','late'])->default('present');
        $table->text('note')->nullable();
        $table->foreignId('recorded_by')->nullable()->constrained('users'); // optional user model
        $table->timestamps();

        $table->unique(['student_id','date']); // one record per student per date
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendences');
    }
};
