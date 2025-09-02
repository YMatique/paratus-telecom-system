<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $plans = [
            // Planos Fibra Individual
            [
                'name' => 'Fibra 50MB',
                'description' => 'Plano ideal para uso doméstico básico. Navegação, redes sociais e streaming em HD.',
                'download_speed' => 50,
                'upload_speed' => 25,
                'price' => 1200.00,
                'billing_cycle' => 'monthly',
                'unlimited_data' => true,
                'data_limit_gb' => null,
                'connection_type' => 'fiber',
                'customer_type' => 'individual',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Fibra 100MB',
                'description' => 'Plano popular para famílias. Múltiplos dispositivos, streaming 4K e jogos online.',
                'download_speed' => 100,
                'upload_speed' => 50,
                'price' => 1800.00,
                'billing_cycle' => 'monthly',
                'unlimited_data' => true,
                'data_limit_gb' => null,
                'connection_type' => 'fiber',
                'customer_type' => 'individual',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Fibra 200MB',
                'description' => 'Alta velocidade para power users. Trabalho remoto, uploads rápidos e gaming.',
                'download_speed' => 200,
                'upload_speed' => 100,
                'price' => 2500.00,
                'billing_cycle' => 'monthly',
                'unlimited_data' => true,
                'data_limit_gb' => null,
                'connection_type' => 'fiber',
                'customer_type' => 'both',
                'is_active' => true,
                'sort_order' => 3,
            ],
            
            // Planos Fibra Empresarial
            [
                'name' => 'Fibra Business 500MB',
                'description' => 'Solução empresarial com alta velocidade e SLA garantido.',
                'download_speed' => 500,
                'upload_speed' => 250,
                'price' => 5500.00,
                'billing_cycle' => 'monthly',
                'unlimited_data' => true,
                'data_limit_gb' => null,
                'connection_type' => 'fiber',
                'customer_type' => 'company',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Fibra Business 1GB',
                'description' => 'Máxima velocidade para empresas de grande porte e datacenters.',
                'download_speed' => 1000,
                'upload_speed' => 500,
                'price' => 8500.00,
                'billing_cycle' => 'monthly',
                'unlimited_data' => true,
                'data_limit_gb' => null,
                'connection_type' => 'fiber',
                'customer_type' => 'company',
                'is_active' => true,
                'sort_order' => 5,
            ],
            
            // Planos Rádio
            [
                'name' => 'Rádio 20MB',
                'description' => 'Conectividade via rádio para áreas onde fibra não está disponível.',
                'download_speed' => 20,
                'upload_speed' => 10,
                'price' => 800.00,
                'billing_cycle' => 'monthly',
                'unlimited_data' => false,
                'data_limit_gb' => 200,
                'connection_type' => 'radio',
                'customer_type' => 'individual',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Rádio 50MB',
                'description' => 'Internet via rádio com boa velocidade para uso residencial.',
                'download_speed' => 50,
                'upload_speed' => 25,
                'price' => 1400.00,
                'billing_cycle' => 'monthly',
                'unlimited_data' => true,
                'data_limit_gb' => null,
                'connection_type' => 'radio',
                'customer_type' => 'both',
                'is_active' => true,
                'sort_order' => 7,
            ],
            
            // Plano ADSL (Legacy)
            [
                'name' => 'ADSL 10MB',
                'description' => 'Plano básico ADSL para áreas com infraestrutura telefônica.',
                'download_speed' => 10,
                'upload_speed' => 1,
                'price' => 600.00,
                'billing_cycle' => 'monthly',
                'unlimited_data' => false,
                'data_limit_gb' => 100,
                'connection_type' => 'adsl',
                'customer_type' => 'individual',
                'is_active' => false, // Descontinuado
                'sort_order' => 8,
            ],
            
            // Planos Promocionais/Especiais
            [
                'name' => 'Fibra Student 30MB',
                'description' => 'Plano especial para estudantes com desconto. Ideal para estudos online.',
                'download_speed' => 30,
                'upload_speed' => 15,
                'price' => 900.00,
                'billing_cycle' => 'monthly',
                'unlimited_data' => true,
                'data_limit_gb' => null,
                'connection_type' => 'fiber',
                'customer_type' => 'individual',
                'is_active' => true,
                'sort_order' => 9,
            ],
            [
                'name' => 'Fibra Premium 300MB',
                'description' => 'Plano premium com velocidade superior e suporte prioritário.',
                'download_speed' => 300,
                'upload_speed' => 150,
                'price' => 3500.00,
                'billing_cycle' => 'monthly',
                'unlimited_data' => true,
                'data_limit_gb' => null,
                'connection_type' => 'fiber',
                'customer_type' => 'both',
                'is_active' => true,
                'sort_order' => 10,
            ],
        ];

        foreach ($plans as $planData) {
            Plan::create($planData);
        }
        
        $this->command->info('Planos criados com sucesso!');
        $this->command->table(
            ['Nome', 'Velocidade', 'Preço', 'Tipo', 'Status'],
            collect($plans)->map(function ($plan) {
                return [
                    $plan['name'],
                    $plan['download_speed'] . '/' . $plan['upload_speed'] . ' Mbps',
                    'MT ' . number_format($plan['price'], 2),
                    ucfirst($plan['connection_type']),
                    $plan['is_active'] ? 'Ativo' : 'Inativo'
                ];
            })
        );
    }
}
