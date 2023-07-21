<?php

namespace Hexa\Users\Domain;

final class User
{
    private $id;
    private $firstname;
    private $lastname;
    private $email;
    private $password;
    private $admin;
    private $image;
    private $active;
    private $auth_provider;

    public function __construct(
        int    $id,
        string $firstname,
        string $lastname,
        string $email,
        ?string $password = null,
        string $image = null,
        $admin = null,
        $active = null,
        string $auth_provider = null,
        string $domain = null
    ) {

        $this->id        = $id;
        $this->firstname = $this->setFirstname($firstname);
        $this->lastname  = $lastname;
        $this->email     = $email;
        $this->password  = $password;
        $this->image     = $image;
        $this->admin     = $admin;
        $this->active    = $active;
        $this->auth_provider = $auth_provider;  
        $this->domain = $domain;  
    }

    public static function create(
        $firstname,
        $lastname,
        $email,
        $password
    ): self {

        return new self(
            $null = 0001,
            $firstname,
            $lastname,
            $email,
            $password
        );
    }


    public static function update(
        int    $id,
        string $firstname,
        string $lastname,
        string $email
    ): self {

        return new self(
            $id,
            $firstname,
            $lastname,
            $email,
            $password = 'DO_NOT_UPDATE_HERE',
            $image = 'DO_NOT_UPDATE_HERE'
        );
    }

    public static function updateActive(
        int $id,
        $active
    ): self {

        return new self(
            $id,
            $firstname  = 'DO_NOT_UPDATE_HERE',
            $lastname  = 'DO_NOT_UPDATE_HERE',
            $email  = 'DO_NOT_UPDATE_HERE',
            $password = 'DO_NOT_UPDATE_HERE',
            $image = 'DO_NOT_UPDATE_HERE',
            $admin = 'DO_NOT_UPDATE_HERE',
            $active
        );
    }

    public static function createAuthProvider(
        $firstname,
        $lastname,
        $email,
        $auth_provider
    ): self {

        return new self(
            $null = 0001,
            $firstname,
            $lastname,
            $email,
            null,
            null,
            null,
            1,
            $auth_provider
        );
    }
    public function updatePassword($newPassword): void
    {
        $this->password = $newPassword;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function firstname(): string
    {
        return $this->firstname;
    }

    public function lastname(): string
    {
        return $this->lastname;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): ?string
    {
        return $this->password;
    }

    public function image(): string
    {
        return $this->image;
    }

     public function admin()
    {
        return $this->admin;
    }

    public function active()
    {
        return $this->active;
    }

    public function auth_provider()
    {
        return $this->auth_provider;
    }
    
    public function domain()
    {
        return $this->domain;
    }
    
    public function updateImage($newImage): void
    {
        $this->image = $newImage;
    }

    public function setFirstname(string $firstname): string
    {
        return ucfirst($firstname);
    }

    public function setPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
