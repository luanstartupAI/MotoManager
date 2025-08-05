# 🏍️ MotoManager CRM - Guia de Instalação para Produção

## 📦 Arquivo: `motomanager-production.tar.gz`

### 🎯 **Sobre o Projeto**
O **MotoManager CRM** é um sistema completo de gestão para lojas de motocicletas, desenvolvido em Laravel 12 com FilamentPHP 3.3.

### 🚀 **Requisitos do Sistema**
- **PHP:** 8.2 ou superior
- **Composer:** 2.0 ou superior
- **Banco de Dados:** SQLite (padrão), MySQL ou PostgreSQL
- **Extensões PHP:** intl, mbstring, xml, curl, zip, sqlite3, pdo-sqlite

### 📋 **Passos de Instalação**

#### 1. **Extrair o Projeto**
```bash
tar -xzf motomanager-production.tar.gz
cd motomanager
```

#### 2. **Instalar Dependências**
```bash
composer install --optimize-autoloader --no-dev
```

#### 3. **Configurar Ambiente**
```bash
cp .env.example .env
php artisan key:generate
```

#### 4. **Configurar Banco de Dados**
```bash
# Para SQLite (padrão)
touch database/database.sqlite
echo "DB_CONNECTION=sqlite" >> .env
echo "DB_DATABASE=$(pwd)/database/database.sqlite" >> .env

# Para MySQL
# echo "DB_CONNECTION=mysql" >> .env
# echo "DB_HOST=127.0.0.1" >> .env
# echo "DB_PORT=3306" >> .env
# echo "DB_DATABASE=motomanager" >> .env
# echo "DB_USERNAME=root" >> .env
# echo "DB_PASSWORD=" >> .env
```

#### 5. **Executar Migrações e Seeders**
```bash
php artisan migrate:fresh --seed
```

#### 6. **Configurar Permissões**
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### 7. **Otimizar para Produção**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 🌐 **Acesso ao Sistema**

**URL:** http://seu-dominio/admin

**Usuários de Teste:**
- **Admin:** admin@motomanager.com / password
- **Gerente:** gerente@motomanager.com / password
- **Vendedor:** joao.vendedor@motomanager.com / password
- **Oficina:** oficina@motomanager.com / password

### 📊 **Funcionalidades Incluídas**

#### 🏍️ **Gestão de Estoque**
- Cadastro de motocicletas (novas e usadas)
- Controle de status (disponível, vendida, em manutenção)
- Avaliações técnicas
- Controle de custos e preços

#### 👥 **Gestão de Clientes**
- Cadastro completo de clientes
- Histórico de interações
- Origem de leads
- Segmentação por interesse

#### 📈 **Gestão de Vendas**
- Pipeline de leads
- Controle de vendas
- Comissões
- Relatórios de performance

#### 📊 **Dashboard Inteligente**
- Métricas em tempo real
- Gráficos de vendas
- Alertas automáticos
- KPIs de negócio

#### 👤 **Gestão de Usuários**
- Sistema de roles e permissões
- Controle de acesso granular
- Metas de vendas por usuário

### 🔧 **Comandos Úteis**

```bash
# Iniciar servidor de desenvolvimento
php artisan serve --host=0.0.0.0 --port=8000

# Verificar status das migrações
php artisan migrate:status

# Limpar cache
php artisan config:clear && php artisan cache:clear

# Análise estática (PHPStan)
php vendor/bin/phpstan analyse app/ --level=0

# Backup do banco
php artisan tinker --execute="DB::unprepared('VACUUM')"
```

### 🛡️ **Segurança**

#### **Configurações Recomendadas**
```bash
# .env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seu-dominio.com

# Cache e sessão
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

#### **Permissões de Arquivos**
```bash
# Arquivos sensíveis
chmod 600 .env
chmod 600 database/database.sqlite

# Diretórios de cache
chmod 755 storage bootstrap/cache
```

### 📈 **Dados de Exemplo Incluídos**

- **6 Usuários** com diferentes roles
- **6 Motocicletas** (Honda, Yamaha, Kawasaki)
- **6 Clientes** com dados completos
- **6 Leads** com status variados
- **4 Vendas** realizadas
- **18 Interações** com clientes

### 🎨 **Interface**

- **Tema:** Amber/Slate (profissional)
- **Layout:** Responsivo e moderno
- **Navegação:** Intuitiva por grupos
- **Dashboard:** Métricas em tempo real
- **Gráficos:** Interativos e informativos

### 🚀 **Deploy em Produção**

#### **Apache/Nginx**
```apache
# Virtual Host
<VirtualHost *:80>
    ServerName seu-dominio.com
    DocumentRoot /var/www/motomanager/public
    
    <Directory /var/www/motomanager/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

#### **Docker (Opcional)**
```dockerfile
FROM php:8.2-fpm
# ... configurações do Docker
```

### 📞 **Suporte**

Para dúvidas ou problemas:
- **Documentação:** README.md no projeto
- **Issues:** GitHub do projeto
- **Email:** suporte@motomanager.com

---

**🎉 O MotoManager CRM está pronto para uso em produção!**