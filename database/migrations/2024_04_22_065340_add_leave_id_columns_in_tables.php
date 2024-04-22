<?php

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
        Schema::table('employee_leaves', function (Blueprint $table) {
            $table->integer('leave_id')->unique()->after('id');
        });

        Schema::table('admin_leaves', function (Blueprint $table) {
            $table->unsignedBigInteger('leave_id')->after('id');
            $table->foreign('leave_id')->references('leave_id')->on('employee_leaves')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_leaves', function (Blueprint $table) {
            $table->dropColumn('leave_id');
        });

        Schema::table('admin_leaves', function (Blueprint $table) {
            $table->dropForeign(['leave_id']);
            $table->dropColumn('leave_id');
        });
    }
};