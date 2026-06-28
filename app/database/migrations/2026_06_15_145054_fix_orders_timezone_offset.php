<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Corrige pedidos guardados con APP_TIMEZONE=UTC mientras MySQL usaba hora local (Ecuador).
     * Esos registros quedaron 5 horas adelantados respecto a la hora real del pedido.
     */
    public function up(): void
    {
        if (! in_array(Schema::getConnection()->getDriverName(), ['mysql', 'mariadb'], true)) {
            return;
        }

        DB::statement('UPDATE orders SET created_at = DATE_SUB(created_at, INTERVAL 5 HOUR) WHERE created_at IS NOT NULL');
        DB::statement('UPDATE orders SET whatsapp_sent_at = DATE_SUB(whatsapp_sent_at, INTERVAL 5 HOUR) WHERE whatsapp_sent_at IS NOT NULL');
        DB::statement('UPDATE orders SET updated_at = DATE_SUB(updated_at, INTERVAL 5 HOUR) WHERE updated_at IS NOT NULL');
    }

    public function down(): void
    {
        if (! in_array(Schema::getConnection()->getDriverName(), ['mysql', 'mariadb'], true)) {
            return;
        }

        DB::statement('UPDATE orders SET created_at = DATE_ADD(created_at, INTERVAL 5 HOUR) WHERE created_at IS NOT NULL');
        DB::statement('UPDATE orders SET whatsapp_sent_at = DATE_ADD(whatsapp_sent_at, INTERVAL 5 HOUR) WHERE whatsapp_sent_at IS NOT NULL');
        DB::statement('UPDATE orders SET updated_at = DATE_ADD(updated_at, INTERVAL 5 HOUR) WHERE updated_at IS NOT NULL');
    }
};
