<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('invoice_services', function (Blueprint $table) {
            $table->decimal('cgst_rate', 5, 2)->default(0)->after('rate');
            $table->decimal('sgst_rate', 5, 2)->default(0)->after('cgst_rate');
            $table->decimal('igst_rate', 5, 2)->default(0)->after('sgst_rate');
            $table->decimal('discount', 10, 2)->default(0)->after('igst_rate');
            $table->decimal('scheme_amount', 10, 2)->default(0)->after('discount');
            $table->decimal('basic_amount', 10, 2)->default(0)->after('scheme_amount');
            $table->decimal('gst_amount', 10, 2)->default(0)->after('basic_amount');
            $table->decimal('total_amount', 10, 2)->default(0)->after('gst_amount');
            $table->dropColumn('amount');
            $table->dropColumn('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_services', function (Blueprint $table) {
            $table->decimal('amount', 10, 2)->after('rate');
            $table->text('description')->nullable()->after('amount');
            $table->dropColumn([
                'cgst_rate',
                'sgst_rate',
                'igst_rate',
                'discount',
                'scheme_amount',
                'basic_amount',
                'gst_amount',
                'total_amount'
            ]);
        });
    }
};
