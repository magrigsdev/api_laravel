<?php

use App\Models\Roles;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('personnels', function (Blueprint $table) {
            //
            $table->id();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('email')->unique();
            $table->string('telephone');
            $table->string('sexe');
            $table->text('addresse');
            $table->string('password');
            $table->date('hiring_date');
            $table->unsignedBigInteger('role_id');
            $table->text('photo');

            //contrainte
          
            $table->foreign('role_id')->references('id')
            ->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnels');
    }
};
