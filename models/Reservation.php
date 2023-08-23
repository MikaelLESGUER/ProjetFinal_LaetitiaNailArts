<?php

class Reservation {
    private ?int $reservationId;
    private int $userId;
    private int $prestationId;
    private string $reservationDate;
    private string $reservationTime;
    private string $status;

    public function __construct(
        ?int $reservationId,
        int $userId,
        int $prestationId,
        string $reservationDate,
        string $reservationTime,
        string $status
    ) {
        $this->reservationId = $reservationId;
        $this->userId = $userId;
        $this->prestationId = $prestationId;
        $this->reservationDate = $reservationDate;
        $this->reservationTime = $reservationTime;
        $this->status = $status;
    }

    // Getters
    public function getReservationId(): ?int {
        return $this->reservationId;
    }

    public function getUserId(): int {
        return $this->userId;
    }

    public function getPrestationId(): int {
        return $this->prestationId;
    }

    public function getReservationDate(): string {
        return $this->reservationDate;
    }

    public function getReservationTime(): string {
        return $this->reservationTime;
    }

    public function getStatus(): string {
        return $this->status;
    }

    // Setters
    public function setReservationId(?int $reservationId): void {
        $this->reservationId = $reservationId;
    }

    public function setUserId(int $userId): void {
        $this->userId = $userId;
    }

    public function setPrestationId(int $prestationId): void {
        $this->prestationId = $prestationId;
    }

    public function setReservationDate(string $reservationDate): void {
        $this->reservationDate = $reservationDate;
    }

    public function setReservationTime(string $reservationTime): void {
        $this->reservationTime = $reservationTime;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }
}
