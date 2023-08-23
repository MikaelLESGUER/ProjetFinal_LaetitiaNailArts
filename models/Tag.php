<?php

class Tag {
    private int $tagId;
    private string $tagName;

    public function __construct(int $tagId, string $tagName) {
        $this->tagId = $tagId;
        $this->tagName = $tagName;
    }

    // Getters
    public function getTagId(): int {
        return $this->tagId;
    }

    public function getTagName(): string {
        return $this->tagName;
    }

    // Setters
    public function setTagId(int $tagId): void {
        $this->tagId = $tagId;
    }

    public function setTagName(string $tagName): void {
        $this->tagName = $tagName;
    }
}
