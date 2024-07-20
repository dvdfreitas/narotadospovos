<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('partners')->insert([
            'name' => 'A Lareira',
            'logo' => 'a_lareira.png',
        ]);

        DB::table('partners')->insert([
            'name' => 'At Porto',
            'logo' => 'atporto.png',
        ]);

        DB::table('partners')->insert([
            'name' => 'Bi Cafe',
            'logo' => 'bicafe.png',
        ]);

        DB::table('partners')->insert([
            'name' => 'Cabeleireiro Teresa Moreira',
            'logo' => 'cabeleireiro_teresa_moreira.png',
        ]);

        DB::table('partners')->insert([
            'name' => 'Cantinho Caseiro',
            'logo' => 'cantinho_caseiro.jpg',
        ]);

        DB::table('partners')->insert([
            'name' => 'Cegonha',
            'logo' => 'cegonha.jpeg',
        ]);

        DB::table('partners')->insert([
            'name' => 'Confeitaria Avenida',
            'logo' => 'confeitaria_avenida.png',
        ]);

        DB::table('partners')->insert([
            'name' => 'Costa Capelo',
            'logo' => 'costa_capelo.jpeg',
        ]);

        DB::table('partners')->insert([
            'name' => 'Curtes',
            'logo' => 'curtes.png',
        ]);

        DB::table('partners')->insert([
            'name' => 'Epa Carvalhais',
            'logo' => 'a_lareira.png',
        ]);

        DB::table('partners')->insert([
            'name' => 'Feito à Mão',
            'logo' => 'feito_mao.jpg',
        ]);

        DB::table('partners')->insert([
            'name' => 'GSLines',
            'logo' => 'gsl.png',
        ]);

        DB::table('partners')->insert([
            'name' => 'Henisa',
            'logo' => 'henisa.png',
        ]);

        DB::table('partners')->insert([
            'name' => 'Instituto Politécnico de Bragança',
            'logo' => 'ipb.png',
        ]);
        
        DB::table('partners')->insert([
            'name' => 'Jardim Confeitaria',
            'logo' => 'jardim-confeitaria.jpeg',
        ]);

        DB::table('partners')->insert([
            'name' => 'Juvenil',
            'logo' => 'juvenil.png',
        ]);

        DB::table('partners')->insert([
            'name' => 'Mini Mercado Cunha',
            'logo' => 'minimercado_cunha.jpeg',
        ]);

        DB::table('partners')->insert([
            'name' => 'Orthos XXI',
            'logo' => 'orthosxxi.jpg',
        ]);

        DB::table('partners')->insert([
            'name' => 'Pedregal Hotel',
            'logo' => 'pedregal-hotel.jpeg',
        ]);

        DB::table('partners')->insert([
            'name' => 'Pé no Mar',
            'logo' => 'penomar.jpeg',
        ]);

        DB::table('partners')->insert([
            'name' => 'Persono',
            'logo' => 'persono.jpg',
        ]);

        DB::table('partners')->insert([
            'name' => 'Rogerio do Redondo',
            'logo' => 'rogerio-do-redondo.png',
        ]);

        DB::table('partners')->insert([
            'name' => 'Rosenblatt',
            'logo' => 'rosenblatt.png',
        ]);

        DB::table('partners')->insert([
            'name' => 'Tabanca Pequena',
            'logo' => 'tabanca_pequena.jpg',
        ]);

        DB::table('partners')->insert([
            'name' => 'Talho Popular',
            'logo' => 'talho_popular.jpg',
        ]);
    }
}
