# SFA - Air Charter Service

Este é um projeto de demonstração de um sistema de fretamento de voos (Air Charter Service), construído com PHP/Laravel.

O sistema possui um painel administrativo para gerenciamento de voos e reservas, controle de acesso baseado em papéis (Admin, User) e uma API RESTful completa com autenticação JWT e documentação Swagger.

## Repositório

Você pode clonar este projeto a partir do seguinte repositório no GitHub:

```bash
git clone https://github.com/marcellopato/sfa.git
```

## Requisitos

Para executar este projeto, você precisará ter as seguintes ferramentas instaladas em seu ambiente de desenvolvimento:

- **Docker e Docker Compose:** Para executar o ambiente de desenvolvimento conteinerizado com Laravel Sail.
- **Composer:** Para gerenciamento de dependências do PHP.
- **PHP 8.2+**

## Como Executar o Projeto

Siga os passos abaixo para configurar e executar o ambiente de desenvolvimento localmente.

1.  **Clonar o Repositório**
    ```bash
    git clone https://github.com/marcellopato/sfa.git
    cd sfa
    ```

2.  **Copiar o Arquivo de Ambiente**
    Copie o arquivo de exemplo `.env.example` para `.env`. Ele contém as configurações padrão necessárias para o Laravel e o Sail.
    ```bash
    cp .env.example .env
    ```

3.  **Instalar Dependências do Composer**
    Este comando irá instalar todas as dependências do PHP definidas no `composer.json`.
    ```bash
    composer install
    ```

4.  **Iniciar os Contêineres com Laravel Sail**
    Execute o Sail em modo "detached" (background). Este comando irá construir e iniciar os contêineres Docker para a aplicação, banco de dados e outros serviços.
    ```bash
    ./vendor/bin/sail up -d
    ```

5.  **Gerar a Chave da Aplicação**
    Com os contêineres em execução, gere a chave de encriptação do Laravel.
    ```bash
    ./vendor/bin/sail artisan key:generate
    ```

6.  **Executar as Migrações e Seeders**
    Este comando irá criar a estrutura do banco de dados e popular as tabelas com dados iniciais, incluindo os papéis (admin, user) e usuários de exemplo.
    ```bash
    ./vendor/bin/sail artisan migrate --seed
    ```
    
    **Usuários de Exemplo:**
    - **Admin:** `admin@sfa.com` / `password`
    - **Usuário Comum:** `user@sfa.com` / `password`

## Acesso à API e Documentação

A API do projeto é documentada utilizando Swagger (OpenAPI). Para acessar a documentação e interagir com os endpoints, siga os passos abaixo.

1.  **Gerar a Documentação da API**
    Execute o seguinte comando para gerar o arquivo de documentação do Swagger:
    ```bash
    ./vendor/bin/sail artisan l5-swagger:generate
    ```

2.  **Acessar a Interface do Swagger**
    Abra o seu navegador e acesse a seguinte URL:
    [http://localhost/api/documentation](http://localhost/api/documentation)

3.  **Autenticar na API**
    Para testar os endpoints protegidos, você precisa se autenticar:
    - Encontre o endpoint `POST /api/auth/login`.
    - Use as credenciais do usuário admin (`admin@sfa.com` / `password`) para obter um token de acesso.
    - Copie o `access_token` retornado.
    - Clique no botão "Authorize" no topo da página.
    - Na janela que abrir, cole o token no formato `Bearer <seu_token_aqui>`.
    - Agora você pode testar todos os endpoints protegidos da API.


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
