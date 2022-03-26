<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string("phone")->nullable();
            $table->text("address")->nullable();
            $table->text("about_supplier")->nullable();
            $table->date("joining_date")->nullable();
            $table->enum('status', ['Pending', 'Approve', 'Reject'])->default('Pending');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('type')->nullable();
            $table->boolean('user_type')->comment('1 = Admin, 2 = staff and 3 = user')->nullable();
            $table->decimal('rating', 3, 2);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
