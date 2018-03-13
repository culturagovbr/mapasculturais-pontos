<?php

use MapasCulturais\Entities\Space;
use MapasCulturais\Types\GeoPoint;

$app = MapasCulturais\App::i();

return [
    'saas_pontos: import initial data' => function() use($app) {

        echo "Starting importing spaces\n";

        $csv_file = fopen(__DIR__ . '/imports/pontos_de_memoria.csv', 'r');

        $imported = 0;

        $owner = $app->repo('Agent')->find($app->config['pontos.ownerAgentId']);

        while (($row = fgetcsv($csv_file)) !== FALSE) {

            // [0]  => PONTO DE MEMÓRIA
            // [1]  => Área de Atuação Descrição
            // [2]  => Descrição
            // [3]  => Município
            // [4]  => UF
            // [5]  => Responsável
            // [6]  => E-mail
            // [7]  => Telefone
            // [8]  => Endereço
            // [9]  => LATITUDE
            // [10] => LONGITUDE

            $space = new Space;
            // tipo "Pontos de Memória"
            $space->type = 136;
            $space->subsite = $app->repo('Subsite')->find($app->config['pontos.subsiteId']);
            $space->name = $row[0];
            $space->terms['area'] = explode(';', $row[1]);
            $space->shortDescription = $row[2];
            $space->En_Municipio = $row[3];
            $space->En_Estado = $row[4];
            $space->owner = $owner;
            $space->emailPublico = $row[6];

            $phones = explode(' ', $row[7]);
            // echo "aqui\n";
            // echo json_encode($phones);
            // echo "fimaqui\n";
            $space->telefonePublico = $phones[0];
            $space->telefone1 = $phones[1];
            $space->telefone2 = $phones[2];


            $space->endereco = $row[8];

            $space->location = new GeoPoint(floatval($row[10]), floatval($row[9]));

            $space->save(true);
            $imported++;
        }

        echo "Imported $imported spaces\n";

        fclose($csv_file);

    }
];
