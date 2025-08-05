<?php

declare(strict_types=1);

namespace MotoManager\Services;

use MotoManager\Models\Moto;
use PDO;
use PDOException;

/**
 * Serviço para gerenciamento de motos
 */
class MotoService
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Cria uma nova moto
     */
    public function criar(Moto $moto): Moto
    {
        $sql = 'INSERT INTO motos (marca, modelo, ano, placa, cor, quilometragem, status, observacoes, data_cadastro) 
                VALUES (:marca, :modelo, :ano, :placa, :cor, :quilometragem, :status, :observacoes, :data_cadastro)';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'marca' => $moto->getMarca(),
            'modelo' => $moto->getModelo(),
            'ano' => $moto->getAno(),
            'placa' => $moto->getPlaca(),
            'cor' => $moto->getCor(),
            'quilometragem' => $moto->getQuilometragem(),
            'status' => $moto->getStatus(),
            'observacoes' => $moto->getObservacoes(),
            'data_cadastro' => $moto->getDataCadastro()->format('Y-m-d H:i:s'),
        ]);

        $moto->setId((int) $this->pdo->lastInsertId());
        return $moto;
    }

    /**
     * Busca uma moto por ID
     */
    public function buscarPorId(int $id): ?Moto
    {
        $sql = 'SELECT * FROM motos WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$dados) {
            return null;
        }

        return $this->criarMotoFromArray($dados);
    }

    /**
     * Busca uma moto por placa
     */
    public function buscarPorPlaca(string $placa): ?Moto
    {
        $sql = 'SELECT * FROM motos WHERE placa = :placa';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['placa' => strtoupper($placa)]);

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$dados) {
            return null;
        }

        return $this->criarMotoFromArray($dados);
    }

    /**
     * Lista todas as motos
     */
    public function listarTodos(): array
    {
        $sql = 'SELECT * FROM motos ORDER BY data_cadastro DESC';
        $stmt = $this->pdo->query($sql);
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $motos = [];
        foreach ($dados as $dado) {
            $motos[] = $this->criarMotoFromArray($dado);
        }

        return $motos;
    }

    /**
     * Lista motos por status
     */
    public function listarPorStatus(string $status): array
    {
        $sql = 'SELECT * FROM motos WHERE status = :status ORDER BY data_cadastro DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['status' => $status]);

        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $motos = [];
        foreach ($dados as $dado) {
            $motos[] = $this->criarMotoFromArray($dado);
        }

        return $motos;
    }

    /**
     * Atualiza uma moto
     */
    public function atualizar(Moto $moto): bool
    {
        if ($moto->getId() === null) {
            throw new \InvalidArgumentException('Moto deve ter um ID para ser atualizada');
        }

        $sql = 'UPDATE motos SET 
                marca = :marca, 
                modelo = :modelo, 
                ano = :ano, 
                placa = :placa, 
                cor = :cor, 
                quilometragem = :quilometragem, 
                status = :status, 
                observacoes = :observacoes, 
                data_atualizacao = :data_atualizacao 
                WHERE id = :id';

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $moto->getId(),
            'marca' => $moto->getMarca(),
            'modelo' => $moto->getModelo(),
            'ano' => $moto->getAno(),
            'placa' => $moto->getPlaca(),
            'cor' => $moto->getCor(),
            'quilometragem' => $moto->getQuilometragem(),
            'status' => $moto->getStatus(),
            'observacoes' => $moto->getObservacoes(),
            'data_atualizacao' => $moto->getDataAtualizacao()?->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Remove uma moto
     */
    public function remover(int $id): bool
    {
        $sql = 'DELETE FROM motos WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Busca motos que precisam de manutenção
     */
    public function buscarPrecisamManutencao(): array
    {
        $sql = 'SELECT * FROM motos WHERE quilometragem > 0 AND (quilometragem % 5000) < 100 ORDER BY quilometragem DESC';
        $stmt = $this->pdo->query($sql);
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $motos = [];
        foreach ($dados as $dado) {
            $motos[] = $this->criarMotoFromArray($dado);
        }

        return $motos;
    }

    /**
     * Obtém estatísticas das motos
     */
    public function obterEstatisticas(): array
    {
        $sql = 'SELECT 
                COUNT(*) as total,
                COUNT(CASE WHEN status = "ativo" THEN 1 END) as ativas,
                COUNT(CASE WHEN status = "manutencao" THEN 1 END) as em_manutencao,
                COUNT(CASE WHEN status = "inativo" THEN 1 END) as inativas,
                AVG(quilometragem) as media_quilometragem,
                SUM(quilometragem) as total_quilometragem
                FROM motos';

        $stmt = $this->pdo->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Cria um objeto Moto a partir de um array de dados
     */
    private function criarMotoFromArray(array $dados): Moto
    {
        $moto = new Moto(
            $dados['marca'],
            $dados['modelo'],
            (int) $dados['ano'],
            $dados['placa'],
            $dados['cor'],
            (float) $dados['quilometragem'],
            $dados['status']
        );

        $moto->setId((int) $dados['id']);

        if ($dados['observacoes'] !== null) {
            $moto->setObservacoes($dados['observacoes']);
        }

        if ($dados['data_atualizacao'] !== null) {
            $moto->setDataAtualizacao(new \DateTimeImmutable($dados['data_atualizacao']));
        }

        $moto->setDataCadastro(new \DateTimeImmutable($dados['data_cadastro']));

        return $moto;
    }
}