<?php
session_start();

require "../vendor/autoload.php";

define('BASE_URL', '/if-e-retail-php');

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->get('/', 'HomeController@index');

    // Clientes
    $r->get('/clientes', 'ClienteController@listar');
    $r->get('/clientes/{id}', 'ClienteController@buscar');
    $r->post('/clientes/{id}/remover', 'ClienteController@remover');

    // Produtos
    $r->get('/produtos', 'ProdutoController@listar');
    $r->get('/produtos/{id}', 'ProdutoController@buscar');
    $r->get('/produtos/novo', 'ProdutoController@novo');
    $r->post('/produtos/cadastrar', 'ProdutoController@cadastrar');
    $r->post('/produtos/{id}/remover', 'ProdutoController@remover');

    // Pedidos
    $r->get('/pedidos', 'PedidoController@listar');
    $r->get('/pedidos/{id}', 'PedidoController@buscar');
    $r->post('/pedidos/{id}/remover', 'PedidoController@remover');

    // Admin
    $r->get('/admin', 'AdminController@listar');
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

        // Monta o nome completo da classe (Namespace) e instancia o Controller
        $controllerNamespace = "controller\\{$controllerClass}";
        $controller = new $controllerNamespace();
        $controller->$action($params);
        break;
}