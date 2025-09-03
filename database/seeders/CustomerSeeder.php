<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            // Clientes Individuais
            [
                'type' => 'individual',
                'name' => 'João Silva Santos',
                'document' => '110200300400',
                'document_type' => 'bi',
                'email' => 'joao.silva@email.com',
                'phone' => '+258 84 123 4567',
                'whatsapp' => '+258 84 123 4567',
                'status' => 'active',
                'notes' => 'Cliente desde 2020, sempre pontual com pagamentos',
                'addresses' => [
                    [
                        'type' => 'installation',
                        'street' => 'Av. Julius Nyerere',
                        'number' => '1234',
                        'neighborhood' => 'Polana',
                        'district' => 'KaMpfumo',
                        'city' => 'Maputo',
                        'province' => 'Maputo Cidade',
                        'postal_code' => '1100',
                        'reference' => 'Próximo ao Hotel Polana',
                        'latitude' => -25.966688,
                        'longitude' => 32.565473,
                        'is_primary' => true,
                    ]
                ]
            ],
            [
                'type' => 'individual',
                'name' => 'Maria José Macamo',
                'document' => '120300400500',
                'document_type' => 'bi',
                'email' => 'maria.macamo@gmail.com',
                'phone' => '+258 84 987 6543',
                'whatsapp' => '+258 84 987 6543',
                'status' => 'active',
                'notes' => null,
                'addresses' => [
                    [
                        'type' => 'installation',
                        'street' => 'Rua da Resistência',
                        'number' => '456',
                        'neighborhood' => 'Alto Maé',
                        'district' => 'KaMpfumo',
                        'city' => 'Maputo',
                        'province' => 'Maputo Cidade',
                        'reference' => 'Casa azul com portão preto',
                        'is_primary' => true,
                    ]
                ]
            ],
            [
                'type' => 'individual',
                'name' => 'Carlos António Muchangos',
                'document' => '987654321',
                'document_type' => 'nuit',
                'email' => 'carlos.muchangos@outlook.com',
                'phone' => '+258 87 555 1234',
                'whatsapp' => '+258 87 555 1234',
                'status' => 'suspended',
                'notes' => 'Suspenso por atraso no pagamento - contactar para regularização',
                'addresses' => [
                    [
                        'type' => 'installation',
                        'street' => 'Av. Marginal',
                        'number' => '789',
                        'neighborhood' => 'Costa do Sol',
                        'district' => 'KaMubukwana',
                        'city' => 'Maputo',
                        'province' => 'Maputo Cidade',
                        'reference' => 'Condomínio Marginal, Bloco C, Apto 15',
                        'is_primary' => true,
                    ]
                ]
            ],

            // Clientes Empresariais
            [
                'type' => 'company',
                'name' => 'Tecnologias Avançadas de Moçambique LTDA',
                'company_name' => 'TechMoz',
                'document' => '100123456789',
                'document_type' => 'nuit',
                'email' => 'admin@techmoz.co.mz',
                'phone' => '+258 21 123 4567',
                'whatsapp' => '+258 84 123 4567',
                'status' => 'active',
                'notes' => 'Empresa de tecnologia, necessita alta velocidade',
                'addresses' => [
                    [
                        'type' => 'installation',
                        'street' => 'Av. 24 de Julho',
                        'number' => '1500',
                        'neighborhood' => 'Baixa',
                        'district' => 'KaMpfumo',
                        'city' => 'Maputo',
                        'province' => 'Maputo Cidade',
                        'postal_code' => '1100',
                        'reference' => 'Edifício JAT, 5º andar, sala 505',
                        'latitude' => -25.969248,
                        'longitude' => 32.573567,
                        'is_primary' => true,
                    ],
                    [
                        'type' => 'billing',
                        'street' => 'Av. Mártires da Machava',
                        'number' => '852',
                        'neighborhood' => 'Sommerschield',
                        'district' => 'KaMpfumo',
                        'city' => 'Maputo',
                        'province' => 'Maputo Cidade',
                        'reference' => 'Sede administrativa',
                        'is_primary' => false,
                    ]
                ]
            ],
            [
                'type' => 'company',
                'name' => 'Construtora Beira Rio LTDA',
                'company_name' => 'Beira Rio Construções',
                'document' => '200987654321',
                'document_type' => 'nuit',
                'email' => 'geral@beirario.co.mz',
                'phone' => '+258 23 456 7890',
                'status' => 'active',
                'notes' => 'Empresa de construção civil na Beira',
                'addresses' => [
                    [
                        'type' => 'installation',
                        'street' => 'Av. do Zimbabwe',
                        'number' => '1200',
                        'neighborhood' => 'Manga',
                        'district' => 'Beira',
                        'city' => 'Beira',
                        'province' => 'Sofala',
                        'reference' => 'Junto ao mercado central',
                        'is_primary' => true,
                    ]
                ]
            ],
            [
                'type' => 'company',
                'name' => 'Restaurante Sabores do Mar LTDA',
                'company_name' => 'Sabores do Mar',
                'document' => '300456789123',
                'document_type' => 'nuit',
                'email' => 'restaurante@saboresdomar.mz',
                'phone' => '+258 21 987 6543',
                'whatsapp' => '+258 84 987 6543',
                'status' => 'active',
                'notes' => 'Restaurante na Costa do Sol, precisa WiFi para clientes',
                'addresses' => [
                    [
                        'type' => 'installation',
                        'street' => 'Av. Marginal',
                        'number' => '2500',
                        'neighborhood' => 'Costa do Sol',
                        'district' => 'KaMubukwana',
                        'city' => 'Maputo',
                        'province' => 'Maputo Cidade',
                        'reference' => 'Restaurante em frente à praia',
                        'latitude' => -25.930000,
                        'longitude' => 32.605000,
                        'is_primary' => true,
                    ]
                ]
            ],

            // Cliente Inativo
            [
                'type' => 'individual',
                'name' => 'Pedro Manuel Chissano',
                'document' => 'A1234567',
                'document_type' => 'passport',
                'email' => 'pedro.chissano@yahoo.com',
                'phone' => '+258 82 111 2222',
                'status' => 'inactive',
                'notes' => 'Cliente cancelou serviços em 2023, mudou-se para África do Sul',
                'addresses' => [
                    [
                        'type' => 'installation',
                        'street' => 'Rua dos Continuadores',
                        'number' => '100',
                        'neighborhood' => 'Malhangalene',
                        'district' => 'KaMpfumo',
                        'city' => 'Maputo',
                        'province' => 'Maputo Cidade',
                        'reference' => 'Casa térrea com jardim',
                        'is_primary' => true,
                    ]
                ]
            ],

            // Mais clientes individuais
            [
                'type' => 'individual',
                'name' => 'Ana Cristina Mondlane',
                'document' => '150400500600',
                'document_type' => 'bi',
                'email' => 'ana.mondlane@hotmail.com',
                'phone' => '+258 86 333 4444',
                'whatsapp' => '+258 86 333 4444',
                'status' => 'active',
                'notes' => 'Professora universitária, trabalha em casa',
                'addresses' => [
                    [
                        'type' => 'installation',
                        'street' => 'Av. Eduardo Mondlane',
                        'number' => '2890',
                        'neighborhood' => 'Jardim',
                        'district' => 'KaMpfumo',
                        'city' => 'Maputo',
                        'province' => 'Maputo Cidade',
                        'reference' => 'Prédio verde, 3º andar direito',
                        'is_primary' => true,
                    ]
                ]
            ],
        ];

        foreach ($customers as $customerData) {
            $addresses = $customerData['addresses'];
            unset($customerData['addresses']);

            // Criar o cliente
            $customer = Customer::create($customerData);

            // Criar os endereços
            foreach ($addresses as $addressData) {
                $addressData['customer_id'] = $customer->id;
                Address::create($addressData);
            }
        }

        $this->command->info('Clientes criados com sucesso!');
        
        // Mostrar resumo
        $stats = [
            'Total' => Customer::count(),
            'Individuais' => Customer::where('type', 'individual')->count(),
            'Empresas' => Customer::where('type', 'company')->count(),
            'Ativos' => Customer::where('status', 'active')->count(),
            'Suspensos' => Customer::where('status', 'suspended')->count(),
            'Inativos' => Customer::where('status', 'inactive')->count(),
            'Endereços' => Address::count(),
        ];

        $this->command->table(
            ['Categoria', 'Quantidade'],
            collect($stats)->map(function ($value, $key) {
                return [$key, $value];
            })
        );

        // Listar alguns clientes criados
        $this->command->info("\n🎯 Clientes criados para teste:");
        Customer::with('addresses')->get()->each(function ($customer) {
            $type = $customer->type === 'individual' ? '👤' : '🏢';
            $status = match($customer->status) {
                'active' => '✅',
                'suspended' => '⚠️',
                'inactive' => '❌',
            };
            
            $this->command->line("{$type} {$status} {$customer->name} ({$customer->document}) - {$customer->addresses->count()} endereço(s)");
        });
    }
}
