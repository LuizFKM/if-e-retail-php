<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
<style>
    :root {
        --coffee:       #3B2418;
        --coffee-deep:  #2A170D;
        --amber:        #C68A4C;
        --amber-soft:   #E2B47A;
        --sand:         #F5EBD9;
        --cream:        #EFE4D2;
        --paper:        #FBF6EC;
        --ink:          #1B120B;
        --line:         #E2D3BB;
    }

    body {
        background-color: var(--paper);
        color: var(--ink);
    }

    .btn-amber {
        background-color: var(--amber);
        color: var(--coffee-deep);
        border: none;
        font-weight: 600;
    }

    .btn-amber:hover {
        background-color: var(--amber-soft);
        color: var(--coffee-deep);
    }

    /* Navbar */
    .navbar-loja {
        background-color: var(--coffee-deep);
    }

    .navbar-loja .navbar-brand {
        color: var(--amber);
        font-weight: 700;
        font-size: 1.3rem;
        letter-spacing: 1px;
    }

    .navbar-loja .navbar-brand:hover { color: var(--amber-soft); }
    .navbar-loja .nav-link { color: var(--sand); }
    .navbar-loja .nav-link:hover { color: var(--amber-soft); }

    /* Cards de produto */
    .card-produto {
        border: 1px solid var(--line);
        background-color: var(--cream);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .card-produto:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(42,23,13,0.15);
    }

    .card-produto .card-title { color: var(--coffee); font-weight: 600; }
    .card-produto .preco { color: var(--amber); font-size: 1.2rem; font-weight: 700; }

    /* Footer */
    .footer-loja {
        background-color: var(--coffee-deep);
        color: var(--sand);
    }

    .footer-loja a { color: var(--amber-soft); text-decoration: none; }
    .footer-loja a:hover { color: var(--amber); }

    /* Página de produto */
    .produto-preco { color: var(--amber); font-size: 2rem; font-weight: 700; }
    .badge-estoque { background-color: var(--amber); color: var(--coffee-deep); }

    /* Carrinho */
    .carrinho-item { background-color: var(--cream); border: 1px solid var(--line); border-radius: 8px; }
    .carrinho-total { background-color: var(--coffee); color: var(--sand); border-radius: 8px; }
</style>
