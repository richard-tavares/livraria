@extends('layouts.app')

@section('content')
<div class="container mt-1">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h3 class="mb-0">Dashboard</h3>
    </div>
    <div class="row g-2 mb-2">
        <div class="col-md-3">
            <label for="filterAuthors" class="form-label">Autores</label>
            <select id="filterAuthors" class="form-select" multiple></select>
        </div>
        <div class="col-md-3">
            <label for="filterSubjects" class="form-label">Assuntos</label>
            <select id="filterSubjects" class="form-select" multiple></select>
        </div>
        <div class="col-md-3">
            <label for="filterPublishers" class="form-label">Editoras</label>
            <select id="filterPublishers" class="form-select" multiple></select>
        </div>
        <div class="col-md-3">
            <label for="filterYears" class="form-label">Ano de Publicação</label>
            <select id="filterYears" class="form-select" multiple></select>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-4 mb-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Livros por Autor</h5>
                    <canvas id="booksByAuthorChart" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-4 mb-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Livros por Editora</h5>
                    <canvas id="booksByPublisherChart" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-4 mb-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Livros por Ano de Publicação</h5>
                    <canvas id="booksByYearChart" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Livros por Preço</h5>
                    <canvas id="booksByPriceChart" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Livros por Assunto</h5>
                    <div class="d-flex justify-content-center align-items-center">
                        <canvas id="booksBySubjectChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
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
<!-- Charts.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

<script>
    const chartInstances = {};
    let grid = null;

    const selects = {
        authors: new TomSelect('#filterAuthors', {
            plugins: ['remove_button'],
            maxItems: null
        }),
        subjects: new TomSelect('#filterSubjects', {
            plugins: ['remove_button'],
            maxItems: null
        }),
        publishers: new TomSelect('#filterPublishers', {
            plugins: ['remove_button'],
            maxItems: null
        }),
        years: new TomSelect('#filterYears', {
            plugins: ['remove_button'],
            maxItems: null
        })
    };

    function getFiltersQuery() {
        return new URLSearchParams({
            authors: selects.authors.getValue().join(','),
            subjects: selects.subjects.getValue().join(','),
            publishers: selects.publishers.getValue().join(','),
            years: selects.years.getValue().join(',')
        }).toString();
    }

    function renderChart({
        id,
        type,
        labels,
        datasetLabel,
        data,
        backgroundColor,
        indexAxis = 'x',
        formatter = Math.round
    }) {
        const canvas = document.getElementById(id);
        const ctx = canvas.getContext('2d');

        if (chartInstances[id]) {
            chartInstances[id].destroy();
        }

        if (type === 'doughnut') {
            canvas.height = 400;
        }

        chartInstances[id] = new Chart(ctx, {
            type,
            data: {
                labels,
                datasets: [{
                    label: datasetLabel,
                    data,
                    backgroundColor,
                    borderColor: backgroundColor,
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis,
                responsive: true,
                maintainAspectRatio: type !== 'doughnut',
                plugins: {
                    legend: {
                        display: type === 'doughnut',
                        position: type === 'doughnut' ? 'bottom' : 'top'
                    },
                    tooltip: {
                        enabled: true
                    },
                    datalabels: {
                        anchor: 'center',
                        align: 'center',
                        font: {
                            weight: 'bold'
                        },
                        formatter
                    }
                },
                scales: type !== 'doughnut' ? {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                } : {}
            },
            plugins: [ChartDataLabels]
        });
    }

    function loadFilters() {
        fetch('/api/v1/data')
            .then(res => res.json())
            .then(({
                filters
            }) => {
                for (const key in selects) {
                    selects[key].clearOptions();
                    filters[key].forEach(val => selects[key].addOption({
                        value: val,
                        text: val
                    }));
                }
            });
    }

    function loadTable() {
        fetch(`/api/v1/data?${getFiltersQuery()}`)
            .then(res => res.json())
            .then(({
                books
            }) => {
                const data = books.map(book => [
                    book.title, book.author, book.subject, book.publisher, book.publication_year
                ]);

                if (grid) {
                    grid.updateConfig({
                        data
                    }).forceRender();
                } else {
                    grid = new gridjs.Grid({
                        columns: ['Título', 'Autor', 'Assunto', 'Editora', 'Ano'],
                        data,
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

    function loadCharts() {
        const query = getFiltersQuery();

        fetch(`/api/v1/books-by-author?${query}`)
            .then(res => res.json())
            .then(data => renderChart({
                id: 'booksByAuthorChart',
                type: 'bar',
                labels: data.map(i => i.author),
                datasetLabel: 'Quantidade de livros',
                data: data.map(i => i.total),
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                indexAxis: 'y',
                formatter: Math.round
            }));

        fetch(`/api/v1/books-by-publisher?${query}`)
            .then(res => res.json())
            .then(data => renderChart({
                id: 'booksByPublisherChart',
                type: 'bar',
                labels: data.map(i => i.publisher),
                datasetLabel: 'Quantidade de livros',
                data: data.map(i => i.total),
                backgroundColor: 'rgba(255, 206, 86, 0.6)',
                indexAxis: 'y',
                formatter: Math.round
            }));

        fetch(`/api/v1/books-by-year?${query}`)
            .then(res => res.json())
            .then(data => renderChart({
                id: 'booksByYearChart',
                type: 'bar',
                labels: data.map(i => i.publication_year),
                datasetLabel: 'Quantidade de livros',
                data: data.map(i => i.total),
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                formatter: Math.round
            }));

        fetch(`/api/v1/books-by-price?${query}`)
            .then(res => res.json())
            .then(data => renderChart({
                id: 'booksByPriceChart',
                type: 'bar',
                labels: data.map(i => i.title),
                datasetLabel: 'Preço (R$)',
                data: data.map(i => i.price),
                backgroundColor: 'rgba(255, 159, 64, 0.6)',
                indexAxis: 'y',
                formatter: value => new Intl.NumberFormat('pt-BR', {
                    style: 'currency',
                    currency: 'BRL'
                }).format(parseFloat(value))
            }));

        fetch(`/api/v1/books-by-subject?${query}`)
            .then(res => res.json())
            .then(data => renderChart({
                id: 'booksBySubjectChart',
                type: 'doughnut',
                labels: data.map(i => i.subject),
                datasetLabel: 'Quantidade de livros',
                data: data.map(i => i.total),
                backgroundColor: [
                    '#007bff', '#6610f2', '#6f42c1', '#e83e8c',
                    '#dc3545', '#fd7e14', '#ffc107', '#28a745',
                    '#20c997', '#17a2b8', '#6c757d'
                ],
                formatter: val => `${val}`
            }));
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadFilters();
        loadTable();
        loadCharts();

        Object.values(selects).forEach(select => select.on('change', () => {
            loadTable();
            loadCharts();
        }));
    });
</script>
@endpush
