<?php

declare(strict_types=1);

namespace MotoManager\Models;

use PDO;
use PDOException;

/**
 * Modelo para gerenciamento de motos
 */
class Moto
{
    private ?int $id = null;
    private string $marca;
    private string $modelo;
    private int $ano;
    private string $placa;
    private string $cor;
    private float $quilometragem;
    private string $status;
    private ?string $observacoes = null;
    private \DateTimeImmutable $dataCadastro;
    private ?\DateTimeImmutable $dataAtualizacao = null;

    public function __construct(
        string $marca,
        string $modelo,
        int $ano,
        string $placa,
        string $cor,
        float $quilometragem = 0.0,
        string $status = 'ativo'
    ) {
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->ano = $ano;
        $this->placa = strtoupper($placa);
        $this->cor = $cor;
        $this->quilometragem = $quilometragem;
        $this->status = $status;
        $this->dataCadastro = new \DateTimeImmutable();
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getMarca(): string
    {
        return $this->marca;
    }

    public function getModelo(): string
    {
        return $this->modelo;
    }

    public function getAno(): int
    {
        return $this->ano;
    }

    public function getPlaca(): string
    {
        return $this->placa;
    }

    public function getCor(): string
    {
        return $this->cor;
    }

    public function getQuilometragem(): float
    {
        return $this->quilometragem;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getObservacoes(): ?string
    {
        return $this->observacoes;
    }

    public function getDataCadastro(): \DateTimeImmutable
    {
        return $this->dataCadastro;
    }

    public function getDataAtualizacao(): ?\DateTimeImmutable
    {
        return $this->dataAtualizacao;
    }

    // Setters
    public function setMarca(string $marca): void
    {
        $this->marca = $marca;
        $this->dataAtualizacao = new \DateTimeImmutable();
    }

    public function setModelo(string $modelo): void
    {
        $this->modelo = $modelo;
        $this->dataAtualizacao = new \DateTimeImmutable();
    }

    public function setAno(int $ano): void
    {
        if ($ano < 1900 || $ano > (int) date('Y') + 1) {
            throw new \InvalidArgumentException('Ano inválido');
        }
        $this->ano = $ano;
        $this->dataAtualizacao = new \DateTimeImmutable();
    }

    public function setPlaca(string $placa): void
    {
        $this->placa = strtoupper($placa);
        $this->dataAtualizacao = new \DateTimeImmutable();
    }

    public function setCor(string $cor): void
    {
        $this->cor = $cor;
        $this->dataAtualizacao = new \DateTimeImmutable();
    }

    public function setQuilometragem(float $quilometragem): void
    {
        if ($quilometragem < 0) {
            throw new \InvalidArgumentException('Quilometragem não pode ser negativa');
        }
        $this->quilometragem = $quilometragem;
        $this->dataAtualizacao = new \DateTimeImmutable();
    }

    public function setStatus(string $status): void
    {
        $statusValidos = ['ativo', 'inativo', 'manutencao', 'vendido'];
        if (!in_array($status, $statusValidos, true)) {
            throw new \InvalidArgumentException('Status inválido');
        }
        $this->status = $status;
        $this->dataAtualizacao = new \DateTimeImmutable();
    }

    public function setObservacoes(?string $observacoes): void
    {
        $this->observacoes = $observacoes;
        $this->dataAtualizacao = new \DateTimeImmutable();
    }

    /**
     * Converte o objeto para array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'ano' => $this->ano,
            'placa' => $this->placa,
            'cor' => $this->cor,
            'quilometragem' => $this->quilometragem,
            'status' => $this->status,
            'observacoes' => $this->observacoes,
            'data_cadastro' => $this->dataCadastro->format('Y-m-d H:i:s'),
            'data_atualizacao' => $this->dataAtualizacao?->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Valida se a moto está apta para uso
     */
    public function isApta(): bool
    {
        return $this->status === 'ativo';
    }

    /**
     * Verifica se precisa de manutenção (a cada 5000 km)
     */
    public function precisaManutencao(): bool
    {
        return $this->quilometragem > 0 && ($this->quilometragem % 5000) < 100;
    }
}