<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('company_profiles', 'name')) {
                $table->string('name')->nullable()->after('id');
            }
            if (!Schema::hasColumn('company_profiles', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('company_profiles', 'email')) {
                $table->string('email')->nullable();
            }
            if (!Schema::hasColumn('company_profiles', 'address')) {
                $table->text('address')->nullable();
            }
            if (!Schema::hasColumn('company_profiles', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('company_profiles', 'running_text')) {
                $table->text('running_text')->nullable();
            }
            if (!Schema::hasColumn('company_profiles', 'whatsapp')) {
                $table->string('whatsapp')->nullable();
            }
            if (!Schema::hasColumn('company_profiles', 'instagram')) {
                $table->string('instagram')->nullable();
            }
            if (!Schema::hasColumn('company_profiles', 'facebook')) {
                $table->string('facebook')->nullable();
            }
            if (!Schema::hasColumn('company_profiles', 'google_maps_link')) {
                $table->text('google_maps_link')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            //
        });
    }
};