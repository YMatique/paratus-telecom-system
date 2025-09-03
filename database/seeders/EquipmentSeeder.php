<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Equipment;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $this->command->info('🔄 Criando equipamentos...');

        // Buscar produtos e clientes existentes
        $products = Product::all();
        $customers = Customer::all();

        if ($products->isEmpty()) {
            $this->command->error('❌ Nenhum produto encontrado. Execute o ProductSeeder primeiro.');
            return;
        }

        if ($customers->isEmpty()) {
            $this->command->warn('⚠️  Nenhum cliente encontrado. Criando equipamentos apenas disponíveis.');
        }

        $equipments = [];
        $counter = 1;

        // Criar equipamentos para cada produto
        foreach ($products as $product) {
            $quantityToCreate = min($product->stock_quantity, rand(2, 8)); // Entre 2-8 equipamentos por produto
            
            for ($i = 0; $i < $quantityToCreate; $i++) {
                $equipments[] = $this->generateEquipment($product, $customers, $counter);
                $counter++;
            }
        }

        // Criar equipamentos em lote
        foreach ($equipments as $equipmentData) {
            Equipment::create($equipmentData);
        }
        
        $this->command->info('✅ Equipamentos criados com sucesso!');
        
        // Estatísticas
        $stats = [
            'total' => Equipment::count(),
            'available' => Equipment::where('status', 'available')->count(),
            'installed' => Equipment::where('status', 'installed')->count(),
            'maintenance' => Equipment::where('status', 'maintenance')->count(),
            'damaged' => Equipment::where('status', 'damaged')->count(),
        ];
        
        $this->command->info('📊 Estatísticas:');
        $this->command->info("   • Total: {$stats['total']}");
        $this->command->info("   • Disponíveis: {$stats['available']}");
        $this->command->info("   • Instalados: {$stats['installed']}");
        $this->command->info("   • Em Manutenção: {$stats['maintenance']}");
        $this->command->info("   • Avariados: {$stats['damaged']}");
    }
     private function generateEquipment(Product $product, $customers, int $counter): array
    {
        // Definir status aleatório com pesos
        $statusDistribution = [
            'available' => 50,    // 50% disponível
            'installed' => 35,    // 35% instalado
            'maintenance' => 10,  // 10% manutenção
            'damaged' => 5,       // 5% avariado
        ];
        
        $status = $this->weightedRandom($statusDistribution);
        
        // Gerar dados básicos
        $serialNumber = $this->generateSerialNumber($product, $counter);
        $macAddress = $this->shouldHaveMac($product) ? $this->generateMacAddress() : null;
        
        $equipment = [
            'product_id' => $product->id,
            'serial_number' => $serialNumber,
            'mac_address' => $macAddress,
            'status' => $status,
            'customer_id' => null,
            'installation_date' => null,
            'return_date' => null,
            'location_notes' => null,
        ];

        // Configurar dados específicos por status
        switch ($status) {
            case 'installed':
                if (!$customers->isEmpty()) {
                    $customer = $customers->random();
                    $installDate = now()->subDays(rand(30, 365));
                    
                    $equipment['customer_id'] = $customer->id;
                    $equipment['installation_date'] = $installDate;
                    $equipment['location_notes'] = $this->generateLocationNotes($customer);
                }
                break;

            case 'maintenance':
                $equipment['location_notes'] = $this->generateMaintenanceNotes();
                break;

            case 'damaged':
                $equipment['location_notes'] = $this->generateDamageNotes();
                break;

            case 'available':
                // Alguns equipamentos disponíveis podem ter histórico de uso
                if (rand(1, 100) <= 30) { // 30% chance de ter histórico
                    $equipment['return_date'] = now()->subDays(rand(1, 60));
                    $equipment['location_notes'] = 'Retornado pelo cliente';
                }
                break;
        }

        return $equipment;
    }

    private function generateSerialNumber(Product $product, int $counter): string
    {
        // Gerar serial baseado na marca/categoria
        $prefix = match($product->brand) {
            'TP-Link' => 'TPL',
            'Huawei' => 'HW',
            'ZTE' => 'ZTE',
            'Ubiquiti' => 'UBI',
            'Mikrotik' => 'MT',
            'Cisco' => 'CSC',
            'D-Link' => 'DL',
            'Fiberhome' => 'FH',
            default => 'EQ'
        };

        $categoryCode = match($product->category) {
            'modem' => 'M',
            'router' => 'R',
            'onu' => 'O',
            'antenna' => 'A',
            'cable' => 'C',
            default => 'X'
        };

        return $prefix . $categoryCode . str_pad($counter, 6, '0', STR_PAD_LEFT);
    }

    private function generateMacAddress(): string
    {
        // Gerar MAC address válido
        $mac = [];
        for ($i = 0; $i < 6; $i++) {
            $mac[] = str_pad(dechex(rand(0, 255)), 2, '0', STR_PAD_LEFT);
        }
        return strtoupper(implode('', $mac));
    }

    private function shouldHaveMac(Product $product): bool
    {
        // Só equipamentos de rede têm MAC address
        return in_array($product->category, ['modem', 'router', 'onu', 'antenna']);
    }

    private function generateLocationNotes(Customer $customer): string
    {
        $locations = [
            "Instalado na residência do cliente",
            "Casa do cliente - Sala principal",
            "Escritório do cliente - Recepção",
            "Residência - Quarto principal",
            "Casa - Área de serviço",
            "Apartamento - Varanda",
            "Loja do cliente - Balcão",
            "Residência - Corredor central"
        ];

        return $locations[array_rand($locations)];
    }

    private function generateMaintenanceNotes(): string
    {
        $issues = [
            "Equipamento com sinal instável",
            "Problema na fonte de alimentação",
            "Led de sinal intermitente",
            "Sobrecarga na rede",
            "Verificação preventiva",
            "Atualização de firmware",
            "Problema na conectividade",
            "Aquecimento excessivo"
        ];

        return "Manutenção: " . $issues[array_rand($issues)];
    }

    private function generateDamageNotes(): string
    {
        $damages = [
            "Equipamento queimado por descarga elétrica",
            "Danos físicos na carcaça",
            "Componente interno avariado",
            "Porta ethernet danificada",
            "Antena quebrada",
            "Fonte de alimentação queimada",
            "Molhado por chuva",
            "Queda durante transporte"
        ];

        return "Avaria: " . $damages[array_rand($damages)];
    }

    private function weightedRandom(array $weights): string
    {
        $totalWeight = array_sum($weights);
        $randomWeight = rand(1, $totalWeight);
        
        $currentWeight = 0;
        foreach ($weights as $option => $weight) {
            $currentWeight += $weight;
            if ($randomWeight <= $currentWeight) {
                return $option;
            }
        }
        
        return array_key_first($weights);
    }
}
