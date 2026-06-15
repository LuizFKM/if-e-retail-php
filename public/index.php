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
    $r->get('/painel-administrativo/produtos/novo', 'admin\ProdutoController@novo');
    $r->post('/painel-administrativo/produtos/cadastrar', 'admin\ProdutoController@cadastrar');
    $r->get('/painel-administrativo/produtos/{id}', 'admin\ProdutoController@buscar');
    $r->post('/painel-administrativo/produtos/{id}/remover', 'admin\ProdutoController@remover');

    // Pedidos
    $r->get('/painel-administrativo/pedidos', 'admin\PedidoController@listar');
    $r->get('/painel-administrativo/pedidos/{id}', 'admin\PedidoController@buscar');
    $r->post('/painel-administrativo/pedidos/{id}/remover', 'admin\PedidoController@remover');

    // Admin
    $r->get('/admin', 'AdminController@listar');
    $r->get('/admin/novo', 'AdminController@novo');
    $r->post('/admin/cadastrar', 'AdminController@cadastrar');
    $r->get('/admin/{id}', 'AdminController@buscar');
    $r->post('/admin/{id}/remover', 'AdminController@remover');

    // ===== Dev (remover antes de ir para produção) =====
    // Auto-login com o primeiro cliente do banco — acesse /dev/auto-login para entrar sem senha
    $r->get('/dev/auto-login', 'DevController@autoLogin');
    // Popula tb_cidade com as capitais brasileiras — acesse /dev/seed-cidades uma única vez
    $r->get('/dev/seed-cidades', 'DevController@seedCidades');

    // ===== View Cliente (novas telas) =====

    // Login / sessão
    $r->post('/login/autenticar', 'LoginController@autenticar');
    $r->get('/logout', 'LoginController@sair');

    // Vitrine de produtos (cliente) — necessária p/ favoritar e adicionar ao carrinho
    $r->get('/produtos', 'LojaController@produtos');

    // Favoritos
    $r->post('/favoritos/{produtoId}/toggle', 'FavoritoController@toggle');

    // Carrinho
    $r->get('/carrinho', 'CarrinhoController@index');
    $r->post('/carrinho/adicionar/{produtoId}', 'CarrinhoController@adicionar');
    $r->post('/carrinho/item/{itemId}/quantidade', 'CarrinhoController@atualizarQuantidade');
    $r->post('/carrinho/item/{itemId}/remover', 'CarrinhoController@removerItem');
    $r->post('/carrinho/finalizar', 'CarrinhoController@finalizar');

    // Perfil do cliente (abas)
    $r->get('/perfil', 'PerfilController@index');                  // redireciona p/ aba padrão
    $r->get('/perfil/favoritos', 'PerfilController@favoritos');
    $r->get('/perfil/compras', 'PerfilController@compras');
    $r->get('/perfil/configuracoes', 'PerfilController@configuracoes');

    // Configurações — ações
    $r->post('/perfil/dados', 'PerfilController@salvarDados');         // nome, email, telefone, senha
    $r->post('/perfil/endereco', 'PerfilController@salvarEndereco');   // adicionar/editar endereço
    $r->post('/perfil/foto', 'PerfilController@salvarFoto');           // upload Cloudinary
    $r->post('/perfil/excluir', 'PerfilController@excluirConta');      // excluir conta (com confirmação)
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

        $controllerNamespace = "App\\controller\\{$controllerClass}";
        $controller = new $controllerNamespace();
        $controller->$action($params);
        break;
}
