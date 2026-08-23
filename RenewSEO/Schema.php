<?php

namespace TypechoPlugin\RenewSEO;

use Typecho\Db;
use Utils\Schema as CoreSchema;

class Schema
{
    public static function ensure(Db $db): void
    {
        $dialect = CoreSchema::dialect($db);
        $prefix = $db->getPrefix();

        self::ensureLogs($db, $dialect, $prefix . 'renew_seo_logs');
        self::ensureNotFound($db, $dialect, $prefix . 'renew_seo_404');
    }

    private static function ensureLogs(Db $db, string $dialect, string $table): void
    {
        $name = CoreSchema::quote($table, $dialect);

        $db->query(match ($dialect) {
            'sqlite' => 'CREATE TABLE IF NOT EXISTS ' . $name . ' ('
                . '"id" INTEGER PRIMARY KEY AUTOINCREMENT,'
                . '"channel" TEXT NOT NULL,'
                . '"action" TEXT NOT NULL,'
                . '"level" TEXT NOT NULL,'
                . '"target" TEXT DEFAULT NULL,'
                . '"message" TEXT NOT NULL,'
                . '"payload" TEXT DEFAULT NULL,'
                . '"created_at" INTEGER NOT NULL'
                . ')',
            'pgsql' => 'CREATE TABLE IF NOT EXISTS ' . $name . ' ('
                . '"id" BIGSERIAL PRIMARY KEY,'
                . '"channel" VARCHAR(24) NOT NULL,'
                . '"action" VARCHAR(32) NOT NULL,'
                . '"level" VARCHAR(16) NOT NULL,'
                . '"target" TEXT DEFAULT NULL,'
                . '"message" VARCHAR(255) NOT NULL,'
                . '"payload" TEXT DEFAULT NULL,'
                . '"created_at" INTEGER NOT NULL'
                . ')',
            default => 'CREATE TABLE IF NOT EXISTS ' . $name . ' ('
                . '`id` bigint unsigned NOT NULL auto_increment,'
                . '`channel` varchar(24) NOT NULL,'
                . '`action` varchar(32) NOT NULL,'
                . '`level` varchar(16) NOT NULL,'
                . '`target` varchar(512) DEFAULT NULL,'
                . '`message` varchar(255) NOT NULL,'
                . '`payload` text DEFAULT NULL,'
                . '`created_at` int unsigned NOT NULL,'
                . 'PRIMARY KEY (`id`)'
                . ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=' . CoreSchema::detectMysqlCollation($db),
        }, Db::WRITE);

        $index = static fn(string $mysql, string $other): string => $dialect === 'mysql' ? $mysql : $table . '_' . $other;

        CoreSchema::ensureIndex($db, $table, $index('idx_channel_created', 'channel_created'), ['channel', 'created_at']);
        CoreSchema::ensureIndex($db, $table, $index('idx_level_created', 'level_created'), ['level', 'created_at']);
        CoreSchema::ensureIndex($db, $table, $index('idx_created', 'created'), ['created_at']);
    }

    private static function ensureNotFound(Db $db, string $dialect, string $table): void
    {
        $name = CoreSchema::quote($table, $dialect);

        $db->query(match ($dialect) {
            'sqlite' => 'CREATE TABLE IF NOT EXISTS ' . $name . ' ('
                . '"id" INTEGER PRIMARY KEY AUTOINCREMENT,'
                . '"path_hash" TEXT NOT NULL,'
                . '"path" TEXT NOT NULL,'
                . '"full_url" TEXT NOT NULL,'
                . '"referer" TEXT DEFAULT NULL,'
                . '"ip" TEXT DEFAULT NULL,'
                . '"ua" TEXT DEFAULT NULL,'
                . '"hits" INTEGER NOT NULL DEFAULT 1,'
                . '"first_seen" INTEGER NOT NULL,'
                . '"last_seen" INTEGER NOT NULL'
                . ')',
            'pgsql' => 'CREATE TABLE IF NOT EXISTS ' . $name . ' ('
                . '"id" BIGSERIAL PRIMARY KEY,'
                . '"path_hash" CHAR(40) NOT NULL,'
                . '"path" TEXT NOT NULL,'
                . '"full_url" TEXT NOT NULL,'
                . '"referer" TEXT DEFAULT NULL,'
                . '"ip" VARCHAR(45) DEFAULT NULL,'
                . '"ua" TEXT DEFAULT NULL,'
                . '"hits" INTEGER NOT NULL DEFAULT 1,'
                . '"first_seen" INTEGER NOT NULL,'
                . '"last_seen" INTEGER NOT NULL'
                . ')',
            default => 'CREATE TABLE IF NOT EXISTS ' . $name . ' ('
                . '`id` bigint unsigned NOT NULL auto_increment,'
                . '`path_hash` char(40) NOT NULL,'
                . '`path` varchar(512) NOT NULL,'
                . '`full_url` varchar(1024) NOT NULL,'
                . '`referer` varchar(1024) DEFAULT NULL,'
                . '`ip` varchar(45) DEFAULT NULL,'
                . '`ua` varchar(512) DEFAULT NULL,'
                . '`hits` int unsigned NOT NULL DEFAULT 1,'
                . '`first_seen` int unsigned NOT NULL,'
                . '`last_seen` int unsigned NOT NULL,'
                . 'PRIMARY KEY (`id`)'
                . ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=' . CoreSchema::detectMysqlCollation($db),
        }, Db::WRITE);

        $index = static fn(string $mysql, string $other): string => $dialect === 'mysql' ? $mysql : $table . '_' . $other;

        CoreSchema::ensureIndex($db, $table, $index('uniq_path_hash', 'path_hash'), ['path_hash'], true);
        CoreSchema::ensureIndex($db, $table, $index('idx_last_seen', 'last_seen'), ['last_seen']);
        CoreSchema::ensureIndex($db, $table, $index('idx_hits', 'hits'), ['hits']);
    }
}
