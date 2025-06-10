<?php

namespace App\Foundation;

use Illuminate\Contracts\Foundation\MaintenanceMode;

class FileMaintenanceMode implements MaintenanceMode
{
    protected bool $isActive = false;
    protected array $data = [];

    public function active(): bool
    {
        return $this->isActive;
    }

    public function data(): array
    {
        return $this->data;
    }

    public function activate(array $payload): void
    {
        $this->isActive = true;
        $this->data = $payload;
    }

    public function deactivate(): void
    {
        $this->isActive = false;
        $this->data = [];
    }
}
