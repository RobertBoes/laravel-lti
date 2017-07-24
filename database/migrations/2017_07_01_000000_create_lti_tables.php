<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLTITables extends Migration
{
    private $prefix = '';

    public function __construct()
    {
        $this->prefix = config('laravel-lti.database.prefix');
    }

    public function up()
    {
        Schema::create($this->prefix . 'lti2_consumer', function (Blueprint $table) {
            $table->increments('consumer_pk');
            $table->string('name', 50);
            $table->string('consumer_key256', 256);
            $table->text('consumer_key')->nullable();
            $table->string('secret', 1024);
            $table->string('lti_version', 10)->nullable();
            $table->string('consumer_name', 255)->nullable();
            $table->string('consumer_version', 255)->nullable();
            $table->string('consumer_guid', 1024)->nullable();
            $table->text('profile')->nullable();
            $table->text('tool_proxy')->nullable();
            $table->text('settings')->nullable();
            $table->boolean('protected');
            $table->boolean('enabled');
            $table->dateTime('enable_from')->nullable();
            $table->dateTime('enable_until')->nullable();
            $table->date('last_access')->nullable();
            $table->dateTime('created');
            $table->dateTime('updated');

            $table->unique('consumer_key256 ASC', 'lti2_consumer_consumer_key_UNIQUE');
        });

        Schema::create($this->prefix . 'lti2_consumer', function (Blueprint $table) {
            $table->increments(11);
            $table->string('tool_proxy_id', 32);
            $table->integer('consumer_pk');
            $table->text('tool_proxy');
            $table->dateTime('created');
            $table->dateTime('updated');

            $table->foreign('consumer_pk', 'lti2_tool_proxy_lti2_consumer_FK1')
                ->references('consumer_pk')->on($this->prefix . 'lti2_consumer');
            $table->index('consumer_pk ASC', 'lti2_tool_proxy_consumer_id_IDX');
            $table->unique('tool_proxy_id ASC', 'lti2_tool_proxy_tool_proxy_id_UNIQUE');
        });

        Schema::create($this->prefix . 'lti2_nonce', function (Blueprint $table) {
            $table->integer('consumer_pk');
            $table->string('value', 32);
            $table->dateTime('expires');

            $table->foreign('consumer_pk', 'lti2_nonce_lti2_consumer_FK1')
                ->references('consumer_pk')->on($this->prefix . 'lti2_consumer');
        });

        Schema::create($this->prefix . 'lti2_context', function (Blueprint $table) {
            $table->increments('context_pk');
            $table->integer('consumer_pk');
            $table->string('lti_context_id', 255);
            $table->text('settings');
            $table->dateTime('created');
            $table->dateTime('updated');

            $table->foreign('consumer_pk', 'lti2_context_lti2_consumer_FK1')
                ->references('consumer_pk')->on($this->prefix . 'lti2_consumer');
            $table->index('consumer_pk ASC', 'lti2_context_consumer_id_IDX');
        });

        Schema::create($this->prefix . 'lti2_resource_link', function (Blueprint $table) {
            $table->increments('resource_link_pk');
            $table->integer('context_pk')->nullable();
            $table->integer('consumer_pk')->nullable();
            $table->string('lti_resource_link_id', 255);
            $table->text('settings')->nullable();
            $table->integer('primary_resource_link_pk')->nullable();
            $table->boolean('share_approved')->nullable()->default(null);
            $table->dateTime('created');
            $table->dateTime('updated');

            $table->foreign('context_pk', 'lti2_resource_link_lti2_context_FK1')
                ->references('context_pk')->on($this->prefix . 'lti2_context');
            $table->foreign('primary_resource_link_pk', 'lti2_resource_link_lti2_resource_link_FK1')
                ->references('resource_link_pk')->on($this->prefix . 'lti2_resource_link');
            $table->index('consumer_pk ASC', 'lti2_resource_link_consumer_pk_IDX');
            $table->index('context_pk ASC', 'lti2_resource_link_context_pk_IDX');
        });

        Schema::create($this->prefix . 'lti2_user_result', function (Blueprint $table) {
            $table->increments('user_pk');
            $table->integer('resource_link_pk');
            $table->string('lti_user_id', 255);
            $table->string('lti_result_sourcedid', 1024);
            $table->dateTime('created');
            $table->dateTime('updated');

            $table->foreign('resource_link_pk', 'lti2_user_result_lti2_resource_link_FK1')
                ->references('resource_link_pk')->on($this->prefix . 'lti2_resource_link');
            $table->index('resource_link_pk ASC', 'lti2_user_result_resource_link_pk_IDX');
        });

        Schema::create($this->prefix . 'lti2_share_key', function (Blueprint $table) {
            $table->string('share_key_id', 32);
            $table->integer('resource_link_pk');
            $table->boolean('auto_approve');
            $table->dateTime('expires');

            $table->foreign('resource_link_pk', 'lti2_share_key_lti2_resource_link_FK1')
                ->references('resource_link_pk')->on($this->prefix . 'lti2_resource_link');
            $table->index('resource_link_pk ASC', 'lti2_share_key_resource_link_pk_IDX');
        });
    }

    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::drop($this->prefix . 'lti2_consumer');
        Schema::drop($this->prefix . 'lti2_tool_proxy');
        Schema::drop($this->prefix . 'lti2_nonce');
        Schema::drop($this->prefix . 'lti2_context');
        Schema::drop($this->prefix . 'lti2_resource_link');
        Schema::drop($this->prefix . 'lti2_user_result');
        Schema::drop($this->prefix . 'lti2_share_key');
        Schema::drop($this->prefix . 'users_lti_links');
        Schema::enableForeignKeyConstraints();
    }
}