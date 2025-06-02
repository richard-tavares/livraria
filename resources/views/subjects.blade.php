@extends('layouts.app')
@include('partials.modal-subject')

@section('content')
<div class="container mt-1">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h3 class="mb-0">Assuntos</h3>
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

<script type="module">
    import {
        formatDate,
        setupModalFormReset
    } from "{{ asset('js/helper.js') }}";

    const modal = new bootstrap.Modal(document.getElementById('modal'));
    let currentAction = 'create';
    let grid = null;

    function renderTable() {
        fetch('/api/v1/subjects')
            .then(res => res.json())
            .then(data => {
                const formattedData = data.map(a => [
                    a.id,
                    a.description,
                    formatDate(a.created_at),
                    formatDate(a.updated_at),
                    a
                ]);

                if (grid) {
                    grid.updateConfig({
                        data: formattedData
                    }).forceRender();
                } else {
                    grid = new gridjs.Grid({
                        columns: [
                            'ID',
                            'Descrição',
                            'Criado em',
                            'Atualizado em',
                            {
                                name: 'Ações',
                                formatter: (_, row) => gridjs.html(`
                                    <div class="dropstart">
                                      <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                      </button>
                                      <ul class="dropdown-menu">
                                        <li>
                                          <a class="dropdown-item" href="#" onclick='openModal(${JSON.stringify(row.cells[4].data)})'>
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

    window.openModal = function(subject = null) {
        if (subject) {
            currentAction = 'edit';
            document.getElementById('modalLabel').innerText = 'Editar Assunto';
            document.getElementById('subjectId').value = subject.id;
            document.getElementById('subjectDescription').value = subject.description;
        } else {
            currentAction = 'create';
            document.getElementById('modalLabel').innerText = 'Cadastrar Assunto';
            document.getElementById('form').reset();
            document.getElementById('subjectId').value = '';
        }
        modal.show();
    }

    window.delete = function(id) {
        Swal.fire({
            title: 'Tem certeza?',
            text: 'Isso não poderá ser desfeito!',
            icon: 'warning',
            reverseButtons: true,
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar'
        }).then(result => {
            if (result.isConfirmed) {
                fetch(`/api/v1/subjects/${id}`, {
                        method: 'DELETE'
                    })
                    .then(() => {
                        Swal.fire('Deletado!', 'O assunto foi removido.', 'success');
                        renderTable();
                    });
            }
        });
    }

    document.getElementById('form').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('subjectId').value;
        const description = document.getElementById('subjectDescription').value;
        const url = id ? `/api/v1/subjects/${id}` : '/api/v1/subjects';
        const method = id ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                description
            })
        }).then(async res => {
            if (!res.ok) {
                const data = await res.json();
                Swal.fire('Erro', data.message || 'Erro ao salvar', 'error');
                return;
            }
            modal.hide();
            renderTable();
            Swal.fire('Sucesso!', 'Assunto salvo com sucesso.', 'success');
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        renderTable();
        setupModalFormReset();
    });
</script>
@endpush
