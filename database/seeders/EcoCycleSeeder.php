<?php

namespace Database\Seeders;

use App\Enums\DeliveryMethodType;
use App\Models\Branch;
use App\Models\DeliveryMethod;
use App\Models\Partner;
use App\Models\User;
use App\Models\WasteCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EcoCycleSeeder extends Seeder
{
    public function run(): void
    {
        // === Branches ===
        $branches = [
            ['code' => 'KDRJYB',  'name' => 'EcoCycle Joyoboyo Kediri',         'address' => 'Jl. Joyoboyo No. 16, Kediri, Jawa Timur 64111'],
            ['code' => 'KDRKNR',  'name' => 'EcoCycle Kenari Kediri',           'address' => 'Jl. Kenari No.7, Kediri, Jawa Timur 64129'],
            ['code' => 'KDRDDG',  'name' => 'EcoCycle Dandangan Kediri',        'address' => 'Jl. Dandangan No.11, Kediri, Jawa Timur 64122'],
            ['code' => 'KDRMLT',  'name' => 'EcoCycle Melati Kediri',           'address' => 'Jl. Melati No.9, Kediri, Jawa Timur 64125'],
            ['code' => 'KDRPTMR', 'name' => 'EcoCycle Pattimura Kediri',        'address' => 'Jl. Pattimura No.10, Kediri, Jawa Timur 64124'],
            ['code' => 'KDRPMNG', 'name' => 'EcoCycle Pamenang Kediri',         'address' => 'Jl. Pamenang No.21, Kediri, Jawa Timur 64126'],
            ['code' => 'KDRKLSC', 'name' => 'EcoCycle Kilisuci Kediri',         'address' => 'Jl. Kilisuci No.12, Kediri, Jawa Timur 64114'],
            ['code' => 'KDRRG',   'name' => 'EcoCycle Raung Kediri',            'address' => 'Jl. Raung No.1, Kediri, Jawa Timur 64117'],
            ['code' => 'KDRVTR',  'name' => 'EcoCycle Veteran Kediri',          'address' => 'Jl. Veteran No.8, Kediri, Jawa Timur 64118'],
            ['code' => 'KDRLJS',  'name' => 'EcoCycle Letjen Sutoyo Kediri',    'address' => 'Jl. Letjen Sutoyo No.15, Kediri, Jawa Timur 64133'],
            ['code' => 'KDRIMB',  'name' => 'EcoCycle Imam Bonjol Kediri',      'address' => 'Jl. Imam Bonjol No.2, Kediri, Jawa Timur 64131'],
            ['code' => 'KDRPRM',  'name' => 'EcoCycle Pramuka Kediri',          'address' => 'Jl. Pramuka No.4, Kediri, Jawa Timur 64132'],
            ['code' => 'KDRMW',   'name' => 'EcoCycle Mawar Pare',              'address' => 'Jl. Mawar No.1, Kediri, Jawa Timur 64213'],
            ['code' => 'KDRGMP',  'name' => 'EcoCycle Gampeng Kediri',          'address' => 'Jl. Raya Gampeng No.6, Kediri, Jawa Timur 64182'],
            ['code' => 'KDRRW',   'name' => 'EcoCycle Raya Wates',              'address' => 'Jl. Raya Wates No.3, Kediri, Jawa Timur 64174'],
            ['code' => 'KDRPHL',  'name' => 'EcoCycle Pahlwan Kediri',          'address' => 'Jl. Pahlawan No.8, Kediri, Jawa Timur 64171'],
            ['code' => 'KDRGK',   'name' => 'EcoCycle Gurah Kediri',            'address' => 'Jl. Raya Gurah No.2, Kediri, Jawa Timur 64181'],
            ['code' => 'KDRKN',   'name' => 'EcoCycle Raya Kandat',             'address' => 'Jl. Raya Kandat No.5, Kediri, Jawa Timur 64173'],
            ['code' => 'KDRRKR',  'name' => 'EcoCycle Raya Kras',               'address' => 'Jl. Raya Kras No.11, Kediri, Jawa Timur 64172'],
        ];

        foreach ($branches as $branch) {
            Branch::firstOrCreate(['code' => $branch['code']], $branch);
        }

        // === Partners (one per branch) ===
        foreach ($branches as $branch) {
            Partner::firstOrCreate(
                ['name' => $branch['name']],
                [
                    'address' => $branch['address'],
                    'phone'   => null,
                    'email'   => null,
                ]
            );
        }

        // === Delivery Methods ===
        $deliveryMethods = [
            ['name' => 'Dijemput Kurir EcoCycle',          'description' => 'Kurir EcoCycle akan datang ke alamat penjemputan',   'type' => DeliveryMethodType::Incoming, 'is_self_service' => false],
            ['name' => 'Diantar Langsung ke Cabang Terdekat','description' => 'Kamu akan mendapat panduan arah otomatis',        'type' => DeliveryMethodType::Incoming, 'is_self_service' => true],
            ['name' => 'JNE',                                'description' => null,                                                  'type' => DeliveryMethodType::Outgoing, 'is_self_service' => false],
            ['name' => 'Ninja Xpress',                       'description' => null,                                                  'type' => DeliveryMethodType::Outgoing, 'is_self_service' => false],
            ['name' => 'SiCepat',                            'description' => null,                                                  'type' => DeliveryMethodType::Outgoing, 'is_self_service' => false],
            ['name' => 'JnT',                                'description' => null,                                                  'type' => DeliveryMethodType::Outgoing, 'is_self_service' => false],
        ];

        foreach ($deliveryMethods as $dm) {
            DeliveryMethod::firstOrCreate(['name' => $dm['name']], $dm);
        }

        // === Waste Categories ===
        $wasteCategories = [
            ['name' => 'Plastik',     'description' => 'Sampah berbahan dasar plastik, bisa didaur ulang menjadi bijih plastik atau kerajinan.',                                                                                     'sales_price' => 4500,  'purchase_price' => 1500],
            ['name' => 'Kertas',      'description' => 'Sampah berbahan kertas yang masih bisa diolah kembali, seperti kardus, koran, dan dokumen.',                                                                             'sales_price' => 3000,  'purchase_price' => 1000],
            ['name' => 'Kaca',        'description' => 'Kaca adalah material yang 100% dapat didaur ulang tanpa kehilangan kualitas.',                                                                                           'sales_price' => 800,   'purchase_price' => 300],
            ['name' => 'Logam',       'description' => 'Logam memiliki nilai ekonomi tinggi dan sangat efisien untuk didaur ulang.',                                                                                             'sales_price' => 7000,  'purchase_price' => 2500],
            ['name' => 'Elektronik',  'description' => 'Sampah elektronik memerlukan penanganan khusus. Material ini mengandung komponen berharga seperti emas, perak, dan tembaga.',                                             'sales_price' => 15000, 'purchase_price' => 5000],
            ['name' => 'Tekstil',     'description' => 'Pakaian atau kain bekas dapat diolah kembali.',                                                                                                                         'sales_price' => 2000,  'purchase_price' => 500],
            ['name' => 'Organik',     'description' => 'Sampah organik (sisa makanan, daun, dll) dapat diproses menjadi kompos atau biogas.',                                                                                    'sales_price' => 500,   'purchase_price' => 100],
            ['name' => 'Dus (Kardus)','description' => 'Bahan kertas berlapis tebal yang biasa dipakai untuk kemasan barang.',                                                                                                   'sales_price' => 2000,  'purchase_price' => 1000],
            ['name' => 'Duplek',      'description' => 'Jenis karton tipis dari kertas daur ulang untuk kemasan ringan seperti kotak makanan.',                                                                                  'sales_price' => 1000,  'purchase_price' => 500],
        ];

        foreach ($wasteCategories as $wc) {
            WasteCategory::firstOrCreate(['name' => $wc['name']], $wc);
        }

        // === Admin User ===
        $firstBranch = Branch::first();

        $admin = User::firstOrCreate(
            ['email' => 'admin@ecocycle.com'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('12345678'),
            ]
        );

        $admin->branches()->syncWithoutDetaching([$firstBranch->id]);
    }
}
