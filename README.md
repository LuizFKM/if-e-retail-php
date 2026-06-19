# 🛒 IF E-Retail — Aplicação Web PHP (MVC)

Sistema de varejo (e-commerce) desenvolvido em **PHP puro** com arquitetura **MVC**, **Doctrine ORM** para persistência, **MySQL** como banco de dados e **renderização de páginas no próprio servidor** (views em PHP). Projeto acadêmico do curso de Sistemas de Informação — **IFPR Palmas**.

---

## 📋 Sobre o Projeto

O IF E-Retail é uma aplicação web completa de varejo eletrônico. Diferente de um backend isolado, o projeto entrega tanto as regras de negócio quanto as **telas finais ao usuário**, organizadas em duas áreas:

- **Loja (cliente):** página inicial com destaques, vitrine de produtos, carrinho de compras, favoritos, login/sessão e um perfil com abas (compras, favoritos e configurações).
- **Painel administrativo:** dashboard, CRUD de produtos (com upload de imagem) e gestão de pedidos (listagem, visualização e atualização de status).

A comunicação com o banco é feita via **Doctrine ORM**, com mapeamento por atributos PHP, eliminando SQL manual na maior parte do sistema. O upload de imagens (foto de produto e foto de perfil) é delegado ao **Cloudinary**.

---

## 🚀 Tecnologias e Dependências

| Tecnologia | Versão | Finalidade |
|---|---|---|
| [PHP](https://www.php.net/) | 8.2.x | Linguagem principal |
| [Composer](https://getcomposer.org/) | — | Gerenciador de dependências |
| [Doctrine ORM](https://www.doctrine-project.org/projects/orm.html) | ^3.6 | Mapeamento objeto-relacional (ORM) |
| [Symfony Console](https://symfony.com/doc/current/components/console.html) | ^7.0 | CLI para comandos Doctrine |
| [Symfony Cache](https://symfony.com/doc/current/components/cache.html) | ^7.0 | Cache de metadados do ORM |
| [Symfony VarExporter](https://symfony.com/doc/current/components/var_exporter.html) | ^7.0 | Exportação de proxies do Doctrine |
| [nikic/fast-route](https://github.com/nikic/FastRoute) | ^1.3 | Roteamento HTTP (front controller) |
| [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) | ^5.6 | Variáveis de ambiente via `.env` |
| [cloudinary/cloudinary_php](https://github.com/cloudinary/cloudinary_php) | 3.1 | Upload e gestão de imagens na nuvem |
| [PHPUnit](https://phpunit.de/) | ^9.6 | Testes automatizados |
| MySQL | — | Banco de dados relacional |

---

## 📁 Estrutura do Projeto

```
if-e-retail-php/
├── public/
│   ├── index.php          # Front controller — define as rotas e despacha para os controllers
│   ├── .htaccess          # Reescrita de URL para o front controller
│   └── assets/            # CSS e JS estáticos
├── src/
│   ├── controller/        # Controllers da loja (cliente)
│   │   └── admin/         # Controllers da área administrativa
│   ├── dao/               # Data Access Objects — acesso ao banco via Doctrine
│   ├── model/             # Entidades/modelos mapeados como tabelas pelo ORM
│   ├── utils/             # Conexao, FileUpload (Cloudinary) e Sessao (guard)
│   └── view/              # Páginas PHP renderizadas no servidor
│       ├── site/          # Telas públicas da loja (home, produtos, login, carrinho...)
│       ├── cliente/       # Telas do perfil do cliente
│       ├── admin/         # Telas do painel administrativo
│       ├── layouts/       # Layouts base (admin e cliente)
│       └── templates/     # Cabeçalho, rodapé, menus reutilizáveis
├── test/                  # Testes automatizados com PHPUnit (dao, model, utils)
├── doctrine.php           # Ponto de entrada da CLI do Doctrine (criação/atualização de schema)
├── composer.json          # Dependências e autoload PSR-4 (App\ -> src/, Test\ -> test/)
├── .htaccess              # Redireciona a raiz para a pasta public/
└── .env                   # Variáveis de ambiente (não versionado)
```

### Por que essa estrutura?

- **`public/index.php` (front controller)** — Ponto único de entrada. Todas as requisições passam por ele, que usa o `nikic/fast-route` para mapear a URL ao par `Controller@ação`. Isso centraliza o roteamento e mantém o resto do código fora da raiz pública.
- **`controller/` e `controller/admin/`** — Separam a lógica de entrada HTTP das regras de negócio. Os controllers de admin ficam num subnamespace próprio para isolar a área restrita da loja pública.
- **`dao/`** — Centraliza as consultas ao banco. A classe abstrata **`GenericDAO`** concentra as operações comuns (`salvar`, `listar`, `buscarPorId`, `deletar`) com controle de transação; os DAOs específicos apenas definem a entidade-alvo, evitando código repetido.
- **`model/`** — Entidades independentes de framework, mapeadas pelo Doctrine via atributos PHP. A classe base **`GenericModel`** (`MappedSuperclass`) fornece o `id` autoincremento a todas as entidades.
- **`utils/`** — `Conexao` (singleton do `EntityManager`, garantindo uma única conexão por requisição), `FileUpload` (abstrai o Cloudinary) e `Sessao` (guard reutilizável que retorna o cliente logado ou redireciona ao login).
- **`view/`** — Camada de apresentação dividida por contexto (loja, cliente, admin) com layouts e templates compartilhados, evitando duplicação de cabeçalho/rodapé/menus.
- **`doctrine.php`** — Expõe os comandos Doctrine (`orm:schema-tool:create`, `update`, etc.) via terminal, dispensando SQL manual para criar as tabelas.

---

## ⚙️ Pré-requisitos

- [PHP](https://www.php.net/downloads) >= 8.2
- [Composer](https://getcomposer.org/)
- MySQL (ou MariaDB) em execução
- Servidor **Apache** com `mod_rewrite` (ex.: XAMPP/WAMP) — necessário por causa dos `.htaccess` e da `BASE_URL`
- Uma conta no [Cloudinary](https://cloudinary.com/) (para o upload de imagens)

---

## 🔧 Instalação e Configuração

### 1. Clone o repositório

> Recomenda-se clonar dentro da pasta servida pelo Apache (ex.: `htdocs/`), pois a aplicação espera rodar na subpasta `/if-e-retail-php` (veja a `BASE_URL` em `public/index.php`).

```bash
git clone https://github.com/NycollasCaprini/if-e-retail-php.git
cd if-e-retail-php
```

### 2. Instale as dependências

```bash
composer install
```

### 3. Configure as variáveis de ambiente

Crie um arquivo `.env` na raiz do projeto com base no exemplo abaixo:

```env
# Banco de dados
DB_DRIVER=pdo_mysql
DB_HOST=localhost
DB_PORT=3306
DB_NAME=if_e_retail
DB_USER=root
DB_PASSWORD=sua_senha

# Cloudinary (upload de imagens) — copie do dashboard do Cloudinary
CLOUDINARY_URL=cloudinary://API_KEY:API_SECRET@CLOUD_NAME
```

> O projeto usa `vlucas/phpdotenv` para carregar essas variáveis automaticamente. As chaves `DB_DRIVER` e `CLOUDINARY_URL` são obrigatórias: a primeira é lida pela classe `Conexao`, a segunda pela classe `FileUpload`.

### 4. Crie o banco de dados

```sql
CREATE DATABASE if_e_retail CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. Gere as tabelas via Doctrine

O arquivo `doctrine.php` expõe a CLI do Doctrine. Use os comandos abaixo:

```bash
# Verificar as entidades mapeadas
php doctrine.php orm:info

# Criar as tabelas no banco de dados
php doctrine.php orm:schema-tool:create

# Ou atualizar o schema caso as entidades já existam
php doctrine.php orm:schema-tool:update --force
```

### 6. Acesse a aplicação

Com o Apache servindo o projeto na subpasta `if-e-retail-php`, abra:

```
http://localhost/if-e-retail-php/
```

---

## 🗂️ Entidades e Relacionamentos

Todas as entidades estendem **`GenericModel`**, que centraliza o `id`. A hierarquia de usuários usa herança de **tabela única** (`SINGLE_TABLE`) do Doctrine, com uma coluna discriminadora — assim Admin e Cliente compartilham a mesma tabela sem duplicar colunas.

| Entidade | Descrição |
|---|---|
| `GenericModel` | Superclasse mapeada (`MappedSuperclass`) que fornece o `id` autoincremento |
| `UserModel` | Classe base abstrata de usuário (nome, login, CPF, data de nascimento, senha, tipo, foto de perfil); possui um `Endereco` (1:1) e vários `Contato` (1:N) |
| `Admin` | Estende `UserModel`; adiciona matrícula, setor, cargo, data de admissão e status |
| `Cliente` | Estende `UserModel`; possui um `Carrinho` (1:1), uma lista de `Pedido` (1:N) e uma lista de produtos favoritos (N:N) |
| `Produto` | Itens do catálogo (descrição, quantidade, preço unitário, foto via Cloudinary) |
| `Pedido` | Compra de um `Cliente` (N:1) com data, entrega, status e seus produtos (N:N) |
| `Carrinho` | Carrinho do cliente, com itens (1:N), status e valor total |
| `ItemPedido` | Item que liga `Carrinho`/`Pedido` a um `Produto`, com quantidade e preço |
| `Endereco` | Endereço completo (rua, número, bairro, cidade, estado, CEP, país) |
| `Contato` | Telefone e e-mail vinculados a um `UserModel` (N:1) |
| `Cidade` | Cidade e UF (cadastro auxiliar) |
| `TipoUsuario` | *Enum* com os tipos `CLIENTE` e `ADMIN` |
| `UserFactory` | Fábrica que instancia `Cliente` ou `Admin` conforme o `TipoUsuario` |

---

## 🧭 Principais Rotas

As rotas são declaradas em `public/index.php`. Um resumo das áreas:

- **Loja:** `/` (home), `/produtos`, `/carrinho`, `/favoritos/{id}/toggle`, `/login`, `/logout`
- **Perfil do cliente:** `/perfil`, `/perfil/favoritos`, `/perfil/compras`, `/perfil/configuracoes` (com ações para dados, endereço, foto e exclusão de conta)
- **Administração:** `/painel-administrativo`, `/painel-administrativo/produtos` (CRUD), `/painel-administrativo/pedidos` (listar, visualizar, remover, atualizar status)
- **Clientes (gestão):** `/clientes` (listar, cadastrar, buscar, remover)

---

## 🧪 Testes

Os testes estão na pasta `test/` (subdivididos em `dao`, `model` e `utils`) e utilizam o **PHPUnit ^9.6**, configurado pelo `phpunit.xml`. Para executá-los:

```bash
./vendor/bin/phpunit
```

---

## 🔗 Frontend Relacionado

Além das views renderizadas pelo próprio servidor, existe um frontend complementar em **React + Tailwind CSS**:

- [if-retail-frontend](https://github.com/NycollasCaprini/if-retail-frontend)

---

## 👥 Contribuidores

- [NycollasCaprini](https://github.com/NycollasCaprini)
- [LuizFKM](https://github.com/LuizFKM) — repositório original

---

## 📄 Licença

Este projeto está licenciado sob a [CC0-1.0 License](https://creativecommons.org/publicdomain/zero/1.0/) — domínio público.
