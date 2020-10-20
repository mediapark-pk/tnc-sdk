<?php
declare(strict_types=1);
namespace TNC\Exception;
/**
 * Class TncException
 * @package TNC\Exception
 */
class TncException extends \Exception
{
    /**
     * @param string $method
     * @param string $expected
     * @param string $got
     * @return TncException
     */
    public static function unexpectedResultType(string $method, string $expected, string $got): self
    {
        return new self(
            sprintf('Method [%s] expects result type %s, got %s', $method, strtoupper($expected), strtoupper($got))
        );
    }
}