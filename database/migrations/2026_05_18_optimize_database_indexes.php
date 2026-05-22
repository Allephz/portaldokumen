<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add indexes for faster queries
        
        // Users table - for login queries
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'email')) {
                $table->index('email');
            }
        });

        // Directors table - for dashboard queries
        Schema::table('directors', function (Blueprint $table) {
            if (!Schema::hasColumn('directors', 'id')) {
                $table->index('id');
            }
        });

        // Divisions table - for eager loading
        Schema::table('divisions', function (Blueprint $table) {
            if (!Schema::hasColumn('divisions', 'director_id')) {
                $table->index('director_id');
            }
        });

        // Departments table
        Schema::table('departments', function (Blueprint $table) {
            if (!Schema::hasColumn('departments', 'division_id')) {
                $table->index('division_id');
            }
        });

        // Department files table - for manager dashboard
        Schema::table('department_files', function (Blueprint $table) {
            if (!Schema::hasColumn('department_files', 'approval_status')) {
                $table->index('approval_status');
            }
            if (!Schema::hasColumn('department_files', 'file_category_id')) {
                $table->index('file_category_id');
            }
            if (!Schema::hasColumn('department_files', 'department_id')) {
                $table->index('department_id');
            }
            // Composite index for faster filtering
            $table->index(['approval_status', 'created_at']);
        });

        // Activity logs table - for activity logging
        // Note: Composite index ['user_id', 'created_at'] already exists in create migration
        Schema::table('activity_logs', function (Blueprint $table) {
            // Skip adding indexes as they already exist in create migration
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop indexes if they exist
        // Users table
        if (Schema::hasTable('users')) {
            try {
                DB::statement('ALTER TABLE users DROP INDEX users_email_index');
            } catch (\Exception $e) {
                // Index doesn't exist, skip
            }
        }

        // Divisions table
        if (Schema::hasTable('divisions')) {
            try {
                DB::statement('ALTER TABLE divisions DROP INDEX divisions_director_id_index');
            } catch (\Exception $e) {
                // Index doesn't exist, skip
            }
        }

        // Departments table
        if (Schema::hasTable('departments')) {
            try {
                DB::statement('ALTER TABLE departments DROP INDEX departments_division_id_index');
            } catch (\Exception $e) {
                // Index doesn't exist, skip
            }
        }

        // Department files table
        if (Schema::hasTable('department_files')) {
            try {
                DB::statement('ALTER TABLE department_files DROP INDEX department_files_approval_status_index');
            } catch (\Exception $e) {}
            try {
                DB::statement('ALTER TABLE department_files DROP INDEX department_files_file_category_id_index');
            } catch (\Exception $e) {}
            try {
                DB::statement('ALTER TABLE department_files DROP INDEX department_files_department_id_index');
            } catch (\Exception $e) {}
            try {
                DB::statement('ALTER TABLE department_files DROP INDEX department_files_approval_status_created_at_index');
            } catch (\Exception $e) {}
        }

        // Activity logs table
        if (Schema::hasTable('activity_logs')) {
            try {
                DB::statement('ALTER TABLE activity_logs DROP INDEX activity_logs_user_id_index');
            } catch (\Exception $e) {}
            try {
                DB::statement('ALTER TABLE activity_logs DROP INDEX activity_logs_created_at_index');
            } catch (\Exception $e) {}
            // Skip composite index as it already exists in create migration
        }
    }
};
