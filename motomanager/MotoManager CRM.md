# 🏍️ MotoManager CRM

**Sistema Completo de Gestão para Lojas de Motocicletas**

Um CRM moderno e intuitivo desenvolvido especificamente para concessionárias e lojas de motocicletas, oferecendo controle total sobre vendas, estoque, clientes e oportunidades de negócio.

## ✨ Características Principais

### 🎯 **Gestão de Vendas**
- **Clientes**: Cadastro completo com histórico de compras
- **Oportunidades (Leads)**: Controle do funil de vendas com status detalhados
- **Vendas**: Registro completo de transações com múltiplas formas de pagamento
- **Origens de Leads**: Rastreamento de canais de aquisição

### 🏍️ **Controle de Estoque**
- **Motocicletas**: Gestão completa do inventário (0km e usadas)
- **Avaliações**: Sistema de avaliação para motos usadas
- **Status de Estoque**: Controle em tempo real da disponibilidade

### 📊 **Dashboard Inteligente**
- **KPIs Visuais**: Métricas essenciais com indicadores coloridos
- **Gráficos Interativos**: Evolução de vendas, performance de vendedores
- **Alertas Automáticos**: Notificações para estoque baixo, leads pendentes
- **Performance Score**: Pontuação geral do negócio

### 👥 **Gestão de Usuários**
- **Roles e Permissões**: Admin, Gerente, Vendedor, Oficina
- **Controle de Acesso**: Permissões granulares por funcionalidade
- **Multi-usuário**: Suporte para equipes de vendas

## 🚀 Instalação e Configuração

### Pré-requisitos
- PHP 8.1+
- Composer
- Node.js 18+
- SQLite (incluído) ou MySQL/PostgreSQL

### Instalação Rápida

```bash
# 1. Clone o repositório
git clone <repository-url> motomanager
cd motomanager

# 2. Instale as dependências
composer install
npm install

# 3. Configure o ambiente
cp .env.example .env
php artisan key:generate

# 4. Execute as migrações e seeders
php artisan migrate --seed

# 5. Inicie o servidor
php artisan serve
```

### Acesso ao Sistema

**URL:** http://localhost:8000/admin

**Usuários de Teste:**
- **Admin:** admin@motomanager.com / password
- **Gerente:** gerente@motomanager.com / password
- **Vendedor:** joao.vendedor@motomanager.com / password
- **Oficina:** oficina@motomanager.com / password

## 📱 Interface e Usabilidade

### Design Responsivo
- ✅ Interface otimizada para desktop e mobile
- ✅ Tema escuro/claro automático
- ✅ Navegação intuitiva com ícones
- ✅ Cores e indicadores visuais

### Widgets do Dashboard
1. **💰 Faturamento Total** - Receita com gráfico de tendência
2. **🏍️ Motos Disponíveis** - Controle de estoque com alertas
3. **🎯 Leads Ativos** - Taxa de conversão em tempo real
4. **📈 Vendas do Mês** - Comparativo mensal com gráfico
5. **💵 Ticket Médio** - Valor médio por venda
6. **⭐ Performance Geral** - Score baseado em múltiplas métricas

### Gráficos Avançados
- **📊 Evolução de Vendas** - Linha temporal dos últimos 6 meses
- **🏆 Ranking de Vendedores** - Performance individual da equipe
- **🏍️ Distribuição por Marca** - Gráfico de rosca do estoque
- **🎯 Canais de Aquisição** - Origem dos leads por canal

## 🔧 Funcionalidades Técnicas

### Arquitetura
- **Framework:** Laravel 11
- **Interface:** FilamentPHP 3.3
- **Banco de Dados:** SQLite (padrão) / MySQL / PostgreSQL
- **Frontend:** Livewire + Alpine.js
- **Gráficos:** Chart.js

### Recursos Avançados
- **Políticas de Acesso:** Sistema completo de permissões
- **Seeders Inteligentes:** Dados de exemplo realistas
- **Widgets Personalizados:** Dashboard totalmente customizável
- **Alertas Automáticos:** Notificações baseadas em regras de negócio
- **Tradução Completa:** Interface 100% em português brasileiro

### Estrutura do Banco
```
├── users (usuários)
├── customers (clientes)
├── motorcycles (motocicletas)
├── leads (oportunidades)
├── lead_origins (origens de leads)
├── sales (vendas)
├── appraisals (avaliações)
├── appraisal_items (itens de avaliação)
├── interactions (interações)
└── media (arquivos)
```

## 📈 Métricas e Relatórios

### KPIs Principais
- **Faturamento Total e Mensal**
- **Número de Vendas e Conversão**
- **Ticket Médio e Margem**
- **Giro de Estoque por Marca**
- **Performance Individual dos Vendedores**
- **Origem e Qualidade dos Leads**

### Alertas Inteligentes
- 🚨 **Estoque Crítico** - Menos de 3 motos disponíveis
- ⏰ **Leads Pendentes** - Sem contato há mais de 7 dias
- 📊 **Meta em Risco** - Vendas abaixo da meta mensal
- 🏍️ **Motos Paradas** - Estoque há mais de 60 dias
- 🔥 **Oportunidades Quentes** - Propostas recentes

## 🛡️ Segurança e Permissões

### Roles do Sistema
- **👑 Admin**: Acesso total ao sistema
- **👨‍💼 Gerente**: Gestão de vendas e relatórios
- **👨‍💻 Vendedor**: Clientes, leads e vendas
- **🔧 Oficina**: Avaliações e manutenção de estoque

### Controle de Acesso
- Permissões granulares por recurso
- Políticas baseadas em roles
- Middleware de autenticação
- Logs de auditoria

## 🎨 Personalização

### Temas e Cores
- Paleta de cores profissional
- Indicadores visuais por status
- Ícones intuitivos para cada seção
- Responsividade total

### Widgets Customizáveis
- Ordem configurável no dashboard
- Métricas personalizáveis
- Gráficos interativos
- Alertas configuráveis

## 📞 Suporte e Documentação

### Recursos Incluídos
- ✅ Dados de exemplo pré-configurados
- ✅ Interface totalmente traduzida
- ✅ Documentação técnica completa
- ✅ Guia de usuário integrado

### Tecnologias Utilizadas
- **Backend:** Laravel 11, PHP 8.1+
- **Frontend:** FilamentPHP, Livewire, Alpine.js
- **Database:** SQLite/MySQL/PostgreSQL
- **Charts:** Chart.js
- **Icons:** Heroicons
- **Styling:** Tailwind CSS

## 📄 Licença

Este projeto foi desenvolvido como uma solução completa para gestão de lojas de motocicletas, incorporando as melhores práticas de desenvolvimento e UX/UI design.

---

**MotoManager CRM** - *Acelere suas vendas, gerencie seu sucesso* 🏍️💨

