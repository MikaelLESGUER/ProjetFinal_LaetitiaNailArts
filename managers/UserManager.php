<?php  
 
class UserManager extends AbstractManager
{

    public function getUserByEmail(string $email): ?User
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new User(
            $row['id'],
            $row['username'],
            $row['prenom'],
            $row['nom'],
            $row['email'],
            $row['password'],
            $row['role_id']
        );
    }

    public function createUser(User $user, int $role_id): ?User
    {
        $query = "INSERT INTO users (username, email, password, role_id) VALUES (?, ?, ?, ?)";
        $values = [$user->getUsername(), $user->getEmail(), $user->getPassword(), $role_id];
//        var_dump($values);
//        die();

        $stmt = $this->db->prepare($query);
        $success = $stmt->execute($values);

        if ($success) {
            $user->setId($this->db->lastInsertId());
            return $user; // Retourne l'objet User nouvellement créé
        } else {
            return null; // Ou une gestion d'erreur appropriée
        }
    }

    public function getUserByUsername(string $username): ?User
    {
        echo ('je suis lu');
        // Écrivez ici le code SQL pour récupérer l'utilisateur en fonction du nom d'utilisateur
        $query = "SELECT id, role_id, username, email, password FROM users WHERE username = :username";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);


        if (!$row) {
            return null;
        }

        // Créez et retournez un objet User à partir des données de la base de données
        return new User(
            $row['id'],
            $row['username'],
            $row['prenom'],
            $row['nom'],
            $row['email'],
            $row['password'],
            $row['role_id']
        );
    }

    public function getUserById(int $id): ?User
    {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new User(
            $row['id'],
            $row['username'],
            $row['prenom'],
            $row['nom'],
            $row['email'],
            $row['password'],
            $row['role_id']
        );
    }

    public function updateUserUsername(int $id, string $newUsername): bool
    {
        // Vérifier que l'utilisateur existe
        $user = $this->getUserById($id);

        if ($user) {
            // Mettre à jour le nom d'utilisateur dans la base de données
            $query = "UPDATE users SET username = :new_username WHERE id = :user_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':new_username', $newUsername, PDO::PARAM_STR);
            $stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        }

        return false; // L'utilisateur n'existe pas
    }

    public function updateUserEmail(int $id, string $newEmail): bool
    {
        echo('je fonctionne');
        // Vérifier que l'utilisateur existe
        $user = $this->getUserById($id);

        if ($user) {
            // Mettre à jour l'e-mail dans la base de données
            $query = "UPDATE users SET email = :new_email WHERE id = :user_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':new_email', $newEmail, PDO::PARAM_STR);
            $stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        }

        return false; // L'utilisateur n'existe pas
    }

    public function updateUserPassword(int $id, string $newPassword): bool
    {
        // Vérifier que l'utilisateur existe
        $user = $this->getUserById($id);

        if ($user) {
            // Chiffrer le nouveau mot de passe
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Mettre à jour le mot de passe dans la base de données
            $query = "UPDATE users SET password = :new_password WHERE id = :user_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':new_password', $hashedPassword, PDO::PARAM_STR);
            $stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        }

        return false; // L'utilisateur n'existe pas
    }

    public function getAllUsers() : array
    {
        $users = [];

        $query = "select * from users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $user = new User(null,"","","","","",0);
            $user->setId($row['id']);
            $user->setUsername($row['username']);
            $user->setNom($row['nom']);
            $user->setPrenom($row['prenom']);
            $user->setEmail($row['email']);
            $user->setRoleId($row['role_id']);
            $users[] = $user;

//            var_dump($user);
//            die();
        }
        return $users;
    }

    public function updateNameAndLastName($userId, $newName, $newLastName)
    {
        // Préparez la requête SQL pour mettre à jour le nom et le prénom de l'utilisateur
        $query = "UPDATE users SET nom = :new_name, prenom = :new_lastname WHERE id = :user_id";

        // Préparez la requête avec PDO
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':new_name', $newName, PDO::PARAM_STR);
        $stmt->bindValue(':new_lastname', $newLastName, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);

        // Exécutez la requête
        $result = $stmt->execute();

        // Vérifiez si la mise à jour a réussi
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

//    public function getUserByUsername(string $username): ?User
//    {
//        $query = "SELECT * FROM users WHERE username = :username";
//        $stmt = $this->db->prepare($query);
//        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
//        $stmt->execute();
//
//        $row = $stmt->fetch(PDO::FETCH_ASSOC);
//
//        if (!$row) {
//            return null;
//        }
//
//        return new User(
//            $row['id'],
//            $row['role_id'],
//            $row['username'],
//            $row['email'],
//            $row['password']
//        );
//    }

    // Supprimer un utilisateur par son ID
    public function deleteUser(int $id): bool
    {
        $query = "DELETE FROM users WHERE id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':user_id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

}