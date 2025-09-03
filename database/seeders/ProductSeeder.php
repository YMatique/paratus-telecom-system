<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $products = [
            // MODEMS
            [
                'name' => 'Modem ADSL TP-Link TD-W8961N',
                'model' => 'TD-W8961N',
                'brand' => 'TP-Link',
                'category' => 'modem',
                'description' => 'Modem ADSL2+ Wireless N de 300Mbps com 4 portas Ethernet e Wi-Fi integrado',
                'sale_price' => 2500.00,
                'rental_price' => 150.00,
                'stock_quantity' => 45,
                'min_stock_alert' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'Modem ADSL Huawei HG532e',
                'model' => 'HG532e',
                'brand' => 'Huawei',
                'category' => 'modem',
                'description' => 'Modem ADSL2+ com Wi-Fi N 300Mbps, ideal para conexões residenciais',
                'sale_price' => 2200.00,
                'rental_price' => 120.00,
                'stock_quantity' => 28,
                'min_stock_alert' => 8,
                'is_active' => true,
            ],
            [
                'name' => 'Modem VDSL ZTE H298A',
                'model' => 'H298A',
                'brand' => 'ZTE',
                'category' => 'modem',
                'description' => 'Modem VDSL2 com Wi-Fi AC dual-band, 4 portas Gigabit e USB',
                'sale_price' => 3200.00,
                'rental_price' => 200.00,
                'stock_quantity' => 15,
                'min_stock_alert' => 5,
                'is_active' => true,
            ],
            
            // ROTEADORES
            [
                'name' => 'Roteador TP-Link Archer C6',
                'model' => 'Archer C6',
                'brand' => 'TP-Link',
                'category' => 'router',
                'description' => 'Roteador Wireless Dual Band AC1200, 4 antenas externas, MU-MIMO',
                'sale_price' => 3500.00,
                'rental_price' => 250.00,
                'stock_quantity' => 32,
                'min_stock_alert' => 8,
                'is_active' => true,
            ],
            [
                'name' => 'Roteador Mikrotik hAP ac²',
                'model' => 'hAP ac²',
                'brand' => 'Mikrotik',
                'category' => 'router',
                'description' => 'Roteador dual-band 802.11ac com 5 portas Gigabit e PoE-out',
                'sale_price' => 4800.00,
                'rental_price' => 300.00,
                'stock_quantity' => 18,
                'min_stock_alert' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Roteador Ubiquiti EdgeRouter X',
                'model' => 'EdgeRouter X',
                'brand' => 'Ubiquiti',
                'category' => 'router',
                'description' => 'Roteador profissional de 5 portas com funcionalidades avançadas',
                'sale_price' => 5200.00,
                'rental_price' => 350.00,
                'stock_quantity' => 12,
                'min_stock_alert' => 3,
                'is_active' => true,
            ],
            
            // ONUs
            [
                'name' => 'ONU Huawei HG8245H',
                'model' => 'HG8245H',
                'brand' => 'Huawei',
                'category' => 'onu',
                'description' => 'ONU GPON com Wi-Fi AC1200, 4 portas GE, 2 POTS e USB',
                'sale_price' => 4500.00,
                'rental_price' => 280.00,
                'stock_quantity' => 52,
                'min_stock_alert' => 15,
                'is_active' => true,
            ],
            [
                'name' => 'ONU ZTE F670L',
                'model' => 'F670L',
                'brand' => 'ZTE',
                'category' => 'onu',
                'description' => 'ONU GPON dual-band com 4 portas Ethernet e 2 portas telefônicas',
                'sale_price' => 4200.00,
                'rental_price' => 260.00,
                'stock_quantity' => 38,
                'min_stock_alert' => 12,
                'is_active' => true,
            ],
            [
                'name' => 'ONU Fiberhome AN5506-04-A',
                'model' => 'AN5506-04-A',
                'brand' => 'Fiberhome',
                'category' => 'onu',
                'description' => 'ONU GPON com Wi-Fi N300, 4 portas FE e funcionalidades básicas',
                'sale_price' => 3800.00,
                'rental_price' => 220.00,
                'stock_quantity' => 25,
                'min_stock_alert' => 8,
                'is_active' => true,
            ],
            
            // ANTENAS
            [
                'name' => 'Antena Ubiquiti NanoStation AC',
                'model' => 'NanoStation AC',
                'brand' => 'Ubiquiti',
                'category' => 'antenna',
                'description' => 'Antena Point-to-Point 5GHz com tecnologia AC e 19dBi de ganho',
                'sale_price' => 8500.00,
                'rental_price' => 500.00,
                'stock_quantity' => 22,
                'min_stock_alert' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Antena Mikrotik SXT LTE6',
                'model' => 'SXT LTE6',
                'brand' => 'Mikrotik',
                'category' => 'antenna',
                'description' => 'Antena LTE de categoria 6 para conexões móveis de alta velocidade',
                'sale_price' => 12500.00,
                'rental_price' => 650.00,
                'stock_quantity' => 8,
                'min_stock_alert' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Antena Setorial 5GHz 15dBi',
                'model' => 'AM-5G15-90',
                'brand' => 'Ubiquiti',
                'category' => 'antenna',
                'description' => 'Antena setorial de 5GHz com 15dBi de ganho e abertura de 90°',
                'sale_price' => 6800.00,
                'rental_price' => 400.00,
                'stock_quantity' => 14,
                'min_stock_alert' => 3,
                'is_active' => true,
            ],
            
            // CABOS
            [
                'name' => 'Cabo UTP Cat5e 305m',
                'model' => 'CAT5E-305',
                'brand' => 'Furukawa',
                'category' => 'cable',
                'description' => 'Cabo de rede UTP categoria 5e, caixa com 305 metros, azul',
                'sale_price' => 8500.00,
                'rental_price' => null,
                'stock_quantity' => 12,
                'min_stock_alert' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Cabo Fibra Óptica Monomodo 1km',
                'model' => 'SM-1KM-12F',
                'brand' => 'Corning',
                'category' => 'cable',
                'description' => 'Cabo de fibra óptica monomodo com 12 fibras, bobina de 1000 metros',
                'sale_price' => 25000.00,
                'rental_price' => null,
                'stock_quantity' => 5,
                'min_stock_alert' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Cabo Coaxial RG-6 100m',
                'model' => 'RG6-100',
                'brand' => 'CommScope',
                'category' => 'cable',
                'description' => 'Cabo coaxial RG-6 para CCTV e TV, bobina de 100 metros',
                'sale_price' => 3200.00,
                'rental_price' => null,
                'stock_quantity' => 18,
                'min_stock_alert' => 4,
                'is_active' => true,
            ],
            
            // OUTROS EQUIPAMENTOS
            [
                'name' => 'Switch Gigabit 24 Portas',
                'model' => 'TL-SG1024',
                'brand' => 'TP-Link',
                'category' => 'other',
                'description' => 'Switch não gerenciável de 24 portas Gigabit Ethernet',
                'sale_price' => 15500.00,
                'rental_price' => 800.00,
                'stock_quantity' => 6,
                'min_stock_alert' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Conversor de Mídia Gigabit',
                'model' => 'MC210CS',
                'brand' => 'TP-Link',
                'category' => 'other',
                'description' => 'Conversor de mídia Ethernet para fibra óptica monomodo',
                'sale_price' => 2800.00,
                'rental_price' => 180.00,
                'stock_quantity' => 35,
                'min_stock_alert' => 8,
                'is_active' => true,
            ],
            [
                'name' => 'Fonte PoE 48V 1A',
                'model' => 'POE-48-24W',
                'brand' => 'Ubiquiti',
                'category' => 'other',
                'description' => 'Fonte de alimentação PoE de 48V 1A para equipamentos Ubiquiti',
                'sale_price' => 850.00,
                'rental_price' => 50.00,
                'stock_quantity' => 62,
                'min_stock_alert' => 15,
                'is_active' => true,
            ],
            [
                'name' => 'Patch Panel 24 Portas',
                'model' => 'PP24-CAT6',
                'brand' => 'Panduit',
                'category' => 'other',
                'description' => 'Patch panel de 24 portas categoria 6 para rack 19"',
                'sale_price' => 4200.00,
                'rental_price' => null,
                'stock_quantity' => 8,
                'min_stock_alert' => 2,
                'is_active' => true,
            ],
            
            // ALGUNS PRODUTOS SEM ESTOQUE (para testar filtros)
            [
                'name' => 'Roteador Cisco RV320',
                'model' => 'RV320',
                'brand' => 'Cisco',
                'category' => 'router',
                'description' => 'Roteador VPN dual WAN para pequenas empresas',
                'sale_price' => 18500.00,
                'rental_price' => 950.00,
                'stock_quantity' => 0,
                'min_stock_alert' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Antena Parabólica 1.8m',
                'model' => 'DISH-1.8M',
                'brand' => 'Andrew',
                'category' => 'antenna',
                'description' => 'Antena parabólica de 1.8 metros para enlaces de longa distância',
                'sale_price' => 45000.00,
                'rental_price' => 2500.00,
                'stock_quantity' => 0,
                'min_stock_alert' => 1,
                'is_active' => false, // Produto inativo
            ],
            
            // PRODUTOS COM ESTOQUE BAIXO (para testar alertas)
            [
                'name' => 'Media Converter SC 20km',
                'model' => 'MC-SC-20',
                'brand' => 'D-Link',
                'category' => 'other',
                'description' => 'Conversor de mídia fibra óptica SC monomodo 20km',
                'sale_price' => 3500.00,
                'rental_price' => 200.00,
                'stock_quantity' => 2, // Estoque baixo
                'min_stock_alert' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
        
        $this->command->info('✅ Produtos criados com sucesso!');
        $this->command->info('📊 Estatísticas:');
        $this->command->info('   • Total de produtos: ' . count($products));
        $this->command->info('   • Modems: ' . collect($products)->where('category', 'modem')->count());
        $this->command->info('   • Roteadores: ' . collect($products)->where('category', 'router')->count());
        $this->command->info('   • ONUs: ' . collect($products)->where('category', 'onu')->count());
        $this->command->info('   • Antenas: ' . collect($products)->where('category', 'antenna')->count());
        $this->command->info('   • Cabos: ' . collect($products)->where('category', 'cable')->count());
        $this->command->info('   • Outros: ' . collect($products)->where('category', 'other')->count());
  
    }
}
