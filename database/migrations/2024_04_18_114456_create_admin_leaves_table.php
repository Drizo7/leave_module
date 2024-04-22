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
        Schema::create('admin_leaves', function (Blueprint $table) {
            $table->id();
            $table->string('leave_id')->unique()->after('id');
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('type');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('reason');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('approver_id')->nullable();
            $table->foreign('approver_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_leaves');
    }
};
