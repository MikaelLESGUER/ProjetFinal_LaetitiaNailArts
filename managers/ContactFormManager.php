<?php

class ContactFormManager extends AbstractManager
{
    public function createQuote(int $userId, int $prestationId, string $subject, string $email, string $message)
    {
        try {
            // Log the input data for debugging
            error_log("createQuote: userId = $userId, prestationId = $prestationId, subject = $subject, email = $email, message = $message");
            // Créez un objet DateTime pour la date et l'heure actuelles
            $currentDateTime = new DateTime();

            // Formattez la date et l'heure selon le format souhaité (ex : 'Y-m-d H:i:s')
            $timestamp = $currentDateTime->format('Y-m-d H:i:s');

            // Préparez la requête SQL d'insertion
            $query = "INSERT INTO contactform (user_id, prestation_id, subject, email, message, timestamp, status, role) VALUES (:user_id, :prestation_id, :subject, :email, :message, :timestamp, :status, :role)";
            $stmt = $this->db->prepare($query);

            // Liez les valeurs aux paramètres de la requête
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':prestation_id', $prestationId, PDO::PARAM_INT);
            $stmt->bindValue(':subject', $subject, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':message', $message, PDO::PARAM_STR);
            $stmt->bindValue(':timestamp', $timestamp, PDO::PARAM_STR); // Utilisez la valeur formatée de la date/heure
            $stmt->bindValue(':role', 'devis', PDO::PARAM_STR); // Rôle "devis"
            $stmt->bindValue(':status', 'non-lu', PDO::PARAM_STR); // Statut initial "non-lu"

            // Exécutez la requête d'insertion
            $stmt->execute();
            // Log success or any other relevant information
            error_log("createQuote: Quote created successfully");
            return true;
        } catch (PDOException $e) {
            // Log errors and exceptions
            error_log("createQuote: Error - " . $e->getMessage());
            // En cas d'erreur, retournez false ou gérez l'erreur comme souhaité
            return false;
        }
    }

    public function createRenseignement(?int $prestationId, ?int $userId, string $subject, string $email, string $message)
    {
        try {
            // Log the input data for debugging
            error_log("createRenseignement: userId = $userId, prestationId = $prestationId, subject = $subject, email = $email, message = $message");

//            if ($prestationId === -1) {
//                // Indiquez que l'absence de prestation a été sélectionnée
//                $prestationId = null;
//            }
            // Créez un objet DateTime pour la date et l'heure actuelles
            $currentDateTime = new DateTime();

            // Formattez la date et l'heure selon le format souhaité (ex : 'Y-m-d H:i:s')
            $timestamp = $currentDateTime->format('Y-m-d H:i:s');

            // Préparez la requête SQL d'insertion
            $query = "INSERT INTO contactform (prestation_id, user_id, subject, email, message, timestamp, role, status) VALUES (:prestation_id, :user_id, :subject, :email, :message, :timestamp, :role, :status)";
            $stmt = $this->db->prepare($query);

            // Liez les valeurs aux paramètres de la requête
            if ($userId !== null) {
                $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            } else {
                $stmt->bindValue(':user_id', null, PDO::PARAM_NULL);
            }
            if ($prestationId !== null) {
                $stmt->bindValue(':prestation_id', $prestationId, PDO::PARAM_INT);
            } else {
                $stmt->bindValue(':prestation_id', null, PDO::PARAM_NULL);
            }


            // Liez les valeurs aux paramètres de la requête
//            $stmt->bindValue(':prestation_id', $prestationId, PDO::PARAM_INT);
            $stmt->bindValue(':subject', $subject, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':message', $message, PDO::PARAM_STR);
            $stmt->bindValue(':timestamp', $timestamp, PDO::PARAM_STR); // Utilisez la valeur formatée de la date/heure
            $stmt->bindValue(':role', 'renseignement', PDO::PARAM_STR); // Rôle "renseignement"
            $stmt->bindValue(':status', 'non-lu', PDO::PARAM_STR); // Statut initial "non-lu"

            // Exécutez la requête d'insertion
            $stmt->execute();

            // Log success or any other relevant information
            error_log("createRenseignement: Renseignement created successfully");
            return true;
        } catch (PDOException $e) {
            // Log errors and exceptions
            error_log("createRenseignement: Error - " . $e->getMessage());
            // En cas d'erreur, retournez false ou gérez l'erreur comme souhaité
            return false;
        }
    }

    public function countMessagesByRole() {

        $query = "SELECT role, COUNT(*) AS count_messages
              FROM contactform
              WHERE status = 'non-lu'
              GROUP BY role";
//        $query = "SELECT role, COUNT(*) AS count_messages
//                FROM contactform
//                GROUP BY role";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

//    public function getAllContactForms()
//    {
//        // Écrivez la requête SQL pour obtenir tous les formulaires de contact
//        $sql = "SELECT * FROM contactform";
//
//        // Exécutez la requête SQL pour récupérer les formulaires de contact
//        $result = $this->db->query($sql);
//
//        // Vérifiez s'il y a des résultats
//        if ($result) {
//            // Récupérez tous les résultats sous forme de tableau associatif
//            $formulaires = $result->fetchAll(PDO::FETCH_ASSOC);
//
//            // Retournez le tableau de formulaires
//            return $formulaires;
//        } else {
//            // En cas d'erreur ou d'absence de formulaires, retournez un tableau vide ou gérez l'erreur selon vos besoins
//            return [];
//        }
//    }

//    public function getAllContactForms()
//    {
//        $query = "SELECT cf.*, p.name AS prestation_name, u.username AS user_username
//              FROM contactform cf
//              LEFT JOIN prestation p ON cf.prestationId = p.id
//              LEFT JOIN user u ON cf.userId = u.id";
//        $results = $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
//
//        $contactForms = [];
//
//        foreach ($results as $row) {
//            // Convertissez la valeur du timestamp en un objet DateTime
//            $timestamp = new DateTime($row['timestamp']);
//
//            // Créez un objet ContactForm avec toutes les données
//            $contactForm = new ContactForm(
//                $row['messageId'],
//                $row['userId'],
//                $row['prestationId'],
//                $row['subject'],
//                $row['message'],
//                $timestamp,
//                $row['role'],
//                $row['status']
//            );
//
//            // Ajoutez les informations de la prestation et de l'utilisateur
//            $contactForm->setPrestationName($row['prestation_name']);
//            $contactForm->setUserName($row['user_username']);
//
//            // Ajoutez l'objet ContactForm au tableau
//            $contactForms[] = $contactForm;
//        }
//
//        return $contactForms;
//    }

    public function getAllContactForms()
    {
        $query = "SELECT cf.*, u.username AS user_name, p.name AS prestation_name
                    FROM contactform cf
                    LEFT JOIN users u ON cf.user_id = u.id
                    LEFT JOIN prestations p ON cf.prestation_id = p.id";
        $results = $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);

        $contactForms = [];

        foreach ($results as $row) {
            $timestamp = new DateTime($row['timestamp']);
            $contactForm = new ContactForm(
                $row['message_id'],
                $row['user_id'],
                $row['prestation_id'],
                $row['subject'],
                $row['email'],
                $row['message'],
                $timestamp,
                $row['role'],
                $row['status'],
                $row['user_name'],      // Ajoutez le nom d'utilisateur
                $row['prestation_name'] // Ajoutez le nom de prestation
            );

            // Ajoutez les noms d'utilisateur et de prestation à l'objet ContactForm
            $contactForm->setUserName($row['user_name']);
            $contactForm->setPrestationName($row['prestation_name']);

            $contactForms[] = $contactForm;
        }

        return $contactForms;
    }

    public function getContactFormById($messageId)
    {
        $query = "SELECT cf.*, u.username AS user_name, p.name AS prestation_name
              FROM contactform cf
              LEFT JOIN users u ON cf.user_id = u.id
              LEFT JOIN prestations p ON cf.prestation_id = p.id
              WHERE cf.message_id = :message_id";

        $statement = $this->db->prepare($query);
        $statement->bindValue(':message_id', $messageId, PDO::PARAM_INT);
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null; // Le formulaire de contact n'a pas été trouvé
        }

        // Créez un objet ContactForm avec les données récupérées
        $timestamp = new DateTime($result['timestamp']);
        $contactForm = new ContactForm(
            $result['message_id'],
            $result['user_id'],
            $result['prestation_id'],
            $result['subject'],
            $result['email'],
            $result['message'],
            $timestamp,
            $result['role'],
            $result['status'],
            $result['user_name'],      // Ajoutez le nom d'utilisateur
            $result['prestation_name']
        );

        // Définissez le nom d'utilisateur et le nom de la prestation
        $contactForm->setUserName($result['user_name']);
        $contactForm->setPrestationName($result['prestation_name']);

        return $contactForm;
    }

    public function markContactFormAsRead($messageId)
    {
        $query = "UPDATE contactform SET status = 'lu' WHERE message_id = :messageId";

        $statement = $this->db->prepare($query);
        $statement->bindParam(':messageId', $messageId, PDO::PARAM_INT);
        $statement->execute();
    }

    public function deleteContactForm($messageId)
    {
        $query = "DELETE FROM contactform WHERE message_id = :messageId";

        $statement = $this->db->prepare($query);
        $statement->bindParam(':messageId', $messageId, PDO::PARAM_INT);
        $statement->execute();
    }

//    public function getAllContactForms()
//    {
//        $query = "SELECT * FROM contactform";
//        $results = $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
//
//        $contactForms = [];
//
//        foreach ($results as $row) {
//            // Convertissez la valeur du timestamp en un objet DateTime
//            $timestamp = new DateTime($row['timestamp']);
//
//            // Créez un objet ContactForm avec toutes les données
//            $contactForm = new ContactForm(
//                $row['messageId'],
//                $row['userId'],
//                $row['prestationId'],
//                $row['subject'],
//                $row['message'],
//                $timestamp, // Utilisez l'objet DateTime ici
//                $row['role'],
//                $row['status']
//            );
//
//            // Ajoutez l'objet ContactForm au tableau
//            $contactForms[] = $contactForm;
//        }
//
//        return $contactForms;
//    }

//    public function getAllContactForms()
//    {
//        $formulaires = [];
//
//        $query = "SELECT * FROM contactform";
//        $stmt = $this->db->prepare($query);
//        $stmt->execute();
//
//        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//
//            $timestamp = new DateTime($row['timestamp']);
////            var_dump($row);
////            die();
//            $formulaire = new contactForm(null, 0,0, "","",dateTimeOffset,"","");
//            $formulaire->setMessageId($row['messageid']);
//            $formulaire->setUserId($row['userId']);
//            $formulaire->setPrestationId($row['prestationId']);
//            $formulaire->setSubject($row['subject']);
//            $formulaire->setMessageText($row['message']);
//            $timestamp,
//            $formulaire->setDuration($row['duration']);
//            $formulaire->setPrice($row['price']);
//            $formulaires[] = $formulaire;
//        }
//
//        return $formulaires;
//    }

//    public function createQuote($name, $email, $message)
//    {
//        try {
//            $query = "INSERT INTO contact_form (name, email, message, role) VALUES (:name, :email, :message, :role)";
//            $stmt = $this->db->prepare($query);
//            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
//            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
//            $stmt->bindValue(':message', $message, PDO::PARAM_STR);
//            $stmt->bindValue(':role', 'devis', PDO::PARAM_STR);
//            $stmt->execute();
//
//            // Vous pouvez également envoyer un email de confirmation à l'utilisateur ici
//
//            return true;
//        } catch (PDOException $e) {
//            return false;
//        }
//    }

}