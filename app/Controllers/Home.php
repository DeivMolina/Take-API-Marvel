<?php

namespace App\Controllers;

use App\Libraries\MarvelApiWrapper;
use App\Models\CharacterModel;

// En el controlador Home manejare todas las interacciones del programa, como solo ocupe una vista me facilita poder trabajarlo
class Home extends BaseController
{
    protected $api; // Instancia que agarro de la librería MarvelApiWrapper
    protected $characterModel; // Instancia del modelo CharacterModel

    // Inicializo las instancias de MarvelApiWrapper y CharacterModel
    public function __construct()
    {
        $this->api = new MarvelApiWrapper();
        $this->characterModel = new CharacterModel();
    }

    // Método para mostrar la lista de personajes en la vista principal
    public function index()
    {
        $perPage = 10; // Número de personajes por página para no abrumar al usuario con tanta informaciòn.
        $data['characters'] = $this->characterModel->paginate($perPage);
        $data['pager'] = $this->characterModel->pager;
        return view('home', $data);
    }

    // Método para obtener personajes de la API y almacenarlos en la base de datos
    public function fetchFromApi()
    {
        $maxTries = 10; // Máximo número de intentos para evitar duplicados
        $charactersToFetch = 5; // Número de personajes a obtener (Esta variable fue provicional para una funcion de un boton donde traia a 5 personajes de la API, para irlos almacenando en mi base de datos, decidi colocar 5 ya que la carga de los mismo era bastante.)
        $fetchedCount = 0;

        $results = [];
        $allCharacters = $this->api->characters(); // Obtiene todos los personajes de la API
        shuffle($allCharacters); // Mezclar para obtener personajes aleatorios para que no siguiera el mismo orden como el de la API

        while ($fetchedCount < $charactersToFetch && $maxTries > 0) {
            foreach ($allCharacters as $character) {
                if ($fetchedCount >= $charactersToFetch) {
                    break;
                }
                //Aquì realizo otro ciclo identico al de la Libreria, ya que a pesar de que logre consultar la URL de la imagen, no lograba insertarla en mi base de Datos, por lo tanto para no dejar vacia la celda, coloque una variable, con una URL default, para que cuando no se encontrara la imagen colocara esa misma. (A pesar de que en la API si se ecuentra, no logre que se registrara en mi base de datos.)
                $thumbnail_url = '';
                $default_thumbnail_url = 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available.jpg';

                // Verificar y construir la URL del thumbnail y si no existe colocar $default_thumbnail_url
                if (isset($character['thumbnail']) && is_array($character['thumbnail'])) {
                    $path = $character['thumbnail']['path'] ?? '';
                    $extension = $character['thumbnail']['extension'] ?? '';
                    if ($path && $extension) {
                        $thumbnail_url = $path . '.' . $extension;
                    } else {
                        $thumbnail_url = $default_thumbnail_url;
                    }
                } else {
                    $thumbnail_url = $default_thumbnail_url;
                }

                // Preparar los datos del personaje para almacenar en la base de datos
                $data = [
                    'id' => $character['id'],
                    'name' => $character['name'],
                    'description' => $character['description'] ?? '',
                    'thumbnail_url' => $thumbnail_url,
                    'resourceURI' => $character['resourceURI'] ?? '',
                    'modified' => $character['modified'] ?? '',
                ];

                // Verificar si el personaje ya existe, de lo contrario, inserta un nuevo personaje.
                $existingCharacter = $this->characterModel->find($data['id']);
                if (!$existingCharacter) {
                    $this->characterModel->insert($data); // Insertar nuevo personaje
                    $fetchedCount++;
                }

                $maxTries--;
            }
        }

        log_message('info', 'Proceso de fetchFromApi completado. Personajes generados: ' . $fetchedCount);

        // Devolver todos los personajes actualizados como respuesta JSON para poder verificar todos los personajes agregado, asi como sus objetos principales y secundarios.
        $characters = $this->characterModel->findAll();
        return $this->response->setJSON(['characters' => $this->characterModel->findAll()]);
    }

    // Método para añadir un nuevo personaje
    public function create()
    {
        $name = $this->request->getPost('name');
        $description = $this->request->getPost('description');

        // Validación de entrada: solo permito ciertos caracteres, en los formularios que eh observado en distintas web's ignoran este detalle importante, puede ser pequeño, pero es un pequeño filtro de evitar pishing. (La mayoria de formularios que eh trabajado, van a correo electronico, y con campos asi eh reducido bastante espam y ataque de pishing)
        if (!preg_match('/^[a-zA-Z0-9\s\(\)\-]+$/', $name)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Nombre inválido.']);
        }

        if (!preg_match('/^[a-zA-Z0-9\s\.\,\-\!\?]+$/', $description)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Descripción inválida.']);
        }

        // Datos del nuevo personaje
        $data = [
            'id' => random_int(1000000, 9999999), // ID generado aleatoriamente para no mantenerlo en un AI
            'name' => $name,
            'description' => $description,
            'thumbnail_url' => 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available.jpg', // Imagen por defecto
            'modified' => date('Y-m-d H:i:s'), // Fecha de modificación actual
        ];

        $this->characterModel->insert($data);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Personaje añadido con éxito.']);
    }

    // Método para ver los detalles de un personaje
    public function view($id)
    {
        $character = $this->characterModel->find($id);
        if (!$character) {
            return $this->response->setJSON(['character' => null]);
        }
        return $this->response->setJSON(['character' => $character]);
    }

    // Método para actualizar un personaje
    public function update()
    {
        $id = $this->request->getPost('id');
        $character = $this->characterModel->find($id);

        if ($character) {
            // Solo actualizar si el personaje existe, ya que hago una consulta si el ID se encuentra. 
            //Solo permito modificar dos campos el nombre y descripcion, ya que la Imagen por el momento seria algo mas complejo.
            $data = [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
                'modified' => date('Y-m-d H:i:s'), // Fecha de modificación actual
            ];

            // Actualizar el personaje en la base de datos
            $this->characterModel->update($id, $data);

            // Responder con un mensaje de éxito
            return $this->response->setJSON(['status' => 'success']);
        } else {
            // Si no se encuentra el personaje, responder con un error
            return $this->response->setJSON(['status' => 'error', 'message' => 'Character not found.']);
        }
    }

    // Método para eliminar un personaje
    public function delete($id)
    {
        $character = $this->characterModel->find($id);
        //Se colocaron alertas sencillas solo para notificar al usuario 
        if ($character) {
            $this->characterModel->delete($id);
            return $this->response->setJSON(['status' => 'success', 'message' => 'Personaje eliminado con Exito.', 'id' => $id]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Personaje no encontrado.']);
        }
    }

    // Método para buscar personajes
    public function search()
    {
        $query = $this->request->getPost('query');

        // Búsqueda en ID, nombre y descripción para ser la busqueda mas exacta
        $characters = $this->characterModel
            ->like('id', $query)
            ->orLike('name', $query)
            ->orLike('description', $query)
            ->findAll();

        return $this->response->setJSON(['status' => 'success', 'characters' => $characters]);
    }
}
