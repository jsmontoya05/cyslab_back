<?php 

declare(strict_types=1);

namespace Tests\Fakers;

class UserFake {
    public String $name;
    public String $email;
    public String $image;
    public String $provider_id;
    public String $provider;
    public String $response_oauth;
    public String $response_get;

    public function __construct(){
        $this->name             = 'UsuarioFaker';
        $this->email            = 'UsuarioFaker@faker.com';
        $this->image            = 'image.jpg';
        $this->provider_id      = 'a9db6107-97y8a-44cc-a5fd-f796727b11243';
        $this->provider         = 'azure';
        $this->response_oauth   = '{}';
        $this->response_get     = '{}';
    }

}