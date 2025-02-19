<?php
// filepath: /D:/Xampp/htdocs/jornadas-de-videojuegos/database/migrations/0001_01_01_000005_create_assistants_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssistantsTable extends Migration
{
    public function up()
    {
        Schema::create('assistants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('email');
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->enum('attendance_type', ['presencial', 'virtual', 'gratuita']);
            $table->enum('payment_status', ['pending', 'completed'])->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['email', 'event_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('assistants');
    }
}