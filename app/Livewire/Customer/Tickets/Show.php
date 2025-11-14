<?php

namespace App\Livewire\Customer\Tickets;

use App\Models\Ticket;
use App\Models\TicketResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;


#[Layout('livewire.layouts.customer-portal')]
#[Title('Detalhes do Ticket')]

class Show extends Component
{

    use WithFileUploads;
    public Ticket $ticket;
    public string $response = '';
    public $attachments = [];

    public function mount($id)
    {
        $customer = Auth::guard('customer')->user();
        $this->ticket = Ticket::with(['customer', 'subscription.plan', 'assignedTo', 'responses.user'])
            ->where('customer_id', $customer->id)
            ->findOrFail($id);

        // Atualiza último acesso
        $this->ticket->touch(); // opcional: atualiza updated_at
    }

    #[Computed]
    public function responses()
    {
        return $this->ticket->publicResponses()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function sendResponse()
    {
        if (!$this->canRespond()) {
            return;
        }

        $this->validate([
            'response' => 'required|string|min:3',
            'attachments.*' => 'nullable|file|mimes:jpg,png,pdf,doc,docx,txt|max:10240', // 10MB
        ]);

        $attachments = [];
        if ($this->attachments) {
            foreach ($this->attachments as $file) {
                $path = $file->store('ticket-attachments', 'public');
                $attachments[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                ];
            }
        }

        TicketResponse::create([
            'ticket_id' => $this->ticket->id,
            'user_id' => $this->ticket->customer_id, // cliente é "user" aqui
            'response' => $this->response,
            'is_internal' => false,
            'is_solution' => false,
            'attachments' => !empty($attachments) ? $attachments : null,
        ]);

        // Atualiza status se estava "waiting_customer"
        if ($this->ticket->status === 'waiting_customer') {
            $this->ticket->update(['status' => 'in_progress']);
            $this->ticket->refresh();
        }

        $this->response = '';
        $this->attachments = [];
        $this->dispatch('response-sent');
    }

    public function reopenTicket()
    {
        if (!$this->canReopen()) {
            return;
        }

        $this->ticket->reopen();
        $this->dispatch('ticket-reopened');
    }
#[Computed]
    public function canRespond(): bool
    {
        return $this->ticket->isOpen() || $this->ticket->status === 'waiting_customer';
    }
#[Computed]
    public function canReopen(): bool
    {
        return in_array($this->ticket->status, ['resolved', 'closed']);
    }

    public function downloadAttachment($responseIndex, $fileIndex)
    {
        $response = $this->responses[$responseIndex];
        $file = $response->attachments[$fileIndex];

        return redirect()->to(storage_path('app/public/' . $file['path']));
    }
    public function render()
    {
        return view('livewire.customer.tickets.show',[[
        'canRespond' => $this->canRespond,
        'canReopen'  => $this->canReopen,
    ]]);
    }
}
