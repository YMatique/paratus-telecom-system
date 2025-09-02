<?php

namespace App\Livewire\Concerns;

trait WithToast
{
 protected function toastSuccess(string $title, string $message = ''): void
    {
        $this->dispatch('toast', [
            'type' => 'success',
            'title' => $title,
            'message' => $message,
        ]);
    }

    protected function toastError(string $title, string $message = ''): void
    {
        $this->dispatch('toast', [
            'type' => 'error',
            'title' => $title,
            'message' => $message,
        ]);
    }

    protected function toastWarning(string $title, string $message = ''): void
    {
        $this->dispatch('toast', [
            'type' => 'warning',
            'title' => $title,
            'message' => $message,
        ]);
    }

    protected function toastInfo(string $title, string $message = ''): void
    {
        $this->dispatch('toast', [
            'type' => 'info',
            'title' => $title,
            'message' => $message,
        ]);
    }
}