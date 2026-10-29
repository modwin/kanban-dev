<?php

declare(strict_types=1);

namespace WPROG2\FinalProject\src\Config;

class EnvSetter
{
    private string $envPath;

    /**
     * @param string $envPath Standard-sökväg till .env-filen.
     */
    public function __construct(string $envPath = __DIR__ . '/../../../../.env')
    {
        $this->envPath = $envPath;
    }

    /**
     * Läser in .env-filen och sätter miljövariablerna.
     *
     * @param string|null $overridePath Sätts om du vill ange en specifik sökväg vid anropet.
     * @param bool $overwrite Sätts till true om befintliga miljövariabler ska skrivas över (default: false).
     */
    public function load(?string $overridePath = null, bool $overwrite = false): void
    {
        $path = $overridePath ?? $this->envPath;

        if (!file_exists($path) || !is_readable($path)) {
            return;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            return;
        }

        foreach ($lines as $line) {
            $line = trim($line);

            // Hoppa över tomma rader och kommentarer
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            if (str_contains($line, '=')) {
                [$key, $value] = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value, " \t\n\r\0\x0B\"'");

                if ($overwrite || getenv($key) === false) {
                    putenv("{$key}={$value}");
                    $_ENV[$key] = $value;
                    $_SERVER[$key] = $value;
                }
            }
        }
    }

    /**
     * Statisk snabbmetod för enkel-radsanrop utan att manuellt instansiera klassen.
     */
    public static function loadFrom(string $envPath, bool $overwrite = false): void
    {
        $envSetter = new self($envPath);
        $envSetter->load(overwrite: $overwrite);
    }

    public function getEnvPath(): string
    {
        return $this->envPath;
    }

    public function setEnvPath(string $envPath): void
    {
        $this->envPath = $envPath;
    }
}