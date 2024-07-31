<?php

namespace App\Libraries;

use CodeIgniter\HTTP\CURLRequest;
use Config\Services;
use CodeIgniter\I18n\Time;
use Config\MarvelApi;

// Clase que interactúa con la API de Marvel
class MarvelApiWrapper {
    protected $curl;  // Cliente HTTP para enviar solicitudes
    protected $ts;    // Marca de tiempo para autenticación de API
    protected $hash;  // Hash de autenticación para la API

    // Constructor: inicializa las propiedades y verifica las claves de API
    public function __construct()
    {
        //Tomo en cuenta la URL que me proporciona la API
        $this->curl = Services::curlrequest(['baseURI' => 'https://gateway.marvel.com:443/v1/public/']);
        $this->ts = Time::now()->getTimestamp();

        // Cargar configuración de la API
        $config = config(MarvelApi::class);

        if (empty($config->privateKey) || empty($config->publicKey)) {
            throw new \RuntimeException('API keys are not set in the configuration.');
        }

        // Generar hash para autenticación, en la documentacion indicaba que iba con todo en un hash md5, donde va el timeStamp, PrivKey y PublicKey
        $this->hash = hash('md5', $this->ts . $config->privateKey . $config->publicKey);
    }

    // Método para obtener personajes de la API de Marvel
    public function characters()
    {
        $config = config(MarvelApi::class);
    
        // Configurar parámetros para la solicitud de lo contrario soy acredor a un error 409
        $params = [
            'ts' => $this->ts,
            'apikey' => $config->publicKey,
            'hash' => $this->hash,
        ];
    
        // Crear la URL de la solicitud con los parámetros
        $query = http_build_query($params);
    
        // Realizar la solicitud GET a la API
        $result = $this->curl->get('characters?' . $query);
        if ($result->getStatusCode() !== 200) {
            echo "Error: " . $result->getStatusCode() . " - " . $result->getBody();
            exit;
        }
    
        // Decodificar la respuesta JSON
        $json_body = json_decode($result->getBody(), true);
        $results = $json_body['data']['results'];
        $characters = [];
    
        // Procesar cada personaje obtenido

        //En esta secciòn decido colocar un bucle para pader concatenar el array thumbnail que contiene como propiedades path y extension, mi intenciòn es poder concatenarlas en una variable $thumbnail_url de manera que al momento de almacenarlas, puediera verlas. (Me ahorro un paso)
        foreach ($results as $character) {
            $thumbnail_url = '';
            if (isset($character['thumbnail']) && is_array($character['thumbnail'])) {
                $path = $character['thumbnail']['path'] ?? '';
                $extension = $character['thumbnail']['extension'] ?? '';
                if ($path && $extension) {
                    $thumbnail_url = $path . '.' . $extension;
                }
            }
        
            // Almacenar datos del personaje en el array
            $characters[] = [
                'id' => $character['id'],
                'name' => $character['name'],
                'description' => $character['description'] ?? '',
                'thumbnail_url' => $thumbnail_url,
                'resourceURI' => $character['resourceURI'] ?? '',
                'modified' => $character['modified'] ?? '',
            ];
        }

        // Diagnóstico para mostrar datos procesados
        echo "<pre>";
        print_r($characters);
        echo "</pre>";
    
        return $characters;
    }
}
