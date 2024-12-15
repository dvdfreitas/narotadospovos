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
    }
}
