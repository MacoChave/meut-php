<?php

namespace DTO;

class UserDTO
{
    public int $user_id;
    public string $first_name;
    public string $last_name;
    public string $genre;
    public string $register_id;
    public string $uid;
    public string $address;
    public string $birth_date;
    public string $phone;
    public string $email;
    public string $password;
    public int $municipality_id;
    public string $status;
    public string $created_at;
    public string $updated_at;
    public string $deleted_at;

    public function __construct(
        string $first_name,
        string $last_name,
        string $genre,
        string $register_id,
        string $uid,
        string $address,
        string $birth_date,
        string $phone,
        string $email,
        string $password,
        int $municipality_id
    ) {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->genre = $genre;
        $this->register_id = $register_id;
        $this->uid = $uid;
        $this->address = $address;
        $this->birth_date = $birth_date;
        $this->phone = $phone;
        $this->email = $email;
        $this->password = $password;
        $this->municipality_id = $municipality_id;
    }
}
