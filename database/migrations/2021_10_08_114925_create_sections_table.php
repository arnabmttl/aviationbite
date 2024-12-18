<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('section_view_id');
            $table->unsignedBigInteger('pageable_id');
            $table->string('pageable_type');
            $table->unsignedBigInteger('sectionable_id')->nullable();
            $table->string('sectionable_type')->nullable();
            $table->string('title');
            $table->string('sub_title')->nullable();
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->unsignedInteger('margin_top')->nullable();
            $table->unsignedInteger('margin_bottom')->nullable();
            $table->boolean('bg_color')->default(0);
            $table->string('redirection_url')->nullable();
            $table->timestamps();

            $table->foreign('section_view_id')
                  ->references('id')->on('section_views')
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
        Schema::dropIfExists('sections');
    }
}
