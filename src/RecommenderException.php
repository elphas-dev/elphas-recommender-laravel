<?php

namespace Elphas\Recommender;

use Exception;

class RecommenderException extends Exception
{
    /**
     * @var string
     */
    protected $field;

    /**
     * @var string
     */
    protected $documentationUrl;

    /**
     * @param string          $message
     * @param int             $code
     * @param string|null     $field
     * @param string|null     $documentationUrl
     * @param \Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {


        parent::__construct($message, $code, $previous);


    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getDocumentationUrl()
    {
        return $this->documentationUrl;
    }
}
