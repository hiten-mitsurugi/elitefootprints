<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddUserIdToOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Step 1: Add user_id column as nullable initially
        Schema::table('order_items', function (Blueprint $table) {
            $table->bigInteger('user_id')->nullable()->after('id'); // Add user_id as nullable
        });

        // Step 2: Add foreign key constraint to the user_id column
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Step 3: Populate the user_id column with valid data (assuming user with id 1 exists)
        DB::table('order_items')->update(['user_id' => 1]); // Ensure user with id=1 exists

        // Step 4: Once user_id is populated, make it non-nullable
        Schema::table('order_items', function (Blueprint $table) {
            $table->bigInteger('user_id')->nullable(false)->change(); // Change user_id column to non-nullable
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the foreign key and the user_id column
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Drop the foreign key
            $table->dropColumn('user_id'); // Drop the user_id column
        });
    }
}
