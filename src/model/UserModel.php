<?php
namespace App\model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
#[ORM\Entity]
#[ORM\Table(name: "tb_user")]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "discr", type: "string")]
#[ORM\DiscriminatorMap(["admin" => Admin::class, "cliente" => Cliente::class])]
abstract class UserModel extends GenericModel{
    #[ORM\Column(type:'string')]
    private $name;

    #[ORM\Column(type:'string')]
    private $login;
    #[ORM\Column(type:'string')]
    private $cpf;
    #[ORM\OneToOne(targetEntity: Endereco::class, cascade: ['all'], orphanRemoval: true, fetch: 'LAZY')]
    #[ORM\JoinColumn(name:"endereco_id")]
    protected $endereco = null;
    // Correção: mappedBy deve referenciar o atributo '$usuario' existente em Contato, não '$user'
    #[ORM\OneToMany(mappedBy: "usuario", targetEntity: Contato::class, cascade: ["all"], orphanRemoval: true, fetch: 'LAZY')]
    protected $contatos;
    #[ORM\Column(type:'date')]
    private $dataNascimento;
    #[ORM\Column(type:'string')]
    private $senha;
    #[ORM\Column(type:'string')]
    private $tipo;

    // Novo: foto de perfil armazenada via Cloudinary (padrão do professor)
    #[ORM\Column(type: 'string', nullable: true)]
    private $urlFotoPerfil;

    public function __construct() {
        // Inicializa a coleção para que clientes novos possam adicionar contatos sem erro de null
        $this->contatos = new ArrayCollection();
    }

    public function setName($name){
        $this->name=$name;
    }

    public function getName(){
        return $this->name;
    }

    public function setCpf($cpf){
        $this->cpf=$cpf;
    }

    public function getCpf(){
        return $this->cpf;
    }

    public function setEndereco($endereco){
        $this->endereco=$endereco;
    }

    public function getEndereco(){
        return $this->endereco;
    }

    // Nota: getContato/setContato legados referenciam $this->contato (inexistente).
    // Use getContatos() para acessar a coleção real de contatos.
    public function setContato($contato){
        $this->contato=$contato;
    }

    public function getContato(){
        return $this->contato;
    }

    // Novo: acesso correto à coleção de contatos (OneToMany)
    public function getContatos(): Collection
    {
        return $this->contatos ?? new ArrayCollection();
    }

    public function setDataNascimento($dataNascimento){
        $this->dataNascimento=$dataNascimento;
    }

    public function getDataNascimento(){
        return $this->dataNascimento;
    }

    public function setSenha($senha){
        $this->senha=$senha;
    }

    public function getSenha(){
        return $this->senha;
    }

    public function setTipo($tipo){
        $this->tipo=$tipo;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login): void
    {
        $this->login = $login;
    }

    public function getTipo(){
        return $this->tipo;
    }

    public function getUrlFotoPerfil()
    {
        return $this->urlFotoPerfil;
    }

    public function setUrlFotoPerfil($urlFotoPerfil): void
    {
        $this->urlFotoPerfil = $urlFotoPerfil;
    }
}
