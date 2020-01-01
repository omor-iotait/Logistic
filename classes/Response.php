<?php


class Response
{
    public $status_code;
    public $message;
    public $data;

    public function create($status_code, $message, $data){
        $this->status_code = $status_code;
        $this->message = $message;
        $this->data = $data;
    }

    public function response_print(){
        header('Content-Type: application/json');
        return json_encode($this, JSON_UNESCAPED_SLASHES);
    }
}