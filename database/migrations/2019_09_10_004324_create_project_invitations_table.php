<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_invitations', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('project_id');
			$table->string('email');
            $table->timestamps();

			$table->unique(['project_id', 'email']);

			$table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_invitations');
    }
}
