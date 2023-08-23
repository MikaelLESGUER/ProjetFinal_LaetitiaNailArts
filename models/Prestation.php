<?php

class Prestation {
    private int $prestationId;
    private int $nameCategory;
    private string $serviceName;
    private string $description;
    private int $duration;
    private float $price;

    public function __construct(
        int $prestationId,
        int $nameCategory,
        string $serviceName,
        string $description,
        int $duration,
        float $price
    ) {
        $this->prestationId = $prestationId;
        $this->nameCategory = $nameCategory;
        $this->serviceName = $serviceName;
        $this->description = $description;
        $this->duration = $duration;
        $this->price = $price;
    }

    // Getters
    public function getPrestationId(): int {
        return $this->prestationId;
    }

    public function getNameCategory(): int {
        return $this->nameCategory;
    }

    public function getServiceName(): string {
        return $this->serviceName;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getDuration(): int {
        return $this->duration;
    }

    public function getPrice(): float {
        return $this->price;
    }

    // Setters
    public function setPrestationId(int $prestationId): void {
        $this->prestationId = $prestationId;
    }

    public function setNameCategory(int $nameCategory): void {
        $this->nameCategory = $nameCategory;
    }

    public function setServiceName(string $serviceName): void {
        $this->serviceName = $serviceName;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function setDuration(int $duration): void {
        $this->duration = $duration;
    }

    public function setPrice(float $price): void {
        $this->price = $price;
    }
}
