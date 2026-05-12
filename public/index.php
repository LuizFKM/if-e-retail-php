<?php
session_start();

require "../vendor/autoload.php";

define('BASE_URL', '/if-e-retail-php');

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {

    // ── AUTH ──────────────────────────────────────────────
    $r->get('/login',  'AuthController@form');
    $r->post('/login', 'AuthController@entrar');
    $r->get('/logout', 'AuthController@sair');

    // ── LOJA (pública) ────────────────────────────────────
    $r->get('/loja',                          'loja\LojaController@home');
    $r->get('/loja/produto/{id}',             'loja\LojaController@verProduto');
    $r->get('/loja/carrinho',                 'loja\CarrinhoController@ver');
    $r->post('/loja/carrinho/{id}/adicionar', 'loja\CarrinhoController@adicionar');
    $r->post('/loja/carrinho/{id}/remover',   'loja\CarrinhoController@remover');
    $r->get('/loja/checkout',                 'loja\CheckoutController@ver');
    $r->post('/loja/checkout/finalizar',      'loja\CheckoutController@finalizar');

    // ── PAINEL ADMIN (protegido) ──────────────────────────
    $r->get('/',     'admin\HomeController@index');
    $r->get('/admin','admin\HomeController@index');

    $r->get('/clientes',               'admin\ClienteController@listar');
    $r->get('/clientes/novo',          'admin\ClienteController@novo');
    $r->post('/clientes/cadastrar',    'admin\ClienteController@cadastrar');
    $r->get('/clientes/{id}',          'admin\ClienteController@buscar');
    $r->post('/clientes/{id}/remover', 'admin\ClienteController@remover');

    $r->get('/produtos',               'admin\ProdutoController@listar');
    $r->get('/produtos/novo',          'admin\ProdutoController@novo');
    $r->post('/produtos/cadastrar',    'admin\ProdutoController@cadastrar');
    $r->get('/produtos/{id}',          'admin\ProdutoController@buscar');
    $r->post('/produtos/{id}/remover', 'admin\ProdutoController@remover');

    $r->get('/pedidos',                'admin\PedidoController@listar');
    $r->get('/pedidos/{id}',           'admin\PedidoController@buscar');
    $r->post('/pedidos/{id}/remover',  'admin\PedidoController@remover');

    $r->get('/funcionarios',               'admin\AdminController@listar');
    $r->get('/funcionarios/novo',          'admin\AdminController@novo');
    $r->post('/funcionarios/cadastrar',    'admin\AdminController@cadastrar');
    $r->get('/funcionarios/{id}',          'admin\AdminController@buscar');
    $r->post('/funcionarios/{id}/remover', 'admin\AdminController@remover');
});

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$basePath = rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/');
$uri = substr($uri, strlen($basePath)) ?: '/';

$method = $_SERVER['REQUEST_METHOD'];

// ── Proteção das rotas do painel ──────────────────────────
$rotasAdmin = ['/', '/admin', '/clientes', '/produtos', '/pedidos', '/funcionarios'];
$isRotaAdmin = false;
foreach ($rotasAdmin as $rota) {
    if ($uri === $rota || str_starts_with($uri, $rota . '/')) {
        $isRotaAdmin = true;
        break;
    }
}

if ($isRotaAdmin && (empty($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'admin')) {
    header('Location: ' . BASE_URL . '/login');
    exit;
}

$route = $dispatcher->dispatch($method, $uri);

switch ($route[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo "Rota não encontrada";
        break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        echo "Método não permitido";
        break;

    case FastRoute\Dispatcher::FOUND:
        [$controllerClass, $action] = explode('@', $route[1]);
        $params = $route[2];

        $controllerNamespace = "controller\\{$controllerClass}";
        $controller = new $controllerNamespace();
        $controller->$action($params);
        break;
}
