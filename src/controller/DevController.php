<?php

namespace App\controller;

use App\dao\CidadeDAO;
use App\dao\ClienteDAO;
use App\model\Cidade;
use App\utils\Conexao;
use Exception;

// Dev: controller de atalhos para desenvolvimento — REMOVER antes de ir para produção
class DevController
{
    // Acesse /dev/seed-cidades para popular a tb_cidade com as capitais brasileiras (idempotente)
    public function seedCidades()
    {
        try {
            // Idempotente: aborta se já houver registros para não duplicar
            if (!empty(CidadeDAO::listar())) {
                echo "Cidades já inseridas — nenhuma ação realizada.";
                return;
            }

            $capitais = [
                // AC
                ['nome' => 'Rio Branco',                  'estado' => 'AC'],
                ['nome' => 'Cruzeiro do Sul',             'estado' => 'AC'],
                ['nome' => 'Sena Madureira',              'estado' => 'AC'],
                // AL
                ['nome' => 'Maceió',                      'estado' => 'AL'],
                ['nome' => 'Arapiraca',                   'estado' => 'AL'],
                ['nome' => 'Palmeira dos Índios',         'estado' => 'AL'],
                ['nome' => 'União dos Palmares',          'estado' => 'AL'],
                // AP
                ['nome' => 'Macapá',                      'estado' => 'AP'],
                ['nome' => 'Santana',                     'estado' => 'AP'],
                ['nome' => 'Laranjal do Jari',            'estado' => 'AP'],
                // AM
                ['nome' => 'Manaus',                      'estado' => 'AM'],
                ['nome' => 'Parintins',                   'estado' => 'AM'],
                ['nome' => 'Itacoatiara',                 'estado' => 'AM'],
                ['nome' => 'Manacapuru',                  'estado' => 'AM'],
                // BA
                ['nome' => 'Salvador',                    'estado' => 'BA'],
                ['nome' => 'Feira de Santana',            'estado' => 'BA'],
                ['nome' => 'Vitória da Conquista',        'estado' => 'BA'],
                ['nome' => 'Camaçari',                    'estado' => 'BA'],
                ['nome' => 'Itabuna',                     'estado' => 'BA'],
                ['nome' => 'Juazeiro',                    'estado' => 'BA'],
                ['nome' => 'Lauro de Freitas',            'estado' => 'BA'],
                // CE
                ['nome' => 'Fortaleza',                   'estado' => 'CE'],
                ['nome' => 'Caucaia',                     'estado' => 'CE'],
                ['nome' => 'Juazeiro do Norte',           'estado' => 'CE'],
                ['nome' => 'Maracanaú',                   'estado' => 'CE'],
                ['nome' => 'Sobral',                      'estado' => 'CE'],
                ['nome' => 'Crato',                       'estado' => 'CE'],
                // DF
                ['nome' => 'Brasília',                    'estado' => 'DF'],
                ['nome' => 'Ceilândia',                   'estado' => 'DF'],
                ['nome' => 'Taguatinga',                  'estado' => 'DF'],
                // ES
                ['nome' => 'Vitória',                     'estado' => 'ES'],
                ['nome' => 'Serra',                       'estado' => 'ES'],
                ['nome' => 'Vila Velha',                  'estado' => 'ES'],
                ['nome' => 'Cariacica',                   'estado' => 'ES'],
                ['nome' => 'Cachoeiro de Itapemirim',     'estado' => 'ES'],
                // GO
                ['nome' => 'Goiânia',                     'estado' => 'GO'],
                ['nome' => 'Aparecida de Goiânia',        'estado' => 'GO'],
                ['nome' => 'Anápolis',                    'estado' => 'GO'],
                ['nome' => 'Rio Verde',                   'estado' => 'GO'],
                ['nome' => 'Luziânia',                    'estado' => 'GO'],
                ['nome' => 'Águas Lindas de Goiás',       'estado' => 'GO'],
                // MA
                ['nome' => 'São Luís',                    'estado' => 'MA'],
                ['nome' => 'Imperatriz',                  'estado' => 'MA'],
                ['nome' => 'São José de Ribamar',         'estado' => 'MA'],
                ['nome' => 'Timon',                       'estado' => 'MA'],
                ['nome' => 'Caxias',                      'estado' => 'MA'],
                // MT
                ['nome' => 'Cuiabá',                      'estado' => 'MT'],
                ['nome' => 'Várzea Grande',               'estado' => 'MT'],
                ['nome' => 'Rondonópolis',                'estado' => 'MT'],
                ['nome' => 'Sinop',                       'estado' => 'MT'],
                ['nome' => 'Tangará da Serra',            'estado' => 'MT'],
                // MS
                ['nome' => 'Campo Grande',                'estado' => 'MS'],
                ['nome' => 'Dourados',                    'estado' => 'MS'],
                ['nome' => 'Três Lagoas',                 'estado' => 'MS'],
                ['nome' => 'Corumbá',                     'estado' => 'MS'],
                ['nome' => 'Ponta Porã',                  'estado' => 'MS'],
                // MG
                ['nome' => 'Belo Horizonte',              'estado' => 'MG'],
                ['nome' => 'Uberlândia',                  'estado' => 'MG'],
                ['nome' => 'Contagem',                    'estado' => 'MG'],
                ['nome' => 'Juiz de Fora',                'estado' => 'MG'],
                ['nome' => 'Betim',                       'estado' => 'MG'],
                ['nome' => 'Montes Claros',               'estado' => 'MG'],
                ['nome' => 'Ribeirão das Neves',          'estado' => 'MG'],
                ['nome' => 'Uberaba',                     'estado' => 'MG'],
                ['nome' => 'Governador Valadares',        'estado' => 'MG'],
                ['nome' => 'Ipatinga',                    'estado' => 'MG'],
                // PA
                ['nome' => 'Belém',                       'estado' => 'PA'],
                ['nome' => 'Ananindeua',                  'estado' => 'PA'],
                ['nome' => 'Santarém',                    'estado' => 'PA'],
                ['nome' => 'Marabá',                      'estado' => 'PA'],
                ['nome' => 'Castanhal',                   'estado' => 'PA'],
                ['nome' => 'Parauapebas',                 'estado' => 'PA'],
                // PB
                ['nome' => 'João Pessoa',                 'estado' => 'PB'],
                ['nome' => 'Campina Grande',              'estado' => 'PB'],
                ['nome' => 'Santa Rita',                  'estado' => 'PB'],
                ['nome' => 'Patos',                       'estado' => 'PB'],
                ['nome' => 'Bayeux',                      'estado' => 'PB'],
                // PR
                ['nome' => 'Curitiba',                    'estado' => 'PR'],
                ['nome' => 'Londrina',                    'estado' => 'PR'],
                ['nome' => 'Maringá',                     'estado' => 'PR'],
                ['nome' => 'Ponta Grossa',                'estado' => 'PR'],
                ['nome' => 'Cascavel',                    'estado' => 'PR'],
                ['nome' => 'São José dos Pinhais',        'estado' => 'PR'],
                ['nome' => 'Foz do Iguaçu',              'estado' => 'PR'],
                // PE
                ['nome' => 'Recife',                      'estado' => 'PE'],
                ['nome' => 'Caruaru',                     'estado' => 'PE'],
                ['nome' => 'Olinda',                      'estado' => 'PE'],
                ['nome' => 'Petrolina',                   'estado' => 'PE'],
                ['nome' => 'Paulista',                    'estado' => 'PE'],
                ['nome' => 'Jaboatão dos Guararapes',     'estado' => 'PE'],
                // PI
                ['nome' => 'Teresina',                    'estado' => 'PI'],
                ['nome' => 'Parnaíba',                    'estado' => 'PI'],
                ['nome' => 'Picos',                       'estado' => 'PI'],
                ['nome' => 'Campo Maior',                 'estado' => 'PI'],
                ['nome' => 'Floriano',                    'estado' => 'PI'],
                // RJ
                ['nome' => 'Rio de Janeiro',              'estado' => 'RJ'],
                ['nome' => 'São Gonçalo',                 'estado' => 'RJ'],
                ['nome' => 'Duque de Caxias',             'estado' => 'RJ'],
                ['nome' => 'Nova Iguaçu',                 'estado' => 'RJ'],
                ['nome' => 'Niterói',                     'estado' => 'RJ'],
                ['nome' => 'Belford Roxo',                'estado' => 'RJ'],
                ['nome' => 'Campos dos Goytacazes',       'estado' => 'RJ'],
                ['nome' => 'Petrópolis',                  'estado' => 'RJ'],
                // RN
                ['nome' => 'Natal',                       'estado' => 'RN'],
                ['nome' => 'Mossoró',                     'estado' => 'RN'],
                ['nome' => 'Parnamirim',                  'estado' => 'RN'],
                ['nome' => 'São Gonçalo do Amarante',     'estado' => 'RN'],
                ['nome' => 'Caicó',                       'estado' => 'RN'],
                // RS
                ['nome' => 'Porto Alegre',                'estado' => 'RS'],
                ['nome' => 'Caxias do Sul',               'estado' => 'RS'],
                ['nome' => 'Pelotas',                     'estado' => 'RS'],
                ['nome' => 'Canoas',                      'estado' => 'RS'],
                ['nome' => 'Santa Maria',                 'estado' => 'RS'],
                ['nome' => 'Gravataí',                    'estado' => 'RS'],
                ['nome' => 'Novo Hamburgo',               'estado' => 'RS'],
                ['nome' => 'São Leopoldo',                'estado' => 'RS'],
                // RO
                ['nome' => 'Porto Velho',                 'estado' => 'RO'],
                ['nome' => 'Ji-Paraná',                   'estado' => 'RO'],
                ['nome' => 'Ariquemes',                   'estado' => 'RO'],
                ['nome' => 'Vilhena',                     'estado' => 'RO'],
                ['nome' => 'Cacoal',                      'estado' => 'RO'],
                // RR
                ['nome' => 'Boa Vista',                   'estado' => 'RR'],
                ['nome' => 'Rorainópolis',                'estado' => 'RR'],
                ['nome' => 'Caracaraí',                   'estado' => 'RR'],
                // SC
                ['nome' => 'Florianópolis',               'estado' => 'SC'],
                ['nome' => 'Joinville',                   'estado' => 'SC'],
                ['nome' => 'Blumenau',                    'estado' => 'SC'],
                ['nome' => 'São José',                    'estado' => 'SC'],
                ['nome' => 'Criciúma',                    'estado' => 'SC'],
                ['nome' => 'Chapecó',                     'estado' => 'SC'],
                ['nome' => 'Itajaí',                      'estado' => 'SC'],
                // SP
                ['nome' => 'São Paulo',                   'estado' => 'SP'],
                ['nome' => 'Guarulhos',                   'estado' => 'SP'],
                ['nome' => 'Campinas',                    'estado' => 'SP'],
                ['nome' => 'São Bernardo do Campo',       'estado' => 'SP'],
                ['nome' => 'Santo André',                 'estado' => 'SP'],
                ['nome' => 'Osasco',                      'estado' => 'SP'],
                ['nome' => 'São José dos Campos',         'estado' => 'SP'],
                ['nome' => 'Ribeirão Preto',              'estado' => 'SP'],
                ['nome' => 'Sorocaba',                    'estado' => 'SP'],
                ['nome' => 'Santos',                      'estado' => 'SP'],
                ['nome' => 'Mauá',                        'estado' => 'SP'],
                ['nome' => 'Mogi das Cruzes',             'estado' => 'SP'],
                ['nome' => 'Diadema',                     'estado' => 'SP'],
                ['nome' => 'Jundiaí',                     'estado' => 'SP'],
                ['nome' => 'Piracicaba',                  'estado' => 'SP'],
                ['nome' => 'Bauru',                       'estado' => 'SP'],
                // SE
                ['nome' => 'Aracaju',                     'estado' => 'SE'],
                ['nome' => 'Nossa Senhora do Socorro',    'estado' => 'SE'],
                ['nome' => 'Lagarto',                     'estado' => 'SE'],
                ['nome' => 'Itabaiana',                   'estado' => 'SE'],
                ['nome' => 'São Cristóvão',               'estado' => 'SE'],
                // TO
                ['nome' => 'Palmas',                      'estado' => 'TO'],
                ['nome' => 'Araguaína',                   'estado' => 'TO'],
                ['nome' => 'Gurupi',                      'estado' => 'TO'],
                ['nome' => 'Porto Nacional',              'estado' => 'TO'],
                ['nome' => 'Paraíso do Tocantins',        'estado' => 'TO'],
            ];

            $em = Conexao::getEntityManager();
            $em->beginTransaction();

            foreach ($capitais as $dados) {
                $cidade = new Cidade();
                $cidade->setNome($dados['nome']);
                $cidade->setEstado($dados['estado']);
                $em->persist($cidade);
            }

            $em->flush();
            $em->commit();

            echo "Cidades inseridas com sucesso (" . count($capitais) . " capitais).";

        } catch (Exception $ex) {
            echo "Erro ao inserir cidades: " . htmlspecialchars($ex->getMessage());
        }
    }

    // Acesse /dev/auto-login para entrar automaticamente como o primeiro cliente do banco
    public function autoLogin()
    {
        try {
            $clientes = ClienteDAO::listar();

            if (empty($clientes)) {
                echo "Nenhum cliente cadastrado. <a href='" . BASE_URL . "/clientes/novo'>Cadastrar cliente</a>";
                return;
            }

            $cliente = $clientes[0];
            $_SESSION['cliente_id'] = $cliente->getID();

            header('Location: ' . BASE_URL . '/perfil');
            exit;

        } catch (Exception $ex) {
            echo "Erro ao fazer auto-login: " . htmlspecialchars($ex->getMessage());
        }
    }
}
