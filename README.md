# 📚 Livraria API & Dashboard

Sistema completo de gerenciamento de livros com painel interativo, filtros dinâmicos e gráficos visuais.

![screencapture](https://github.com/user-attachments/assets/bb8d52bc-4971-41eb-a7ed-f1ac0e76c783)

---

## 🚀 Tecnologias

- 🧠 Backend: **Laravel 12**
- 🎨 Frontend: **Blade**, **Bootstrap 5**, **SweetAlert2**, **Tom Select**, **Grid.js** e **Chart.js**
- 💾 Banco: **MySQL**
- 🧪 Testes manuais com **Postman**

---

## 📦 Requisitos

- PHP 8.2+
- Composer
- MySQL

---

## 🛠️ Instalação

```bash
# Clone o projeto
git clone https://github.com/richard-tavares/livraria.git

# Acesse a pasta
cd livraria

# Instale as dependências PHP
composer install

# Instale as dependências JS
npm install && npm run dev

# Copie o .env e configure
cp .env.example .env
php artisan key:generate

# Crie o banco de dados e execute as migrations
php artisan migrate --seed

# Rode o servidor local
php artisan serve
```

---

## 📊 Dashboard

Acesse o painel em `http://localhost:8000/dashboard`

Funcionalidades:

- 📂 Filtros por autor, assunto, editora e ano
- 📈 Gráficos interativos: livros por autor, editora, ano, preço e assunto
- 📋 Tabela dinâmica com paginação e ordenação

---

## 🧪 API com Postman

### 🔄 Importar manualmente

Você pode importar o arquivo abaixo no [Postman](https://www.postman.com):

- [`livraria.postman_collection.json`](livraria.postman_collection.json)

---

## 📁 Estrutura resumida

```
├── app/
│   ├── Http/Controllers/
│   ├── Models/
│   └── Services/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   └── views/
├── routes/
│   └── web.php
│   └── api.php
├── livraria.postman_collection.json
└── README.md
```

---

## 👨‍💻 Autor

[Richard Tavares](https://github.com/richard-tavares)

---

## 📝 Licença

Este projeto está sob a licença MIT. Veja o arquivo `LICENSE` para mais detalhes.
