<?php

namespace JuniorFontenele\LaravelVersion;

class LaravelVersion
{
    public static function version(): string
    {
        $version = self::readVersion() ?? self::generateVersion();
        return $version . '-' . env('APP_ENV', 'x');
    }

    protected static function generateVersion(): string
    {
        if (!is_null(env('GITHUB_SHA'))) {
            $hash = substr(env('GITHUB_SHA'), 0, 7);
            $branch = env('GITHUB_REF_NAME');
        }
        else {
            exec('git rev-parse --short --verify HEAD 2> /dev/null', $outputHash);
            $hash = $outputHash[0] ?? 'x';
            exec('git rev-parse --abbrev-ref HEAD 2> /dev/null', $outputBranch);
            $branch = $outputBranch[0] ?? 'x';
        }
        exec('git describe --tags HEAD 2> /dev/null', $outputTag);
        $date = date('Ymd');
        $tag = $outputTag[0] ?? 'v1.0.0';
        $appVersion = "$date-$hash";

        return $appVersion;
    }

    public static function writeVersion(): void
    {
        $versionFile = fopen(config('laravel-version.file'), 'w');
        fwrite($versionFile, self::generateVersion());
        fclose($versionFile);
    }

    public static function readVersion(): string|null
    {
        if (!file_exists(config('laravel-version.file'))) {
            return null;
        }
        return file_get_contents(config('laravel-version.file'));
    }
}
