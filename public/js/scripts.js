//Aqui se encuentran los scripts para las petciones AJAX, decidi hacerlo asì ya que como deseaba que fuena modales y se cargaran en tiempoReal, es el unico metodo que no me ah presentado tantas fallas, y asi me evito hacer diversas vistas, y tarto de dar una buena experencia de usuario
document.addEventListener('DOMContentLoaded', () => {
    // Funcionalidad para ver detalles de un personaje
    document.querySelectorAll('.view-character').forEach(button => {
        button.addEventListener('click', event => {
            event.preventDefault();
            const characterId = event.currentTarget.getAttribute('data-id');
            
            fetch('home/view/' + characterId)
                .then(response => response.json())
                .then(data => {
                    if (data.character) {
                        document.getElementById('modal-id').innerText = data.character.id;
                        document.getElementById('modal-name').innerText = data.character.name;
                        document.getElementById('modal-description').innerText = data.character.description || 'It is unknown from which universe this character is.';
                        document.getElementById('modal-thumbnail').src = data.character.thumbnail_url;
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });

    // Funcionalidad para editar un personaje
    document.querySelectorAll('.edit-character').forEach(button => {
        button.addEventListener('click', event => {
            event.preventDefault();
            const characterId = event.currentTarget.getAttribute('data-id');
            
            fetch('home/view/' + characterId)
                .then(response => response.json())
                .then(data => {
                    if (data.character) {
                        document.getElementById('edit-id').value = data.character.id;
                        document.getElementById('edit-name').value = data.character.name;
                        document.getElementById('edit-description').value = data.character.description;
                    } else {
                        console.error('Character not found.');
                    }
                })
                .catch(error => console.error('Error fetching character data:', error));
        });
    });

    // Envío del formulario de edición
    document.getElementById('edit-character-form').addEventListener('submit', function(event) {
        event.preventDefault();
        
        const formData = new FormData(this);
        fetch('home/update', {
            method: 'POST',
            body: new URLSearchParams(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                location.reload();
            } else {
                console.error('Error updating character:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Funcionalidad para eliminar un personaje
    document.querySelectorAll('.delete-character').forEach(button => {
        button.addEventListener('click', event => {
            event.preventDefault();
            const characterId = event.currentTarget.getAttribute('data-id');
            const confirmation = confirm('¿Estás seguro de que deseas eliminar este personaje? Esta acción es irreversible.');
            if (confirmation) {
                fetch('home/delete/' + characterId, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert('Personaje con ID ' + characterId + ' eliminado con éxito.');
                        location.reload();
                    } else {
                        alert('Error al eliminar el personaje: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    });

    // Envío del formulario de añadir personaje
    document.getElementById('add-character-form').addEventListener('submit', function(event) {
        event.preventDefault();
        
        const formData = new FormData(this);
        fetch('home/create', {
            method: 'POST',
            body: new URLSearchParams(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Personaje añadido con éxito.');
                location.reload();
            } else {
                alert('Error al añadir el personaje: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un error al añadir el personaje.');
        });
    });

    // Envío del formulario de búsqueda
    document.getElementById('search-form').addEventListener('submit', function(event) {
        event.preventDefault();
        
        const query = document.getElementById('search-query').value;
        const formData = new URLSearchParams({ query });

        fetch('home/search', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                updateCharacterTable(data.characters);
            } else {
                alert('Error al realizar la búsqueda.');
            }
        })
        .catch(error => console.error('Error:', error));
    });

    function updateCharacterTable(characters) {
        const tableBody = document.getElementById('character-table');
        tableBody.innerHTML = ''; // Limpiar la tabla

        if (characters.length > 0) {
            characters.forEach(character => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>
                        <img src="${character.thumbnail_url}" alt="${character.name}" style="width: 60px; height: 60px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);">
                    </td>
                    <td>${character.name}</td>
                    <td>${character.description || 'It is unknown from which universe this character is.'}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Acciones" style="gap:5px; border-radius:20px;">
                            <a href="ruta_a_ver/${character.id}" class="btn btn-info btn-sm">Ver</a>
                            <a href="ruta_a_editar/${character.id}" class="btn btn-warning btn-sm">Editar</a>
                            <a href="ruta_a_eliminar/${character.id}" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este personaje?');">Eliminar</a>
                        </div>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        } else {
            const row = document.createElement('tr');
            row.innerHTML = `<td colspan="4">No se encontraron personajes.</td>`;
            tableBody.appendChild(row);
        }
    }
});
