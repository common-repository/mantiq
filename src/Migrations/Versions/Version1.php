<?php

namespace Mantiq\Migrations\Versions;

use Mantiq\Plugin;

class Version1
{
    public static function invoke()
    {
        $tableCharset = Plugin::env('db.charset');

        $workflowsTable    = Plugin::env('db.tables.workflows', 'workflows');
        $workflowsTableSql = <<<SQL
CREATE TABLE IF NOT EXISTS $workflowsTable (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    uid VARCHAR(36) NOT NULL,
    version INT UNSIGNED NOT NULL DEFAULT 1,
    enabled TINYINT(1) NOT NULL DEFAULT 0,
    type VARCHAR(36) NOT NULL,
    name TEXT NOT NULL,
    tree TEXT NOT NULL,
    settings TEXT NOT NULL,
    last_run_at timestamp NULL DEFAULT NULL,
    deleted_at timestamp NULL DEFAULT NULL,
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    PRIMARY KEY (id),
    INDEX workflow_uid (uid),
    INDEX workflow_type (type),
    INDEX workflow_enabled (enabled)
  ) $tableCharset;
SQL;


        $logTable    = Plugin::env('db.tables.log', 'log');
        $logTableSql = <<<SQL
CREATE TABLE IF NOT EXISTS $logTable (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    invocation_uid VARCHAR(36) NULL,
    workflow_uid VARCHAR(36) NOT NULL,
    node_uid VARCHAR(36) NULL,
    level VARCHAR(36) NOT NULL,
    message TEXT NULL,
    context TEXT NULL,
    logged_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX log_invocation_uid (invocation_uid),
    INDEX log_workflow_uid (workflow_uid),
    INDEX log_node_uid (node_uid),
    INDEX log_level (level)
  ) $tableCharset;
SQL;

        $GLOBALS['wpdb']->query($workflowsTableSql);
        $GLOBALS['wpdb']->query($logTableSql);
    }
}
