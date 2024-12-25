<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Person::create([
            'name' => 'David Freitas',
            'username' => 'david_freitas',
            'email' => 'dvdfreitas@gmail.com',
            'phone' => '+351935566333'
        ]);

        Person::create([
            'name' => 'Susana Antunes',
            'username' => 'susana_antunes',
        ]);

        Person::create([
            'name' => 'Tito Baião',
            'username' => 'tito_baiao',
        ]);

        Person::create([
            'name' => 'Fernando Pinheio',
            'username' => 'fernando_pinheiro',
        ]);

        Person::create([
            'name' => 'Teresa Pinheiro',
            'username' => 'teresa_pinheiro',
        ]);

        Person::create([
            'name' => 'Octávio Coelho',
            'username' => 'octavio_coelho',
        ]);

        Person::create([
            'name' => 'Anabela Bandeira',
            'username' => 'anabela_bandeira',
        ]);

        Person::create([
            'name' => 'Ivone Vasco',
            'username' => 'ivone_vasco',
        ]);

        Person::create([
            'name' => 'Alcina',
            'username' => 'alcina',
        ]);

        Person::create([
            'name' => 'Vitor Carvalho',
            'username' => 'vitor_carvalho',
        ]);

        Person::create([
            'name' => 'Mário Gouveia',
            'username' => 'mario_gouveia',
        ]);

        Person::create([
            'name' => 'Constança Gouveia',
            'username' => 'constanca_gouveia',
        ]);

        Person::create([
            'name' => 'Ângelo Esteves',
            'username' => 'angelo_esteves',
        ]);

        Person::create([
            'name' => 'Ana Campos',
            'username' => 'ana_campos',
        ]);

        Person::create([
            'name' => 'Ana Coelho',
            'username' => 'ana_coelho',
        ]);

        Person::create([
            'name' => 'Beatriz Moreira',
            'username' => 'beatriz_moreira',
        ]);

        Person::create([
            'name' => 'Daniel Carvalho',
            'username' => 'daniel_carvalho',
        ]);

        Person::create([
            'name' => 'Diogo Queirós',
            'username' => 'diogo_queiros',
        ]);

        Person::create([
            'name' => 'Inês Pinto',
            'username' => 'ines_pinto',
        ]);

        Person::create([
            'name' => 'José Borges',
            'username' => 'jose_borges',
        ]);

        Person::create([
            'name' => 'Luana Carrola',
            'username' => 'luana_carrola',
        ]);

        Person::create([
            'name' => 'Luís Silva',
            'username' => 'luis_silva',
        ]);

        Person::create([
            'name' => 'Luísa Pinto',
            'username' => 'luisa_pinto',
        ]);

        Person::create([
            'name' => 'Mariana Moutinho',
            'username' => 'mariana_moutinho',
        ]);

        Person::create([
            'name' => 'Paulo Mendes',
            'username' => 'paulo_mendes',
        ]);

        Person::create([
            'name' => 'Pedro Paiva',
            'username' => 'pedro_paiva',
        ]);

        Person::create([
            'name' => 'Renato Santos',
            'username' => 'renato_santos',
        ]);

        Person::create([
            'name' => 'Rodrigo Faria',
            'username' => 'rodrigo_faria',
        ]);

        Person::create([
            'name' => 'Sérgio Fonseca',
            'username' => 'sergio_fonseca',
        ]);

        Person::create([
            'name' => 'Zita',
            'username' => 'zita',
        ]);

        Person::create([
            'name' => 'Sembé Djessi',
            'username' => 'sembe_djessi',
            'description' => 'Diretor da escola "Sembé Djessi"',
        ]);

        Person::create([
            'name' => 'Daniel Paulo Martins',
            'username' => 'daniel_paulo_martins',
            'description' => 'Formador do centro de informática',
        ]);

        // Estudantes Catió

        Person::create([
            'name' => 'Binta Silá',
            'phone' => '+351 930 540 442',
            'username' => 'binta_sila',
            'birth_date' => '2004-12-29',
            'description' => 'Em Catió estudava em no Centro educacional São Bento. Em Portugal é estudante de Técnico de cozinha e pastelaria na Escola profissional de agricultura (EPA) Carvalhais',
        ]);

        Person::create([
            'name' => 'Dino Nassalú',
            'username' => 'dino_nassalu',
            'phone' => '+351 929 247 751',
            'birth_date' => '2005-01-11',
            'description' => 'Escola profissional de agricultura e desenvolvimento rural.',
        ]);

        Person::create([
            'name' => 'Hedigar Cá',
            'username' => 'hedigar_ca',
            'birth_date' => '2004-11-11',
            'phone' => '+351 930 540 483',
            'description' => 'Na Guiné-Bissau, estudava no Liceu sectorial de Como. Em Portugal, EPA CARVALHAIS. estou a estudar vitivinicultura.',
        ]);

        Person::create([
            'name' => 'Sadú Baldé',
            'username' => 'sadu_balde',
            'birth_date' => '2005-02-12',
            'phone' => '+351 929 247 752',
            'description' => 'Na Guiné-Bissau, era estudante CANHE NAN TUNGUÊ. Em Portugal, estuda Turismo Ambiental e Rural na E.P.A. (Escola profissional de Agricultura) de Mirandela.  estudante Técnico de Informática de Gestão',
        ]);

        Person::create([
            'name' => 'Mariama Siré Djaló',
            'username' => 'mariama_sire_djalo',
            'birth_date' => '2003-09-20',
            'phone' => '+351 930 540 496',
            'description' => 'Estudante no curso Técnico de Apoio Familiar e de Apoio à Comunidade no Instituto do emprego e de formação profissional (IEFP) de Mirandela. Perdeu a mãe (Djenabu Culubali) com 15 anos por asma, e o pai (Braima Djaló) com 17 anos.',
        ]);

        Person::create([
            'name' => 'Olívio Na Teinha',
            'phone' => '+351 929 247 757',
            'username' => 'olivio_na_teinha',
            'birth_date' => '2003-08-19',
            'description' => 'Estuda curso de técnico de apoio familiar e a comunidade no Instituto do Emprego e Formação Profissional (IEFP) de Mirandela',
        ]);

        Person::create([
            'name' => 'Roberto Na Sanha',
            'username' => 'roberto_na_sanha',
            'phone' => '+351 930 540 454',
            'birth_date' => '2004-03-04',
            'description' => 'Estudante Técnico de Mecatrónica Automóvel',
        ]);

        Person::create([
            'name' => 'Tânia Na Massé',
            'username' => 'tania_na_masse',
            'phone' => '+351 920 405 633',
            'birth_date' => '2004-02-22',
            'description' => 'Na Guiné-Bissau, estudava no Liceu sectorial de Como. ',
        ]);

        Person::create([
            'name' => 'Titina Na Tchiba',
            'username' => 'titina_na_tchiba',
            'phone' => '+351 930 540 488',
            'birth_date' => '2001-09-05',
            'description' => 'Na Guiné-Bissau, estudava no Liceu regional Areolino cruz Catió. Estudante Técnico de Informática de Gestão',
        ]);



    }
}
