<?php

namespace Halim\EKlaim\Builders;

class BodyBuilder
{
    /**
     * Static property to hold metadata.
     *
     * @var array
     */
    private static $metadata = [];

    /**
     * Static property to hold data.
     *
     * @var array
     */
    private static $data = [];

    /**
     * Sets the metadata.
     *
     * @param string $method The method name to include in metadata.
     * @param array $optional Optional additional fields to include in metadata.
     */
    public static function setMetadata(string $method, array $optional = []): void
    {
        self::$metadata = array_merge([
            "method" => $method
        ], $optional);
    }

    /**
     * Sets the data.
     *
     * @param array $data The data to include in the data array.
     */
    public static function setData(array $data): void
    {
        self::$data = $data;
    }

    /**
     * Combines metadata and data arrays into a single array.
     *
     * @return array The combined array with metadata and data.
     */
    public static function prepared(): array
    {
        return array_merge(
            ['metadata' => self::$metadata],
            ['data' => self::$data]
        );
    }

    /**
     * Constructs a complete payload array with metadata and data.
     *
     * @param string $method The method name to include in metadata.
     * @param array $data The data to include in the data array.
     * @param array $optional Optional additional fields to include in metadata.
     * @return array The complete payload array.
     */
    public static function build(string $method, array $data, array $optional = []): array
    {
        self::setMetadata($method, $optional);
        self::setData($data);

        return self::prepared();
    }
}
