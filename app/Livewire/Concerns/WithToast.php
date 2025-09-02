<?php

namespace App\Livewire\Concerns;

trait WithToast
{
    /**
     * Emit a success toast notification
     */
    protected function toastSuccess(string $title, string $message = '', array $options = []): void
    {
        $this->dispatch('toast', array_merge([
            'type' => 'success',
            'title' => $title,
            'message' => $message,
            'duration' => 5000,
        ], $options));
    }

    /**
     * Emit an error toast notification
     */
    protected function toastError(string $title, string $message = '', array $options = []): void
    {
        $this->dispatch('toast', array_merge([
            'type' => 'error',
            'title' => $title,
            'message' => $message,
            'duration' => 7000, // Errors ficam mais tempo
        ], $options));
    }

    /**
     * Emit a warning toast notification
     */
    protected function toastWarning(string $title, string $message = '', array $options = []): void
    {
        $this->dispatch('toast', array_merge([
            'type' => 'warning',
            'title' => $title,
            'message' => $message,
            'duration' => 6000,
        ], $options));
    }

    /**
     * Emit an info toast notification
     */
    protected function toastInfo(string $title, string $message = '', array $options = []): void
    {
        $this->dispatch('toast', array_merge([
            'type' => 'info',
            'title' => $title,
            'message' => $message,
            'duration' => 5000,
        ], $options));
    }

    /**
     * Emit a toast based on operation result
     */
    protected function toastResult(bool $success, string $successTitle, string $errorTitle, string $successMessage = '', string $errorMessage = ''): void
    {
        if ($success) {
            $this->toastSuccess($successTitle, $successMessage);
        } else {
            $this->toastError($errorTitle, $errorMessage);
        }
    }

    /**
     * Toast for CRUD operations
     */
    protected function toastCreated(string $item = 'Item'): void
    {
        $this->toastSuccess(
            "{$item} criado com sucesso!",
            "O {$item} foi adicionado ao sistema."
        );
    }

    protected function toastUpdated(string $item = 'Item'): void
    {
        $this->toastSuccess(
            "{$item} atualizado com sucesso!",
            "As alterações foram salvas."
        );
    }

    protected function toastDeleted(string $item = 'Item'): void
    {
        $this->toastSuccess(
            "{$item} removido com sucesso!",
            "O {$item} foi excluído do sistema."
        );
    }

    protected function toastRestored(string $item = 'Item'): void
    {
        $this->toastSuccess(
            "{$item} restaurado com sucesso!",
            "O {$item} foi reativado no sistema."
        );
    }

    /**
     * Toast for ISP specific operations
     */
    protected function toastClientCreated(): void
    {
        $this->toastCreated('Cliente');
    }

    protected function toastClientUpdated(): void
    {
        $this->toastUpdated('Cliente');
    }

    protected function toastSubscriptionActivated(): void
    {
        $this->toastSuccess(
            'Subscrição ativada!',
            'O cliente já pode utilizar os serviços de internet.'
        );
    }

    protected function toastSubscriptionSuspended(): void
    {
        $this->toastWarning(
            'Subscrição suspensa!',
            'O acesso à internet foi temporariamente bloqueado.'
        );
    }

    protected function toastInvoiceGenerated(): void
    {
        $this->toastSuccess(
            'Fatura gerada com sucesso!',
            'A fatura foi criada e está pronta para envio.'
        );
    }

    protected function toastPaymentReceived(): void
    {
        $this->toastSuccess(
            'Pagamento recebido!',
            'O pagamento foi registrado no sistema.'
        );
    }

    protected function toastTicketResolved(): void
    {
        $this->toastSuccess(
            'Ticket resolvido!',
            'O problema foi solucionado com sucesso.'
        );
    }

    protected function toastServiceOrderCompleted(): void
    {
        $this->toastSuccess(
            'Ordem de serviço concluída!',
            'O serviço técnico foi finalizado.'
        );
    }

    /**
     * Toast for validation errors
     */
    protected function toastValidationError(string $message = ''): void
    {
        $this->toastError(
            'Erro de validação!',
            $message ?: 'Por favor, verifique os dados informados.'
        );
    }

    /**
     * Toast for network/connection errors
     */
    protected function toastNetworkError(): void
    {
        $this->toastError(
            'Erro de conexão!',
            'Verifique sua conexão com a internet e tente novamente.'
        );
    }

    /**
     * Toast for permission errors
     */
    protected function toastUnauthorized(): void
    {
        $this->toastError(
            'Acesso negado!',
            'Você não tem permissão para realizar esta ação.'
        );
    }

    /**
     * Toast for maintenance mode
     */
    protected function toastMaintenance(): void
    {
        $this->toastWarning(
            'Sistema em manutenção!',
            'Esta funcionalidade estará disponível em breve.'
        );
    }
}