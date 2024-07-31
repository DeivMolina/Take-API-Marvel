<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class MarvelApi extends BaseConfig {
    public $publicKey;
    public $privateKey;

    public function __construct()
    {
        parent::__construct();
        
        // Cargar las claves desde las variables de entorno definidas en el archivo .env
        // Si no se encuentran, se usan valores por defecto
        $this->publicKey = getenv('marvelapi.publicKey') ?: 'defaultPublicKey';
        $this->privateKey = getenv('marvelapi.privateKey') ?: 'defaultPrivateKey';
    }
}

