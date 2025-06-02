<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form" class="modal-content" autocomplete="off">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Assunto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="subjectId">
                <div class="mb-3">
                    <label for="subjectDescription" class="form-label">Descrição</label>
                    <input type="text" class="form-control" id="subjectDescription" name="description" required maxlength="40">
                    <div class="invalid-feedback">A descrição é obrigatória e deve ter no máximo 40 caracteres.</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>
