@extends('layouts.app')
@include('partials.modal-book')

@section('content')
<div class="container mt-1">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h3 class="mb-0">Livros</h3>
        <button class="btn btn-sm btn-secondary" onclick="openModal()">
            <i class="bi bi-plus-circle me-1"></i> Cadastrar
        </button>
    </div>
    <div id="table"></div>
</div>
@endsection

@push('scripts')
<!-- Grid.js -->
<link href="https://cdn.jsdelivr.net/npm/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/gridjs/dist/gridjs.umd.js"></script>
<!-- Tom Select -->
<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

<script type="module">
    import {
        formatDate,
        formatCurrency,
        setupModalFormReset
    } from "{{ asset('js/helper.js') }}";

    const modal = new bootstrap.Modal(document.getElementById('modal'));

    let currentAction = 'create';
    let grid = null;
    let authorSelect = null;
    let subjectSelect = null;

    function renderTable() {
        fetch('/api/v1/books')
            .then(res => res.json())
            .then(data => {
                const formattedData = data.map(book => [
                    book.id,
                    book.title,
                    book.publication_year,
                    formatCurrency(book.price),
                    book.authors.map(a => a.name).join(', '),
                    book.subjects.map(s => s.description).join(', '),
                    book
                ]);

                if (grid) {
                    grid.updateConfig({
                        data: formattedData
                    }).forceRender();
                } else {
                    grid = new gridjs.Grid({
                        columns: [
                            'ID', 'Título', 'Ano', 'Preço', 'Autores', 'Assuntos',
                            {
                                name: 'Ações',
                                formatter: (_, row) => gridjs.html(`
                                    <div class="dropstart">
                                      <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                      </button>
                                      <ul class="dropdown-menu">
                                        <li>
                                          <a class="dropdown-item" href="#" onclick='openModal(${JSON.stringify(row.cells[6].data)})'>
                                            <i class="bi bi-pencil me-1"></i> Editar
                                          </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                          <a class="dropdown-item text-danger" href="#" onclick='delete(${row.cells[0].data})'>
                                            <i class="bi bi-trash me-1"></i> Deletar
                                          </a>
                                        </li>
                                      </ul>
                                    </div>
                                `)
                            }
                        ],
                        data: formattedData,
                        search: true,
                        sort: true,
                        pagination: {
                            enabled: true,
                            limit: 5
                        },
                        language: {
                            search: {
                                placeholder: 'Buscar...'
                            },
                            pagination: {
                                previous: 'Anterior',
                                next: 'Próximo',
                                showing: 'Mostrando',
                                results: () => 'resultados',
                                to: 'até',
                                of: 'de',
                                page: 'Página',
                                pages: 'Páginas'
                            }
                        }
                    }).render(document.getElementById('table'));
                }
            });
    }

    window.openModal = function(book = null) {
        currentAction = book ? 'edit' : 'create';
        document.getElementById('modalLabel').innerText = book ? 'Editar Livro' : 'Cadastrar Livro';
        document.getElementById('form').reset();

        document.getElementById('bookId').value = book?.id || '';
        document.getElementById('bookTitle').value = book?.title || '';
        document.getElementById('bookPublisher').value = book?.publisher || '';
        document.getElementById('bookYear').value = book?.publication_year || '';
        document.getElementById('bookEdition').value = book?.edition || '';
        document.getElementById('bookPrice').value = book?.price || '';

        if (authorSelect && subjectSelect) {
            authorSelect.clear(true);
            subjectSelect.clear(true);
        }

        fetch('/api/v1/authors')
            .then(res => res.json())
            .then(authors => {
                authorSelect = new TomSelect("#bookAuthors", {
                    options: authors.map(a => ({
                        value: a.id,
                        text: a.name
                    })),
                    maxItems: null,
                    plugins: ['remove_button']
                });

                if (book) {
                    book.authors.forEach(a => authorSelect.addItem(a.id));
                }
            });

        fetch('/api/v1/subjects')
            .then(res => res.json())
            .then(subjects => {
                subjectSelect = new TomSelect("#bookSubjects", {
                    options: subjects.map(s => ({
                        value: s.id,
                        text: s.description
                    })),
                    maxItems: null,
                    plugins: ['remove_button']
                });

                if (book) {
                    book.subjects.forEach(s => subjectSelect.addItem(s.id));
                }
            });

        modal.show();
    }

    window.delete = function(id) {
        Swal.fire({
            title: 'Tem certeza?',
            text: 'Isso não poderá ser desfeito!',
            icon: 'question',
            reverseButtons: true,
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar'
        }).then(result => {
            if (result.isConfirmed) {
                fetch(`/api/v1/books/${id}`, {
                        method: 'DELETE'
                    })
                    .then(() => {
                        Swal.fire('Deletado!', 'O livro foi removido.', 'success');
                        renderTable();
                    });
            }
        });
    }

    document.getElementById('form').addEventListener('submit', function(e) {
        e.preventDefault();

        const id = document.getElementById('bookId').value;
        const data = {
            title: document.getElementById('bookTitle').value,
            publisher: document.getElementById('bookPublisher').value,
            publication_year: document.getElementById('bookYear').value,
            edition: document.getElementById('bookEdition').value,
            price: parseFloat(document.getElementById('bookPrice').value),
            authors: authorSelect.getValue(),
            subjects: subjectSelect.getValue()
        };

        if (isNaN(data.price) || data.publication_year.length !== 4) {
            Swal.fire('Erro', 'Verifique os campos de preço e ano de publicação.', 'error');
            return;
        }

        const url = id ? `/api/v1/books/${id}` : '/api/v1/books';
        const method = id ? 'PUT' : 'POST';

        fetch(url, {
            method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(async res => {
            if (!res.ok) {
                const msg = await res.json();
                Swal.fire('Erro', msg.message || 'Erro ao salvar.', 'error');
                return;
            }

            modal.hide();
            renderTable();
            Swal.fire('Sucesso!', 'Livro salvo com sucesso.', 'success');
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        renderTable();
        setupModalFormReset();
    });
</script>
@endpush
