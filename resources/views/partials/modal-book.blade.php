<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="form" class="modal-content" autocomplete="off">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Livro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body row g-3">
                <input type="hidden" id="bookId">
                <div class="col-md-6">
                    <label for="bookTitle" class="form-label">Título</label>
                    <input type="text" class="form-control" id="bookTitle" required>
                </div>
                <div class="col-md-6">
                    <label for="bookPublisher" class="form-label">Editora</label>
                    <input type="text" class="form-control" id="bookPublisher" required>
                </div>
                <div class="col-md-4">
                    <label for="bookEdition" class="form-label">Edição</label>
                    <input type="number" class="form-control" id="bookEdition" min="1" required>
                </div>
                <div class="col-md-4">
                    <label for="bookYear" class="form-label">Ano de Publicação</label>
                    <input type="text" class="form-control" id="bookYear" maxlength="4" required>
                </div>
                <div class="col-md-4">
                    <label for="bookPrice" class="form-label">Preço</label>
                    <input type="number" class="form-control" id="bookPrice" min="0" step="0.01" required>
                </div>
                <div class="col-md-6">
                    <label for="bookAuthors" class="form-label">Autores</label>
                    <select id="bookAuthors" multiple required></select>
                </div>
                <div class="col-md-6">
                    <label for="bookSubjects" class="form-label">Assuntos</label>
                    <select id="bookSubjects" multiple required></select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>
