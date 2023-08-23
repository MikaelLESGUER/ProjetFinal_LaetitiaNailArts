<?php

class ContactForm {
    private ?int $messageId;
    private int $userId;
    private string $subject;
    private string $messageText;
    private DateTime $timestamp;

    public function __construct(?int $messageId, int $userId, string $subject, string $messageText, DateTime $timestamp) {
        $this->messageId = $messageId;
        $this->userId = $userId;
        $this->subject = $subject;
        $this->messageText = $messageText;
        $this->timestamp = $timestamp;
    }

    // Getters
    public function getMessageId(): ?int {
        return $this->messageId;
    }

    public function getUserId(): int {
        return $this->userId;
    }

    public function getSubject(): string {
        return $this->subject;
    }

    public function getMessageText(): string {
        return $this->messageText;
    }

    public function getTimestamp(): DateTime {
        return $this->timestamp;
    }

    // Setters
    public function setUserId(int $userId): void {
        $this->userId = $userId;
    }

    public function setSubject(string $subject): void {
        $this->subject = $subject;
    }

    public function setMessageText(string $messageText): void {
        $this->messageText = $messageText;
    }

    public function setTimestamp(DateTime $timestamp): void {
        $this->timestamp = $timestamp;
    }
}
