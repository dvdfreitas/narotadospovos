<?php

namespace Database\Seeders;

use App\Models\Partner;
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
        Partner::truncate();

        DB::table('partners')->insert([
            'name' => 'Instituto Politécnico de Bragança',
            'logo' => 'ipb.png',
            'website' => 'https://portal3.ipb.pt/',
            'visible' => true
        ]);

        DB::table('partners')->insert([
            'name' => 'GS Lines',
            'logo' => 'gsl.png',
            'website' => 'https://www.gslines.pt/en/homepage-gs-lines-international/',
            'visible' => true
        ]);

        DB::table('partners')->insert([
            'name' => 'Curtes',
            'slug' => 'curtes',
            'logo' => 'curtes.png',
            'website' => 'https://curtes.com/',
            'visible' => true
        ]);

        DB::table('partners')->insert([
            'name' => 'Henisa',
            'slug' => 'henisa',
            'logo' => 'henisa.png',
            'website' => 'https://henisa.pt/',
            'visible' => true
        ]);

        DB::table('partners')->insert([
            'name' => 'Tabanca Pequena',
            'logo' => 'tabanca_pequena.jpg',
            'website' => 'https://www.facebook.com/tabancapequena.ongd',
            'visible' => true
        ]);

        DB::table('partners')->insert([
            'name' => 'Fundação Rosenblatt',
            'logo' => 'rosenblatt.png',
            'website' => 'https://rosenblattfoundation.org/',
            'visible' => true
        ]);

        DB::table('partners')->insert([
            'name' => 'Escola Profissional de Agricultura e Desenvolvimento Rural de Caravalhais',
            'logo' => 'epacarvalhais.png',
            'website' => 'https://epacarvalhais.com/',
            'visible' => true
        ]);

        DB::table('partners')->insert([
            'name' => 'Orthos XXI',
            'logo' => 'orthosxxi.jpg',
            'website' => 'https://www.orthosxxi.com/',
            'visible' => true
        ]);

        DB::table('partners')->insert([
            'name' => 'Rogerio do Redondo',
            'slug' => 'rogerio-do-redondo',
            'logo' => 'rogerio-do-redondo.png',
            'website' => 'https://www.rogeriodoredondo.pt/',
            'visible' => true
        ]);

        DB::table('partners')->insert([
            'name' => 'Bicafé',
            'slug' => 'bicafe',
            'logo' => 'bicafe.png',
            'website' => 'https://bicafecapsulas.com/pt/',
            'visible' => true
        ]);

        // Take-away cantinho caseiro
        DB::table('partners')->insert([
            'name' => 'Take-Away Cantinho Caseiro',
            'slug' => 'cantinho-caseiro',
            'logo' => 'cantinho_caseiro.jpg',
            'website' => 'https://www.facebook.com/cantinho.caseiro.valbom/',
            'visible' => true
        ]);

        // Confeitaria Avenida
        DB::table('partners')->insert([
            'name' => 'Confeitaria Avenida',
            'slug' => 'confeitaria-avenida',
            'logo' => 'confeitaria_avenida.png',
            'website' => 'https://www.confeitariaavenida.pt/index.php/pt/',
            'visible' => true
        ]);

        // ATPorto
        DB::table('partners')->insert([
            'name' => 'ATPorto',
            'slug' => 'atporto',
            'logo' => 'atporto.png',
            'website' => 'https://www.facebook.com/atporto.dmc',
            'visible' => true
        ]);

        DB::table('partners')->insert([
            'name' => 'Feito à Mão para Doar',
            'logo' => 'feito_mao.jpg',
            'slug' => 'feito-a-mao',
            'website' => 'https://www.facebook.com/feitoamao.paradoar',
            'visible' => true
        ]);

        DB::table('partners')->insert([
            'name' => 'Pé no Mar',
            'slug' => 'penomar',
            'logo' => 'penomar.jpeg',
            'website' => 'https://penomar.pt/',
            'visible' => true
        ]);

        DB::table('partners')->insert([
            'name' => 'Cegonha - Bando de Criação',
            'slug' => 'cegonha',
            'logo' => 'cegonha.jpeg',
            'website' => 'https://www.facebook.com/cegonhabando/',
            'visible' => false
        ]);

        DB::table('partners')->insert([
            'name' => 'Minimercado Cunha',
            'slug' => 'minimercado-cunha',
            'logo' => 'minimercado_cunha.jpeg',
            'website' => 'https://minimercado-cunha.negocio.site/',
            'visible' => true
        ]);

        DB::table('partners')->insert([
            'name' => 'Cabeleireiro Teresa Moreira',
            'slug' => 'cabeleireiro-teresa-moreira',
            'logo' => 'cabeleireiro_teresa_moreira.png',
            'website' => 'https://www.facebook.com/profile.php?id=100063882832570',
            'visible' => true
        ]);

        DB::table('partners')->insert([
            'name' => 'Quinta do Pedregal Hotel & SPA',
            'slug' => 'pedregal-hotel',
            'logo' => 'pedregal-hotel.jpeg',
            'website' => 'https://quintadopedregal.pt/',
            'visible' => true
        ]);

        DB::table('partners')->insert([
            'name' => 'A Lareira',
            'slug' => 'a-lareira',
            'logo' => 'a_lareira.png',
            'website' => 'https://www.facebook.com/restaurantecafelareira/',
            'visible' => true
        ]);

        DB::table('partners')->insert([
            'name' => 'Papelaria Juvenil',
            'slug' => 'juvenil',
            'logo' => 'juvenil.png',
            'website' => 'https://www.facebook.com/papelarialivrariajuvenil',
            'visible' => true
        ]);

        DB::table('partners')->insert([
            'name' => 'Padaria Costa Capelo',
            'slug' => 'costa-capelo',
            'logo' => 'costa_capelo.jpeg',
            'website' => 'https://www.facebook.com/p/Padaria-Costa-Capela-100054571473975/?locale=pt_PT',
            'visible' => true
        ]);

        DB::table('partners')->insert([
            'name' => 'Cafetaria Cidade Jardim',
            'slug' => 'cidade-jardim',
            'logo' => 'jardim-confeitaria.jpeg',
            'website' => 'https://www.instagram.com/jardimcafeteria/?hl=pt',
            'visible' => true
        ]);

        DB::table('partners')->insert([
            'name' => 'Talho Popular',
            'slug' => 'talho-popular',
            'logo' => 'talho_popular.jpg',
            'website' => 'https://www.facebook.com/talhopopular1',
            'visible' => true
        ]);

        // Persono
        DB::table('partners')->insert([
            'name' => 'Persono',
            'slug' => 'persono',
            'logo' => 'persono.jpg',
            'website' => 'https://www.persono.pt/',
            'visible' => true
        ]);

        DB::table('partners')->insert([
            'name' => 'Portus Vector LDA',
            'slug' => 'portus-vector',
            'logo' => 'portus_vector.jpg',
            'website' => 'https://www.facebook.com/people/Portus-Vector-LDA/100063305793213/',
            'visible' => true
        ]);

    }
}
