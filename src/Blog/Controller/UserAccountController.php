<?php


namespace Blog\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAccountController
{
    public function index(Request $request)
    {
        return new Response('Hello, you handsome.');
    }

}