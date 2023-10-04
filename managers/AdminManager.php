<?php

class AdminManager extends AbstractManager
{
    public function getAdminByUsername(string $username): ?Admin
    {
        echo ('je suis lu');
        $query = "select * from admin where username = :username";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new Admin(
            $row['id'],
            $row['role_id'],
            $row['username'],
            $row['password'],
        );

    }

    public function createAdmin (Admin $admin, int $role_id) :Admin
    {
        $query = "INSERT INTO admin (username, password, role_id) VALUES (?,?,?)";
        $values = [$admin->getUsername(), $admin->getPassword(), $role_id];

        $stmt = $this->db->prepare($query);
        $success = $stmt->execute($values);

        if ($success)
        {;
            return $admin;
        } else {
            return null;
        }
    }

    public function getAdminById($adminId)
    {
        $query = "SELECT * FROM admin WHERE id = :adminId";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':adminId', $adminId, PDO::PARAM_INT);
        $stmt->execute();

        // Récupérez les données de l'administrateur sous forme d'objet Admin
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

            // Créez une instance de la classe Admin et remplissez-la avec les données de la base de données
            $admin = new Admin(
                $row['id'],
                $row['role_id'],
                $row['username'],
                $row['password'],
            );

            // Vous pouvez ajouter d'autres propriétés si nécessaire
            return $admin;
    }

    public function getAllAdmins() : array
    {
        $admins = [];

        $query = "select * from admin";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $admin = new Admin(null,null,"","");
            $admin->setId($row['id']);
            $admin->setRoleId($row['role_id']);
            $admin->setUsername($row['username']);
            $admin->setPassword($row['password']);
            $admins[] = $admin;
        }
        return $admins;
    }

    public function modifyAdmin($adminId, $newUsername, $newPassword)
    {
        $query = "UPDATE admin SET username = :username, password = :password WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':username', $newUsername);
        $stmt->bindValue(':password', $newPassword);
        $stmt->bindValue(':id', $adminId);

        $success = $stmt->execute();

        return $success;
    }

    // Supprimer un administrateur par son ID
    public function deleteAdmin(int $id): bool
    {
        $query = "DELETE FROM admin WHERE id = :admin_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':admin_id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}