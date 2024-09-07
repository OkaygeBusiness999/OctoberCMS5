<?php namespace Acme\Jarvis\Updates;

use Illuminate\Support\Facades\Schema;
use October\Rain\Database\Updates\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConversationsTable extends Migration
{
    public function up()
    {
        Schema::create('acme_jarvis_conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users'); // Assuming rainlab.user plugin
            $table->text('message');
            $table->text('response')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('acme_jarvis_conversations');
    }
}