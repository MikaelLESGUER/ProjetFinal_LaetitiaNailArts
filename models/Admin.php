<?php

class Admin
{
    private  ?int $id;

    private  ?int $role_id;

    private string $username;

    private string $password;

    public function __construct(?int $id, ?int $role_id, string $username, string $password)
    {
        $this->id = $id;
        $this->role_id = $role_id;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getRoleId(): ?int
    {
        return $this->role_id;
    }

    /**
     * @param int|null $role_id
     */
    public function setRoleId(?int $role_id): void
    {
        $this->role_id = $role_id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}