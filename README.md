# MotoManager

Sistema de Gerenciamento de Motos - Uma aplicação PHP moderna para controle de frota de motocicletas.

## 🚀 Características

- Gerenciamento completo de motos
- Controle de manutenções
- Relatórios detalhados
- Interface moderna e responsiva
- API RESTful
- Testes automatizados
- Análise estática com PHPStan

## 📋 Pré-requisitos

- PHP 8.1 ou superior
- Composer
- MySQL/MariaDB ou SQLite
- Extensões PHP: PDO, JSON

## 🛠️ Instalação

1. Clone o repositório:
```bash
git clone https://github.com/seu-usuario/motomanager.git
cd motomanager
```

2. Instale as dependências:
```bash
composer install
```

3. Configure o banco de dados:
```bash
cp .env.example .env
# Edite o arquivo .env com suas configurações
```

4. Execute as migrações:
```bash
php bin/console migrate
```

5. Inicie o servidor de desenvolvimento:
```bash
php -S localhost:8000 -t public/
```

## 🧪 Testes

Execute os testes unitários:
```bash
composer test
```

Execute a análise estática com PHPStan:
```bash
composer phpstan
```

Execute o Code Sniffer:
```bash
composer cs
```

## 📁 Estrutura do Projeto

```
motomanager/
├── src/                    # Código fonte
│   ├── Controllers/       # Controladores
│   ├── Models/           # Modelos de dados
│   ├── Services/         # Serviços de negócio
│   └── Utils/           # Utilitários
├── tests/                # Testes
├── public/              # Arquivos públicos
├── config/              # Configurações
└── docs/               # Documentação
```

## 🔧 Desenvolvimento

### Padrões de Código

Este projeto segue os padrões PSR-12 e utiliza:

- PHPStan para análise estática
- PHPUnit para testes
- PHP_CodeSniffer para verificação de padrões

### Comandos Úteis

```bash
# Instalar dependências
composer install

# Executar testes
composer test

# Análise estática
composer phpstan

# Verificar padrões de código
composer cs

# Corrigir padrões automaticamente
composer cs-fix
```

## 📝 Licença

Este projeto está licenciado sob a MIT License - veja o arquivo [LICENSE](LICENSE) para detalhes.

## 🤝 Contribuição

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📞 Suporte

Para suporte, envie um email para suporte@motomanager.com ou abra uma issue no GitHub.