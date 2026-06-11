<?php
session_start();

require "../vendor/autoload.php";

define('BASE_URL', '/if-e-retail-php');

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->get('/', 'HomeController@index');
    $r->get('/painel-administrativo', 'admin\AdminController@index');
    $r->get('/login', 'LoginController@index');
    // Clientes
    $r->get('/clientes', 'ClienteController@listar');
    $r->get('/clientes/novo', 'ClienteController@novo');
    $r->post('/clientes/cadastrar', 'ClienteController@cadastrar');
    $r->get('/clientes/{id}', 'ClienteController@buscar');
    $r->post('/clientes/{id}/remover', 'ClienteController@remover');

    // Produtos
    $r->get('/painel-administrativo/produtos', 'admin\ProdutoController@listar');
    $r->get('//painel-administrativoprodutos/novo', 'admin\ProdutoController@novo');
    $r->post('//painel-administrativoprodutos/cadastrar', 'admin\ProdutoController@cadastrar');
    $r->get('//painel-administrativoprodutos/{id}', 'admin\ProdutoController@buscar');
    $r->post('//painel-administrativoprodutos/{id}/remover', 'admin\ProdutoController@remover');

    // Pedidos
    $r->get('/pedidos', 'PedidoController@listar');
    $r->get('/pedidos/{id}', 'PedidoController@buscar');
    $r->post('/pedidos/{id}/remover', 'PedidoController@remover');

    // Admin
    $r->get('/admin', 'AdminController@listar');
    $r->get('/admin/novo', 'AdminController@novo');
    $r->post('/admin/cadastrar', 'AdminController@cadastrar');
    $r->get('/admin/{id}', 'AdminController@buscar');
    $r->post('/admin/{id}/remover', 'AdminController@remover');
});

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$basePath = rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/');
$uri = substr($uri, strlen($basePath)) ?: '/';

$method = $_SERVER['REQUEST_METHOD'];

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
        $controllerClass = str_replace('/', '\\', $controllerClass);

        // Olha como fica limpo:
        $controllerNamespace = "App\\controller\\{$controllerClass}";
        $controller = new $controllerNamespace();
        $controller->$action($params);
        break;
}