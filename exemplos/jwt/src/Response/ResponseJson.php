<?php

namespace App\Response;
use Symfony\Component\HttpFoundation\Response;

class ResponseJson  extends  Response
{
    /**
     * @var array
     */
    protected $content = [];

    /**
     * Sends content for the current web response.
     *
     * @return $this
     */
    public function sendContent()
    {
        header("Content-type: application/json; ");
        echo json_encode($this->content);
        return $this;
    }

    function json($data, $code) 
    {
        $this->content = $data;
        $this->setStatusCode($code);
        return $this;
    }
}