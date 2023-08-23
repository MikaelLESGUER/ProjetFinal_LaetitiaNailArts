<?php

class Comment {
    private ?int $commentId;
    private int $userId;
    private string $commentText;
    private int $rating;
    private string $timestamp;

    public function __construct(?int $commentId, int $userId, string $commentText, int $rating, string $timestamp) {
        $this->commentId = $commentId;
        $this->userId = $userId;
        $this->commentText = $commentText;
        $this->rating = $rating;
        $this->timestamp = $timestamp;
    }

    // Getters
    public function getCommentId(): ?int {
        return $this->commentId;
    }

    public function getUserId(): int {
        return $this->userId;
    }

    public function getCommentText(): string {
        return $this->commentText;
    }

    public function getRating(): int {
        return $this->rating;
    }

    public function getTimestamp(): string {
        return $this->timestamp;
    }

    // Setters
    public function setUserId(int $userId): void {
        $this->userId = $userId;
    }

    public function setCommentText(string $commentText): void {
        $this->commentText = $commentText;
    }

    public function setRating(int $rating): void {
        $this->rating = $rating;
    }

    public function setTimestamp(string $timestamp): void {
        $this->timestamp = $timestamp;
    }
}

