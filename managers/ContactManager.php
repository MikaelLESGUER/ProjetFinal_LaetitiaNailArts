<?php

class ContactManager extends AbstractManager
{

    public function getContactInfo()
    {
        $query = "SELECT * FROM contact";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $contactInfo = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $contact = new Contact(
                $row['id'],
                $row['adresse'],
                $row['code_postal'],
                $row['ville'],
                $row['url_geo'],
                $row['numero_fixe'],
                $row['numero_portable']
            );

            $contactInfo[] = $contact;
        }

        return $contactInfo;
    }

    public function updateAddress($adresse, $codePostal, $ville)
    {
        $query = "UPDATE contact SET adresse = :adresse, code_postal = :codePostal, ville = :ville WHERE id = 1";

        $statement = $this->db->prepare($query);
        $statement->bindParam(':adresse', $adresse, PDO::PARAM_STR);
        $statement->bindParam(':codePostal', $codePostal, PDO::PARAM_STR);
        $statement->bindParam(':ville', $ville, PDO::PARAM_STR);

        return $statement->execute();
    }

    public function updateUrlGeo($urlGeo)
    {
        $query = "UPDATE contact SET url_geo = :urlGeo WHERE id = 1";

        $statement = $this->db->prepare($query);
        $statement->bindParam(':urlGeo', $urlGeo, PDO::PARAM_STR);

        return $statement->execute();
    }

    public function updatePhoneNumbers($numeroFixe, $numeroPortable)
    {
        $query = "UPDATE contact SET numero_fixe = :numeroFixe, numero_portable = :numeroPortable WHERE id = 1";

        $statement = $this->db->prepare($query);
        $statement->bindParam(':numeroFixe', $numeroFixe, PDO::PARAM_STR);
        $statement->bindParam(':numeroPortable', $numeroPortable, PDO::PARAM_STR);

        return $statement->execute();
    }

}