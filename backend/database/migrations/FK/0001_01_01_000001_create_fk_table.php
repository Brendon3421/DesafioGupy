<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $foreignKeyExists = DB::select(
                "SELECT * FROM information_schema.KEY_COLUMN_USAGE 
                 WHERE TABLE_NAME = 'users' AND CONSTRAINT_NAME = 'users_genero_id_foreign'"
            );
            if (empty($foreignKeyExists)) {
                $table->foreignId('genero_id')->after('name')->nullable()->constrained('genero')->onDelete('set null');
            }

            $foreignKeyExists = DB::select(
                "SELECT * FROM information_schema.KEY_COLUMN_USAGE 
                 WHERE TABLE_NAME = 'users' AND CONSTRAINT_NAME = 'users_situacao_id_foreign'"
            );
            if (empty($foreignKeyExists)) {
                $table->foreignId('situacao_id')->after('genero_id')->default(1)->constrained('situacao')->onDelete('cascade');
            }
        });

        Schema::table('task', function (Blueprint $table) {
            $foreignKeyExists = DB::select(
                "SELECT * FROM information_schema.KEY_COLUMN_USAGE 
                 WHERE TABLE_NAME = 'task' AND CONSTRAINT_NAME = 'task_users_id_foreign'"
            );
            if (empty($foreignKeyExists)) {
                $table->foreignId('user_id')->after('finished_at')->nullable()->constrained('users')->onDelete('set null');
            }

            $foreignKeyExists = DB::select(
                "SELECT * FROM information_schema.KEY_COLUMN_USAGE 
                 WHERE TABLE_NAME = 'task' AND CONSTRAINT_NAME = 'users_task_id_foreign'"
            );
            if (empty($foreignKeyExists)) {
                $table->foreignId('situacao_id')->after('finished_at')->default(1)->constrained('situacao')->onDelete('cascade');
            }
            $foreignKeyExists = DB::select(
                "SELECT * FROM information_schema.KEY_COLUMN_USAGE 
                 WHERE TABLE_NAME = 'task' AND CONSTRAINT_NAME = '_task_category_id_foreign'"
            );
            if (empty($foreignKeyExists)) {
                $table->foreignId('category_id')->after('finished_at')->constrained('category')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['situacao_id']);
            $table->dropForeign(['genero_id']);
        });
        Schema::table('task', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['situacao_id']);
            $table->dropForeign(['category_id']);
        });
    }
};
