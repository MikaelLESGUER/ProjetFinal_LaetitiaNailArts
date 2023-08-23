<?php

class Portfolio {
    private ?int $portfolioId;
    private int $userId;
    private string $title;
    private string $description;
    private string $imageUrl;

    public function __construct(?int $portfolioId, int $userId, string $title, string $description, string $imageUrl) {
        $this->portfolioId = $portfolioId;
        $this->userId = $userId;
        $this->title = $title;
        $this->description = $description;
        $this->imageUrl = $imageUrl;
    }

    // Getters
    public function getPortfolioId(): ?int {
        return $this->portfolioId;
    }

    public function getUserId(): int {
        return $this->userId;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getImageUrl(): string {
        return $this->imageUrl;
    }

    // Setters
    public function setUserId(int $userId): void {
        $this->userId = $userId;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function setImageUrl(string $imageUrl): void {
        $this->imageUrl = $imageUrl;
    }
}
