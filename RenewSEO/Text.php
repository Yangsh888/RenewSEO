<?php
declare(strict_types=1);

namespace TypechoPlugin\RenewSEO;

if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

class Text
{
    public static function e(?string $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }

    public static function slice(?string $value, int $max): string
    {
        $value = (string) $value;
        if ($max <= 0 || $value === '') {
            return $max <= 0 ? '' : $value;
        }

        return mb_substr($value, 0, $max, 'UTF-8');
    }

    public static function time(int $timestamp): string
    {
        return $timestamp > 0 ? (new \Typecho\Date($timestamp))->format('Y-m-d H:i:s') : '未生成';
    }
}
