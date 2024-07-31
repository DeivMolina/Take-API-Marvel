<?php

namespace App\Models;

use CodeIgniter\Model;

class CharacterModel extends Model
{
    protected $table = 'characters';  // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id';     // Clave primaria de la tabla
    protected $allowedFields = [ // Nombre de las columnas de la Base de Datos, mismos nombre que la API para no perderme en los controladores.
        'id', 'name', 'description', 'thumbnail_url',
        'resourceURI', 'modified'
    ];
    protected $paginate = 10;  // Número de elementos por página para la paginación

    /**
     * Método para insertar o actualizar un personaje.
     * 
     * @param array $data Datos del personaje.
     * @return bool|int ID del registro insertado o actualizado, o false en caso de error.
     */
    public function insertOrUpdate(array $data)
    {
        try {
            // Verificar si el personaje ya existe en la base de datos
            $existingCharacter = $this->find($data['id']);
            if ($existingCharacter) {
                // Si el personaje existe, actualizar los datos
                $result = $this->update($data['id'], $data);
            } else {
                // Si el personaje no existe, insertarlo como nuevo registro
                $result = $this->insert($data);
            }

            // Manejo de errores en caso de que cualquier operación falle
            if ($result === false) {
                log_message('error', 'Error inserting/updating character: ' . json_encode($data));
            }

            return $result;
        } catch (\Exception $e) {
            // Registro de cualquier excepción que ocurra durante el proceso
            log_message('error', 'Exception in insertOrUpdate: ' . $e->getMessage());
            return false;
        }
    }
}
