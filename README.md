# CBIC Agenda - Monitoramento Legislativo 🏛️

Sistema web moderno para gestão de agendas legislativas, votação estratégica e monitoramento de projetos de lei de interesse da Indústria da Construção.

![Status](https://img.shields.io/badge/Status-Estável-green) ![Laravel](https://img.shields.io/badge/Laravel-12.x-red) ![Tailwind](https://img.shields.io/badge/Tailwind-v4-blue)

## 🌟 Visão Geral

O sistema permite que a CBIC e suas associadas acompanhem, votem e gerem relatórios executivos sobre proposições legislativas (PLs) em tramitação. A plataforma oferece fluxos distintos para **Administradores** (Gestão) e **Usuários** (Varação/Feedback).

## 🚀 Funcionalidades Principais

### 🔹 Painel do Usuário (Votação)
*   **Dashboard Interativo**: Interface "soft" com visualização clara de prazos e pendências.
*   **Sistema de Votação**: Opções claras (Convergente/Divergente) com priorização (Alta, Média, Baixa, Agenda).
*   **Edição Flexível**: Possibilidade de alterar votos, adicionar ressalvas ou limpar escolhas antes do fechamento.
*   **Central de Downloads**: Acesso rápido a arquivos importantes e modelos.

### 🔹 Painel do Administrador (Gestão)
*   **Gestão de Agendas**: Criação de ciclos anuais, upload de bases de dados (Excel) e definição de prazos.
*   **Monitoramento em Tempo Real**: Dashboard com gráficos de engajamento, status de votação e totalizadores.
*   **Relatórios Executivos**:
    *   **PDF Individual**: Layout profissional A4 (capa branca, tabelas limpas) para impressão de projetos individuais.
    *   **Relatório Geral**: Vvisão consolidada de todos os projetos com estatísticas de votação e ressalvas formatadas.
*   **Gestão de Usuários**: Controle de acesso por perfis e reset de senhas/votos.

## 🛠️ Tecnologias Utilizadas

*   **Backend**: Laravel 12 (PHP 8.2+)
*   **Frontend**: Blade Templates + Tailwind CSS v4 + Alpine.js
*   **Banco de Dados**: MySQL / MariaDB
*   **PDF**: HTML2PDF.js + Layouts CSS customizados para impressão A4
*   **Assets**: Vite para compilação de assets

## 📦 Como Instalar e Rodar

1.  **Clone o repositório**
    ```bash
    git clone https://github.com/seu-usuario/cbicdata.git
    cd cbicdata
    ```

2.  **Instale as dependências**
    ```bash
    composer install
    npm install
    ```

3.  **Configure o ambiente**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    *Edite o arquivo `.env` com as credenciais do seu banco de dados.*

4.  **Banco de Dados**
    ```bash
    php artisan migrate --seed
    ```

5.  **Compile os assets e rode o servidor**
    ```bash
    npm run build
    php artisan serve
    ```

## 📄 Estrutura de Pastas (Destaques)

*   `app/Http/Controllers/Admin`: Lógica administrativa (Agendas, Relatórios).
*   `app/Http/Controllers/User`: Lógica do usuário final (Votação).
*   `resources/views/admin/agendas`: Views dos relatórios executivos e gestão.
*   `resources/views/user`: Nova interface "soft" do dashboard.

---
Desenvolvido para **CBIC** - Câmara Brasileira da Indústria da Construção.
