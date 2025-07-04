<?php
namespace Payme\Http\Classes;

class Request
{
    public $request;

    public function __construct()
    {
        $this->request = file_get_contents('php://input');
    }

    public function authorize()
    {
        
    }
}
