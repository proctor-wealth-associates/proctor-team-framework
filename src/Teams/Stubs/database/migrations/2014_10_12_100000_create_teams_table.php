<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Elegon::user()->getTable(), function ( Blueprint $table ) {
            $table->integer('current_team_id')->unsigned()->nullable();
        });


        Schema::create(Elegon::team()->getTable(), function ( Blueprint $table ) {
            $table->increments('id')->unsigned();
            $table->integer('owner_id')->unsigned()->nullable();
            $table->string('photo_url')->nullable();
            $table->string('name');
            $table->timestamps();

            $table->foreign('owner_id')
                ->references('id')
                ->on(Elegon::user()->getTable());
        });

        Schema::create(config('elegon.teams.team_user_table'), function ( Blueprint $table ) {
            $table->integer('user_id')->unsigned();
            $table->integer('team_id')->unsigned();
            $table->timestamps();
            // Pivot data

            $table->primary([ 'user_id', 'team_id' ]);

            $table->foreign('user_id')
                ->references('id')
                ->on(Elegon::user()->getTable())
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('team_id')
                ->references('id')
                ->on(Elegon::team()->getTable())
                ->onDelete('cascade');
        });

        Schema::create(config('elegon.teams.invite_table'), function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('team_id')->unsigned();
            $table->enum('type', [ 'invite', 'request' ]);
            $table->string('email');
            $table->string('token');
            $table->timestamps();
                
            $table->foreign('user_id')
                ->references('id')
                ->on(Elegon::user()->getTable());

            $table->foreign('team_id')
                ->references('id')
                ->on(Elegon::team()->getTable())
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Elegon::user()->getTable(), function(Blueprint $table) {
            $table->dropColumn('current_team_id');
        });

        Schema::table(config('elegon.teams.team_user_table'), function (Blueprint $table) {
            $table->dropForeign([ 'user_id' ]);
            $table->dropForeign([ 'team_id' ]);
        });

        Schema::drop(config('elegon.teams.team_user_table'));
        Schema::drop(config('elegon.teams.invite_table'));
        Schema::drop(Elegon::team()->getTable());

    }
}
