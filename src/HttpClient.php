<?php
declare(strict_types=1);

namespace MediaParkPK\TNC;

use Comely\Http\Exception\HttpException;
use Comely\Http\Request;
use MediaParkPK\TNC\Exception\TNC_APIException;

/**
 * Class HttpClient
 * @package MediaParkPK\TNC
 */
class HttpClient
{
    /** @var string */
    private string $ip;
    /** @var int|null */
    private ?int $port;
    /** @var string|null */
    private ?string $username;
    /** @var string|null */
    private ?string $password;
    /** @var bool */
    private bool $https;

    /**
     * HttpClient constructor.
     * @param string $ip
     * @param int|null $port
     * @param string|null $username
     * @param string|null $password
     * @param bool $https
     */
    public function __construct(string $ip, int $port, ?string $username = "", ?string $password = "", bool $https = false)
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            throw new \InvalidArgumentException('Invalid IPv4 address');
        }

        if ($port < 1000 || $port > 0xffff) {
            throw new \OutOfRangeException('Invalid port');
        }

        $this->ip = $ip;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->https = $https;
    }

    /**
     * @param string $endpoint
     * @param array $params
     * @param array $headers
     * @param string $httpMethod
     * @return array
     * @throws TNC_APIException
     */
    public function request(string $endpoint, array $params = [], array $headers = [], string $httpMethod = "POST"): array
    {
        try {
            $url = $this->generateUri($endpoint);
            $req = new Request($httpMethod, $url);

            // Set Request Headers
            $req->headers()->set("accept", "application/json");

            // Set Dynamic Headers
            if ($headers) {
                foreach ($headers as $key => $value) {
                    $req->headers()->set($key, $value);
                }
            } else {
                $req->headers()->set("content-type", "application/json");
            }

            // Set Request Body/Params
            if ($params) {
                $req->payload()->use($params);
            }

            $request = $req->curl();
            if ($this->username && $this->password) {
                $request->auth()->basic($this->username, $this->password);
            }

            // Send The Request
            $res = $request->send();

            $errCode = $res->code();
            if ($errCode !== 200) {
                $errMsg = $res->body()->value();
                if ($errMsg) {
                    $errMsg = trim(strval(explode("-", $errMsg)[1] ?? ""));
                    throw new TNC_APIException($errMsg ? $errMsg : sprintf('HTTP Response Code %d', $errCode), $errCode);
                }
            }

            return $res->payload()->array();
        } catch (HttpException $e) {
            throw new TNC_APIException(sprintf('[%s][%s] %s', get_class($e), $e->getCode(), $e->getMessage()));
        }
    }

    /**
     * @param string|null $endpoint
     * @return string
     */
    public function generateUri(?string $endpoint = null): string
    {
        $url = sprintf('%s://%s', $this->https ? "https" : "http", $this->ip);
        if ($this->port) {
            $url .= ":" . $this->port;
        }

        if ($endpoint) {
            $url .= "/api/" . ltrim($endpoint, "/");
        }

        return $url;
    }
}
