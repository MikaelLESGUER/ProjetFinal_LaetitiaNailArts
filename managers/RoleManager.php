<?php

class RoleManager extends AbstractManager
{
    public function getRoleNameByUsername($username) {
        $query = "SELECT description FROM roles
                  INNER JOIN admin ON admin.role_id = roles.id
                  WHERE admin.username = :username";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['description'];
        }

        return null; // Si le rôle d'administrateur n'est pas trouvé
    }

    public function getRoleNameById(int $role_id): ?string
    {
        $query = "SELECT description FROM roles WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$role_id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['description'];
        }

        return null;
    }
}