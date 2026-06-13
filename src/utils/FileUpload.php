<?php

namespace App\utils;

use Cloudinary\Cloudinary;
use Dotenv\Dotenv;
use Exception;

// Utilitário de upload via Cloudinary — padrão do professor, adaptado para App\utils
class FileUpload
{
    // Singleton: evita criar múltiplas instâncias do Cloudinary na mesma requisição
    private static $storage;

    private static function getStorage(): Cloudinary
    {
        if (self::$storage === null) {
            $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
            $dotenv->load();
            self::$storage = new Cloudinary($_ENV['CLOUDINARY_URL']);
        }
        return self::$storage;
    }

    // Faz upload da imagem e retorna o ApiResponse (acesse $result['secure_url'])
    public static function uploadImagem(string $pasta, string $imagem, string $idPublico)
    {
        try {
            $uploadAPI = self::getStorage()->uploadApi();
            $result = $uploadAPI->upload($imagem, [
                'folder'        => $pasta,
                'public_id'     => $idPublico,
                'overwrite'     => true,
                'resource_type' => 'image',
            ]);
            return $result;
        } catch (Exception $e) {
            throw new Exception("Erro no upload da imagem: " . $e->getMessage());
        }
    }

    // Apaga imagem do Cloudinary pelo filename extraído da URL pública
    public static function deletarImagem(string $pasta, string $publicUrl): void
    {
        try {
            $uploadAPI = self::getStorage()->uploadApi();
            $publicId  = $pasta . '/' . pathinfo($publicUrl, PATHINFO_FILENAME);
            $uploadAPI->destroy($publicId, ['resource_type' => 'image']);
        } catch (Exception $e) {
            throw new Exception("Erro ao deletar a imagem: " . $e->getMessage());
        }
    }
}
