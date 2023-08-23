<?php

class Role {
    private int $roleId;
    private string $roleName;

    public function __construct(int $roleId, string $roleName) {
        $this->roleId = $roleId;
        $this->roleName = $roleName;
    }

    // Getters
    public function getRoleId(): int {
        return $this->roleId;
    }

    public function getRoleName(): string {
        return $this->roleName;
    }

    // Setters
    public function setRoleId(int $roleId): void {
        $this->roleId = $roleId;
    }

    public function setRoleName(string $roleName): void {
        $this->roleName = $roleName;
    }
}
