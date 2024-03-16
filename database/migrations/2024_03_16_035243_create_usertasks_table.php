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
        Schema::create('usertasks', function (Blueprint $table) {
            $table->id();
            $table->integer('taskid'); //addcustomer-1, editcustomoer-2, deletecustomer-3, additem-4, edititem-5, deletitem-6
            $table->string('taskname');
            $table->integer('role'); //owner-1, manager-2, cashier-3
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usertasks');
    }
};