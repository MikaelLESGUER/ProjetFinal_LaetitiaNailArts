<?php

class PortfolioTag {
    private int $portfolioId;
    private int $tagId;

    public function __construct(int $portfolioId, int $tagId) {
        $this->portfolioId = $portfolioId;
        $this->tagId = $tagId;
    }

    // Getters
    public function getPortfolioId(): int {
        return $this->portfolioId;
    }

    public function getTagId(): int {
        return $this->tagId;
    }

    // Setters
    public function setPortfolioId(int $portfolioId): void {
        $this->portfolioId = $portfolioId;
    }

    public function setTagId(int $tagId): void {
        $this->tagId = $tagId;
    }
}

