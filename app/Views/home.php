<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marvel Characters</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('css/styles.css') ?>" rel="stylesheet"> <!-- Enlace al archivo CSS -->
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Personajes Marvel</h1>
        <form id="search-form">
            <input type="text" id="search-query" name="query" placeholder="Buscar personajes por ID, nombre o descripción..." style="padding: 5px;">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addCharacterModal">Añadir Personaje</button>

    </div>

    <div id="message"></div>

    <?php if (!empty($characters)): ?>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th colspan="2">Personaje</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="character-table">
                <?php foreach ($characters as $character): ?>
                    <tr>
                        <td>
                            <?php if (!empty($character['thumbnail_url'])): ?>
                                <img src="<?= $character['thumbnail_url'] ?>" alt="<?= $character['name'] ?>" style="width: 60px; height: 60px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);">
                            <?php endif; ?>
                        </td>
                        <td><?= $character['name'] ?></td>
                        <td><?= $character['description'] ?: 'It is unknown from which universe this character is.' ?></td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Acciones" style="gap:5px; border-radius:20px;">
                                <a href="#" class="btn btn-info btn-sm view-character" data-id="<?= $character['id'] ?>" data-bs-toggle="modal" data-bs-target="#characterModal">Ver</a>
                                <a href="#" class="btn btn-warning btn-sm edit-character" data-id="<?= $character['id'] ?>" data-bs-toggle="modal" data-bs-target="#editCharacterModal">Editar</a>
                                <a href="#" class="btn btn-danger btn-sm delete-character" data-id="<?= $character['id'] ?>">Eliminar</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">No se encontraron personajes con la consulta "<?= esc($query ?? '') ?>"</div>
    <?php endif; ?>

    <!-- Paginación -->
    <div class="d-flex justify-content-center">
        <?= $pager->links() ?>
    </div>
</div>

<!-- Modal de Vista -->
<div class="modal fade" id="characterModal" tabindex="-1" aria-labelledby="characterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered"> <!-- Clase para centrar el modal -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="characterModalLabel">Detalles del Personaje</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body d-flex">
        <div class="flex-shrink-0 me-3">
          <img id="modal-thumbnail" src="" alt="Imagen del Personaje" style="width: 150px; height: 150px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);">
        </div>
        <div>
          <p><strong>ID:</strong> <span id="modal-id"></span></p>
          <p><strong>Nombre:</strong> <span id="modal-name"></span></p>
          <p><strong>Descripción:</strong> <span id="modal-description"></span></p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal de Edición -->
<div class="modal fade" id="editCharacterModal" tabindex="-1" aria-labelledby="editCharacterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editCharacterModalLabel">Editar Personaje</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="edit-character-form">
        <div class="modal-body">
          <input type="hidden" id="edit-id" name="id">
          <div class="mb-3">
            <label for="edit-name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="edit-name" name="name" required>
          </div>
          <div class="mb-3">
            <label for="edit-description" class="form-label">Descripción</label>
            <textarea class="form-control" id="edit-description" name="description" rows="3" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal para Añadir Personaje -->
<div class="modal fade" id="addCharacterModal" tabindex="-1" aria-labelledby="addCharacterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCharacterModalLabel">Añadir Personaje</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="add-character-form">
        <div class="modal-body d-flex">
          <div class="flex-grow-1 me-3">
            <div class="mb-3">
              <label for="add-id" class="form-label">ID</label>
              <input type="text" class="form-control" id="add-id" name="id" readonly value="<?= random_int(1000000, 9999999) ?>">
            </div>
            <div class="mb-3">
              <label for="add-name" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="add-name" name="name" required>
            </div>
            <div class="mb-3">
              <label for="add-description" class="form-label">Descripción</label>
              <textarea class="form-control" id="add-description" name="description" rows="3" required></textarea>
            </div>
          </div>
          <div class="flex-shrink-0">
            <img id="default-thumbnail" src="http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available.jpg" alt="Imagen por defecto" style="width: 150px; height: 150px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Añadir Personaje</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="<?= base_url('js/scripts.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
