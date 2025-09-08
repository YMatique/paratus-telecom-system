<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Subscription;
use App\Models\Ticket;
use App\Models\TicketResponse;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🎫 Criando tickets de exemplo...');

        // Buscar dados necessários
        $customers = Customer::all();
        $subscriptions = Subscription::all();
        $users = User::all();

        if ($customers->isEmpty()) {
            $this->command->error('❌ Nenhum cliente encontrado. Execute o CustomerSeeder primeiro.');
            return;
        }

        if ($users->isEmpty()) {
            $this->command->warn('⚠️  Nenhum usuário encontrado. Criando tickets sem atribuição.');
        }

        // Tickets de exemplo com cenários reais de ISP
        $ticketTemplates = [
            // Tickets Técnicos Urgentes
            [
                'subject' => 'Internet completamente fora do ar - Empresa',
                'description' => 'Cliente relata que a internet está completamente fora do ar desde às 08:00. Empresa depende da conexão para funcionamento. Já reiniciaram o modem e roteador conforme orientação.',
                'priority' => 'urgent',
                'category' => 'technical',
                'status' => 'in_progress',
                'needs_subscription' => true,
                'responses' => [
                    [
                        'response' => 'Verificamos na central e identificamos problema na fibra óptica do setor. Técnico a caminho.',
                        'is_internal' => false,
                        'created_hours_ago' => 2
                    ],
                    [
                        'response' => 'Problema no splice da caixa de emenda. Estimativa 1h para reparo.',
                        'is_internal' => true,
                        'created_hours_ago' => 1
                    ]
                ]
            ],
            [
                'subject' => 'Velocidade muito abaixo do contratado',
                'description' => 'Cliente contratou 100MB mas está recebendo apenas 15-20MB. Problema persiste há 3 dias. Testaram em diferentes dispositivos e o problema continua.',
                'priority' => 'high',
                'category' => 'technical',
                'status' => 'open',
                'needs_subscription' => true,
                'responses' => []
            ],
            [
                'subject' => 'Instabilidade na conexão - Disconnects frequentes',
                'description' => 'Cliente relata que a internet fica caindo a cada 15-30 minutos. Tem que reiniciar o modem para voltar. Problema começou depois da chuva de ontem.',
                'priority' => 'high',
                'category' => 'technical',
                'status' => 'waiting_customer',
                'needs_subscription' => true,
                'responses' => [
                    [
                        'response' => 'Detectamos oscilação no sinal. Solicitamos que cliente verifique se há água acumulada na caixa externa e nos informe.',
                        'is_internal' => false,
                        'created_hours_ago' => 4
                    ]
                ]
            ],

            // Tickets de Instalação
            [
                'subject' => 'Agendamento de instalação - Nova contratação',
                'description' => 'Cliente contratou plano Fibra 50MB. Endereço: Av. Eduardo Mondlane, 1234, Bairro Central. Cliente disponível de segunda a sexta das 14h às 18h.',
                'priority' => 'medium',
                'category' => 'installation',
                'status' => 'open',
                'needs_subscription' => true,
                'responses' => []
            ],
            [
                'subject' => 'Reagendamento de instalação',
                'description' => 'Cliente não estava presente no horário agendado (14h). Solicita reagendamento para sábado pela manhã. Tem porteiro que pode receber o técnico.',
                'priority' => 'medium',
                'category' => 'installation',
                'status' => 'open',
                'needs_subscription' => true,
                'responses' => [
                    [
                        'response' => 'Reagendado para sábado às 9h. Técnico: João Silva. Cliente confirmou presença.',
                        'is_internal' => false,
                        'created_hours_ago' => 24
                    ]
                ]
            ],

            // Tickets de Faturamento
            [
                'subject' => 'Cobrança duplicada na fatura de setembro',
                'description' => 'Cliente recebeu duas faturas para o mesmo período (setembro/2024). Uma no valor de MT 1.800,00 e outra de MT 1.200,00. Solicita esclarecimento e correção.',
                'priority' => 'medium',
                'category' => 'billing',
                'status' => 'resolved',
                'needs_subscription' => true,
                'responses' => [
                    [
                        'response' => 'Verificamos e identificamos erro no sistema. A fatura correta é de MT 1.200,00. Cancelamos a cobrança duplicada.',
                        'is_internal' => false,
                        'is_solution' => true,
                        'created_hours_ago' => 12
                    ]
                ]
            ],
            [
                'subject' => 'Solicitação de 2ª via de fatura',
                'description' => 'Cliente perdeu a fatura de outubro e precisa da 2ª via para realizar o pagamento. Email: cliente@email.com',
                'priority' => 'low',
                'category' => 'billing',
                'status' => 'resolved',
                'needs_subscription' => true,
                'responses' => [
                    [
                        'response' => '2ª via enviada para o email cadastrado. Vencimento: 15/10/2024.',
                        'is_internal' => false,
                        'is_solution' => true,
                        'created_hours_ago' => 6
                    ]
                ]
            ],

            // Tickets de Reclamação
            [
                'subject' => 'Demora excessiva no atendimento técnico',
                'description' => 'Cliente relata que está há 2 dias sem internet e o técnico ainda não compareceu. Já ligou 3 vezes e sempre prometem enviar técnico mas ninguém aparece. Cliente muito insatisfeito.',
                'priority' => 'urgent',
                'category' => 'complaint',
                'status' => 'in_progress',
                'needs_subscription' => true,
                'responses' => [
                    [
                        'response' => 'Entendemos a frustração. Técnico será enviado hoje às 14h. Supervisor acompanhará pessoalmente.',
                        'is_internal' => false,
                        'created_hours_ago' => 3
                    ],
                    [
                        'response' => 'Escalar para supervisão. Cliente VIP. Prioridade máxima.',
                        'is_internal' => true,
                        'created_hours_ago' => 4
                    ]
                ]
            ],
            [
                'subject' => 'Insatisfação com qualidade do atendimento',
                'description' => 'Cliente reclama que atendente foi grosseiro durante ligação e não resolveu o problema. Quer falar com supervisor. Ticket original: TK-2024-005',
                'priority' => 'high',
                'category' => 'complaint',
                'status' => 'open',
                'needs_subscription' => false,
                'responses' => []
            ],

            // Tickets de Solicitação
            [
                'subject' => 'Upgrade de plano - 50MB para 100MB',
                'description' => 'Cliente solicita upgrade do plano atual (50MB) para 100MB. Quer saber sobre diferença de valor e quando pode ser feita a mudança.',
                'priority' => 'medium',
                'category' => 'request',
                'status' => 'resolved',
                'needs_subscription' => true,
                'responses' => [
                    [
                        'response' => 'Upgrade disponível. Diferença: MT 600,00/mês. Pode ser feito imediatamente. Confirme para processarmos.',
                        'is_internal' => false,
                        'created_hours_ago' => 8
                    ],
                    [
                        'response' => 'Cliente confirmou. Upgrade agendado para amanhã.',
                        'is_internal' => false,
                        'is_solution' => true,
                        'created_hours_ago' => 6
                    ]
                ]
            ],
            [
                'subject' => 'Mudança de endereço de instalação',
                'description' => 'Cliente se mudou e quer transferir a conexão para novo endereço. Endereço atual: Rua A, 123. Novo endereço: Av. B, 456. Distância aproximada: 2km.',
                'priority' => 'medium',
                'category' => 'request',
                'status' => 'open',
                'needs_subscription' => true,
                'responses' => [
                    [
                        'response' => 'Verificaremos disponibilidade de fibra no novo endereço e entraremos em contato em 24h.',
                        'is_internal' => false,
                        'created_hours_ago' => 18
                    ]
                ]
            ],

            // Tickets diversos
            [
                'subject' => 'Equipamento com defeito - LED vermelho piscando',
                'description' => 'Modem apresenta LED vermelho piscando continuamente. Cliente seguiu orientações de reinicialização mas problema persiste. Equipamento: TP-Link TD-W8961N',
                'priority' => 'medium',
                'category' => 'technical',
                'status' => 'open',
                'needs_subscription' => true,
                'responses' => []
            ],
            [
                'subject' => 'Cancelamento de serviço',
                'description' => 'Cliente solicita cancelamento definitivo do serviço. Motivo: mudança para outro país. Data desejada para desconexão: 30/11/2024.',
                'priority' => 'low',
                'category' => 'request',
                'status' => 'open',
                'needs_subscription' => true,
                'responses' => []
            ]
        ];

        $createdTickets = [];
        $responseUser = $users->first();

        foreach ($ticketTemplates as $index => $template) {
            // Selecionar cliente aleatório
            $customer = $customers->random();

            // Selecionar subscrição se necessário
            $subscription = null;
            if ($template['needs_subscription']) {
                $customerSubscriptions = $subscriptions->where('customer_id', $customer->id);
                if ($customerSubscriptions->isNotEmpty()) {
                    $subscription = $customerSubscriptions->random();
                }
            }

            // Determinar atribuição
            $assignedTo = null;
            if ($template['status'] !== 'open' && $users->isNotEmpty()) {
                $assignedTo = $users->random()->id;
            }

            // Calcular datas baseadas no status
            $openedAt = now()->subHours(rand(1, 72));
            $resolvedAt = null;
            $closedAt = null;

            if ($template['status'] === 'resolved') {
                $resolvedAt = $openedAt->copy()->addHours(rand(1, 24));
            } elseif ($template['status'] === 'closed') {
                $resolvedAt = $openedAt->copy()->addHours(rand(1, 20));
                $closedAt = $resolvedAt->copy()->addHours(rand(1, 4));
            }

            // Criar ticket
            $ticket = Ticket::create([
                'customer_id' => $customer->id,
                'subscription_id' => $subscription?->id,
                'assigned_to' => $assignedTo,
                'subject' => $template['subject'],
                'description' => $template['description'],
                'priority' => $template['priority'],
                'category' => $template['category'],
                'status' => $template['status'],
                'opened_at' => $openedAt,
                'resolved_at' => $resolvedAt,
                'closed_at' => $closedAt,
            ]);

            $createdTickets[] = $ticket;

            // Criar respostas se existirem
            if (!empty($template['responses']) && $responseUser) {
                foreach ($template['responses'] as $responseData) {
                    TicketResponse::create([
                        'ticket_id' => $ticket->id,
                        'user_id' => $responseUser->id,
                        'response' => $responseData['response'],
                        'is_internal' => $responseData['is_internal'] ?? false,
                        'is_solution' => $responseData['is_solution'] ?? false,
                        'created_at' => now()->subHours($responseData['created_hours_ago']),
                        'updated_at' => now()->subHours($responseData['created_hours_ago']),
                    ]);
                }
            }
        }

        $this->command->info('✅ Tickets criados com sucesso!');

        // Estatísticas
        $stats = [
            'Total' => Ticket::count(),
            'Abertos' => Ticket::where('status', 'open')->count(),
            'Em Progresso' => Ticket::where('status', 'in_progress')->count(),
            'Resolvidos' => Ticket::where('status', 'resolved')->count(),
            'Fechados' => Ticket::where('status', 'closed')->count(),
            'Urgentes' => Ticket::where('priority', 'urgent')->count(),
            'Técnicos' => Ticket::where('category', 'technical')->count(),
            'Com Respostas' => TicketResponse::distinct('ticket_id')->count('ticket_id'),
        ];

        $this->command->info('📊 Estatísticas dos Tickets:');
        foreach ($stats as $label => $count) {
            $this->command->info("   • {$label}: {$count}");
        }

        // Mostrar alguns tickets criados
        $this->command->info("\n🎯 Tickets criados para teste:");
        foreach ($createdTickets->take(5) as $ticket) {
            $priority = match ($ticket->priority) {
                'urgent' => '🔴',
                'high' => '🟠',
                'medium' => '🟡',
                'low' => '🟢'
            };

            $status = match ($ticket->status) {
                'open' => '📭',
                'in_progress' => '⚙️',
                'waiting_customer' => '⏳',
                'resolved' => '✅',
                'closed' => '📫'
            };

            $this->command->line("{$priority} {$status} {$ticket->ticket_number} - {$ticket->subject}");
        }

        if (count($createdTickets) > 5) {
            $remaining = count($createdTickets) - 5;
            $this->command->info("   ... e mais {$remaining} tickets");
        }
    }
}
