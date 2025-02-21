<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ModifyAssistantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assistants', function (Blueprint $table) {
            // Verificar y eliminar el índice único en la columna 'email' si existe
            DB::statement('ALTER TABLE assistants DROP INDEX IF EXISTS assistants_email_unique');
            // Verificar y eliminar el índice único en la combinación de 'email' y 'event_id' si existe
            DB::statement('ALTER TABLE assistants DROP INDEX IF EXISTS assistants_email_event_id_unique');
            // Agregar un nuevo índice único en la combinación de 'email' y 'event_id'
            DB::statement('ALTER TABLE assistants ADD UNIQUE assistants_email_event_id_unique(email, event_id)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assistants', function (Blueprint $table) {
            // Eliminar el índice único en la combinación de 'email' y 'event_id'
            DB::statement('ALTER TABLE assistants DROP INDEX IF EXISTS assistants_email_event_id_unique');
            // Agregar un índice único en la columna 'email'
            DB::statement('ALTER TABLE assistants ADD UNIQUE assistants_email_unique(email)');
        });
    }
}