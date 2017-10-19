<?php

/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 18.10.17
 * Time: 17:42
 */

namespace KnpU\CodeBattle\Api;

use Symfony\Component\HttpFoundation\Response;

class ApiProblem
{
    const TYPE_VALIDATION_ERROR = 'validation_error';
    const TYPE_INVALID_REQUEST_BODY_FORMAT = 'invalid_body_format';

    private static $titles = [
        self::TYPE_VALIDATION_ERROR => 'There was a validation error',
        self::TYPE_INVALID_REQUEST_BODY_FORMAT => 'Invalid JSON format set',
    ];

    private $statusCode;

    private $type;

    private $title;

    private $extraField = [];

    /**
     * ApiProblem constructor.
     * @param $statusCode
     * @param $type
     * @throws \Exception
     */
    public function __construct($statusCode, $type = null)
    {
        $this->statusCode = $statusCode;
        $this->type = $type;

        if ($type === null) {
            $this->type = 'about:blank';
            $this->title = Response::$statusTexts[$statusCode] ?? 'Unknow status code :(';
        } else {
            if (!isset(self::$titles[$type])) {
                throw new \Exception(sprintf('No title for type "%s"/ Did youmake it up?', $type));
            }

            $this->title = self::$titles[$type];
        }
    }

    public function toArray()
    {
        return array_merge(
            $this->extraField,
            [
                'status' => $this->statusCode,
                'type' => $this->type,
                'title' => $this->title,
            ]
        );
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $name
     * @param $value
     * @internal param array $extraField
     */
    public function set($name, $value)
    {
        $this->extraField[$name] = $value;
    }

    public function getTitle()
    {
        return $this->title;
    }
}