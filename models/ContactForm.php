<?php

class ContactForm {
    private ?int $messageId;
    private ?int $userId;
    private ?int $prestationId;
    private string $subject;
    private string $email;
    private string $messageText;
    private DateTime $timestamp;
    private string $role;
    private string $status;
    private ?string $userName;
    private ?string $prestationName;

    public function __construct(?int $messageId, ?int $userId, ?int $prestationId, string $subject, string$email, string $messageText,DateTime $timestamp,string $role,string $status,?string $userName, ?string $prestationName) {
        $this->messageId = $messageId;
        $this->userId = $userId;
        $this->prestationId = $prestationId;
        $this->subject = $subject;
        $this->email = $email;
        $this->messageText = $messageText;
        $this->timestamp = $timestamp;
        $this->role = $role;
        $this->status = $status;
        $this->userName = $userName;
        $this->prestationName = $prestationName;
    }

    // Getters
    public function getMessageId(): ?int {
        return $this->messageId;
    }

    public function getUserId(): ?int {
        return $this->userId;
    }

    /**
     * @return ?int
     */
    public function getPrestationId(): ?int
    {
        return $this->prestationId;
    }
    public function getSubject(): string {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    public function getMessageText(): string {
        return $this->messageText;
    }

    public function getTimestamp(): DateTime {
        return $this->timestamp;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    // Nouvelles méthodes pour obtenir les noms d'utilisateur et de prestation
    public function getUserName(): ?string {
        return $this->userName;
    }

    public function getPrestationName(): ?string {
        return $this->prestationName;
    }

    // Setters

    /**
     * @param int|null $messageId
     */
    public function setMessageId(?int $messageId): void
    {
        $this->messageId = $messageId;
    }
    public function setUserId(?int $userId): void {
        $this->userId = $userId;
    }

    /**
     * @param int|null $prestationId
     */
    public function setPrestationId(?int $prestationId): void
    {
        $this->prestationId = $prestationId;
    }

    public function setSubject(string $subject): void {
        $this->subject = $subject;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setMessageText(string $messageText): void {
        $this->messageText = $messageText;
    }

    public function setTimestamp(DateTime $timestamp): void {
        $this->timestamp = $timestamp;
    }
    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    // Méthode pour définir le nom de l'utilisateur
    public function setUserName(?string $userName): void {
        $this->userName = $userName;
    }

    // Méthode pour définir le nom de la prestation
    public function setPrestationName(?string $prestationName): void {
        $this->prestationName = $prestationName;
    }
}
