<?php
declare(strict_types=1);
<<<<<<< HEAD:src/Exception/TncException.php
namespace TNC\Exception;
use Exception;
=======

namespace MediaParkPK\TNC\Exception;
>>>>>>> 9e417ea224497d31264febadc721afdac6e151c8:src/Exception/TNC_APIException.php

/**
 * Class TncAPIException
 * @package MediaParkPK\TNC\Exception
 */
<<<<<<< HEAD:src/Exception/TncException.php
class TncException extends Exception
=======
class TNC_APIException extends TNC_Exception
>>>>>>> 9e417ea224497d31264febadc721afdac6e151c8:src/Exception/TNC_APIException.php
{
    /**
     * @param string $method
     * @param string $expected
     * @param string $got
     * @return static
     */
    public static function unexpectedResultType(string $method, string $expected, string $got): self
    {
        return new self(
            sprintf('Method [%s] expects result type %s, got %s', $method, strtoupper($expected), strtoupper($got))
        );
    }
}
