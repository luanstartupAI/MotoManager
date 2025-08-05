# 🚀 Guia de Instalação - MotoManager CRM

## 📋 Pré-requisitos

- **PHP 8.1 ou superior**
- **Composer** (gerenciador de dependências PHP)
- **Node.js 18+** e **npm**
- **Servidor web** (Apache/Nginx) ou usar o servidor embutido do Laravel
- **Banco de dados** SQLite (padrão), MySQL ou PostgreSQL

## 🔧 Instalação Passo a Passo

### 1. Preparação do Ambiente

```bash
# Clone ou extraia o projeto
cd /caminho/para/seu/projeto
```

### 2. Instalação das Dependências

```bash
# Instalar dependências PHP
composer install

# Instalar dependências JavaScript
npm install
npm run build
```

### 3. Configuração do Ambiente

```bash
# Copiar arquivo de configuração
cp .env.example .env

# Gerar chave da aplicação
php artisan key:generate
```

### 4. Configuração do Banco de Dados

O sistema vem configurado para usar **SQLite** por padrão (mais simples).

**Para SQLite (Recomendado para teste):**
```bash
# Criar arquivo do banco
touch database/database.sqlite
```

**Para MySQL/PostgreSQL:**
Edite o arquivo `.env` com suas configurações:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=motomanager
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 5. Executar Migrações e Seeders

```bash
# Executar migrações (criar tabelas)
php artisan migrate

# Executar seeders (dados de exemplo)
php artisan db:seed
```

### 6. Iniciar o Servidor

```bash
# Servidor de desenvolvimento
php artisan serve

# Ou especificar host e porta
php artisan serve --host=0.0.0.0 --port=8000
```

## 🔑 Acesso ao Sistema

**URL:** http://localhost:8000/admin

### Usuários Pré-configurados

| Tipo | Email | Senha | Permissões |
|------|-------|-------|------------|
| **Admin** | admin@motomanager.com | password | Acesso total |
| **Gerente** | gerente@motomanager.com | password | Vendas e relatórios |
| **Vendedor** | joao.vendedor@motomanager.com | password | Clientes e vendas |
| **Oficina** | oficina@motomanager.com | password | Avaliações |

## 🛠️ Configurações Adicionais

### Configuração de Email (Opcional)

Para notificações por email, configure no `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=seu-smtp.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@dominio.com
MAIL_PASSWORD=sua-senha
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@motomanager.com
MAIL_FROM_NAME="MotoManager CRM"
```

### Configuração de Timezone

No arquivo `.env`:
```env
APP_TIMEZONE=America/Sao_Paulo
```

### Configuração de Idioma

O sistema já vem configurado em português brasileiro:
```env
APP_LOCALE=pt_BR
APP_FALLBACK_LOCALE=en
```

## 🔧 Comandos Úteis

```bash
# Limpar cache
php artisan optimize:clear

# Recriar banco (CUIDADO: apaga todos os dados)
php artisan migrate:fresh --seed

# Verificar status das migrações
php artisan migrate:status

# Criar usuário admin manualmente
php artisan tinker
>>> User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('password')]);
```

## 🚨 Solução de Problemas

### Erro de Permissões
```bash
# Linux/Mac
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Ou para desenvolvimento local
chmod -R 777 storage bootstrap/cache
```

### Erro de Chave da Aplicação
```bash
php artisan key:generate
```

### Erro de Banco de Dados
```bash
# Verificar se o arquivo SQLite existe
ls -la database/database.sqlite

# Ou recriar
touch database/database.sqlite
php artisan migrate
```

### Erro 500 - Internal Server Error
```bash
# Verificar logs
tail -f storage/logs/laravel.log

# Limpar cache
php artisan optimize:clear
```

## 📦 Deploy em Produção

### 1. Configurações de Produção

No arquivo `.env`:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seu-dominio.com
```

### 2. Otimizações
```bash
# Cache de configuração
php artisan config:cache

# Cache de rotas
php artisan route:cache

# Cache de views
php artisan view:cache

# Otimizar autoload
composer install --optimize-autoloader --no-dev
```

### 3. Configuração do Servidor Web

**Apache (.htaccess já incluído)**
```apache
DocumentRoot /caminho/para/motomanager/public
```

**Nginx**
```nginx
server {
    listen 80;
    server_name seu-dominio.com;
    root /caminho/para/motomanager/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## 📞 Suporte

### Logs do Sistema
- **Laravel:** `storage/logs/laravel.log`
- **Servidor Web:** Verifique logs do Apache/Nginx

### Verificação de Saúde
```bash
# Verificar se todas as dependências estão OK
php artisan about

# Verificar configuração do banco
php artisan migrate:status
```

### Backup dos Dados
```bash
# SQLite
cp database/database.sqlite backup_$(date +%Y%m%d).sqlite

# MySQL
mysqldump -u usuario -p motomanager > backup_$(date +%Y%m%d).sql
```

---

**🏍️ MotoManager CRM** - Sistema completo para gestão de lojas de motocicletas

