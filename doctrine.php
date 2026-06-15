<?php //habilita pra gente utilizar as funcoes do terminal do doctrine pra criar as tabelas.

require_once __DIR__ . '/vendor/autoload.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
// Correção: namespace completo necessário para o autoload PSR-4 funcionar
use App\utils\Conexao;

ConsoleRunner::run(
    new SingleManagerProvider(Conexao::getEntityManager())
);

