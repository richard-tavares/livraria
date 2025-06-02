<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Livraria</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Richard Tavares - Desenvolvedor Full Stack">
    <meta name="description" content="Sistema de cadastro e consulta feito para o teste técnico.">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <header class="bg-dark fixed-top border-bottom">
        <nav class="navbar navbar-expand-lg navbar-dark container px-4">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.svg') }}" alt="Logo" height="40">
                <span class="fw-bold">Livraria</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto text-center text-white">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/authors') }}">Autores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/subjects') }}">Assuntos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/books') }}">Livros</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <main class="container-fluid flex-grow-1 pt-5 mt-4">
        @yield('content')
    </main>
    <footer class="text-muted border-top py-3 mt-auto">
        <div class="container d-flex justify-content-between align-items-center">
            <small>&copy; {{ date('Y') }} Desenvolvido por Richard Tavares.</small>
            <div>
                <a href="https://www.linkedin.com/in/richard-tavares" class="text-muted me-3 text-decoration-none" target="_blank" aria-label="LinkedIn">
                    <i class="bi bi-linkedin" style="font-size: 1.5rem;"></i>
                </a>
                <a href="https://github.com/richard-tavares" class="text-muted text-decoration-none" target="_blank" aria-label="GitHub">
                    <i class="bi bi-github" style="font-size: 1.5rem;"></i>
                </a>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- jQuery Mask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
</body>

</html>
