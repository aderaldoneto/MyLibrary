# MyLibrary

Aplicação web para gestão de acervo bibliográfico. Permite administrar autores, assuntos e livros, além de realizar o relacionamento entre as tabelas e consultar um relatório do acervo agrupado por autor.

## Tecnologias

- PHP 8.4 e Symfony 7.4
- PostgreSQL 17
- Doctrine ORM e Doctrine Migrations
- Twig, Bootstrap 5 e JavaScript
- PHPUnit 13
- Docker Compose

## Funcionalidades

- Autenticação por e-mail e senha.
- Página inicial protegida por autenticação.
- CRUD para autores e assuntos.
- CRUD de livros, com um ou mais autores e assuntos.
- Valor do livro persistido em centavos como int, a interface converte para reais (com centavos).
- Relatório de livros por autor (filtrável por autor, editora e ano).
- Tratamento de erros 403, 404 e erros inesperados.
- Testes unitários, de serviço e de acesso às rotas.

## Pré-requisitos

- Docker e Docker Compose.

## Configuração do ambiente

O projeto:

- `.env`: versionado e contém apenas valores padrão não sigilosos.
- `.env.local`: não versionado e contém as credenciais locais.

Crie ou ajuste o arquivo `.env.local`. Exemplo de estrutura:

```dotenv
APP_SECRET=chave-para-aplicacao

POSTGRES_DB=mylibrary
POSTGRES_USER=mylibrary
POSTGRES_PASSWORD=uma-senha

DATABASE_URL="postgresql://mylibrary:uma-senha@database:15432/mylibrary?serverVersion=17&charset=utf8"
```

## Inicialização

Instale as dependências e suba os serviços:

```bash
docker compose run --rm composer install
docker compose up -d --build
```

## APP_SECRET

Rode:

```bash
docker compose exec app php -r "echo bin2hex(random_bytes(32)), PHP_EOL;"
```
Copie o resultado para o `.env.local` em APP_SECRET. 

Depois, limpe o cache: 
```bash
docker compose exec app php bin/console cache:clear
```

A aplicação rodando em [http://localhost:8080].

### Banco de dados e migrations

```bash
docker compose exec app php bin/console doctrine:migrations:migrate
```

As migrations fazem:

1. Tabela usuários e o usuário inicial de acesso.
2. Tabela autores, assuntos, livros e tabelas de associação.
3. A view `vw_relatorio_livros_por_autor`, usada exclusivamente pelo relatório.
4. Dados iniciais: 10 assuntos, 20 autores e 30 livros associados.

## Acesso inicial

E-mail: [`admin@gmail.com`]
Senha: [`admin`]

## Fluxo de uso

1. Acesse `/login` e informe as credenciais.
2. Cadastre ou revise autores e assuntos no menu.
3. Cadastre um livro, selecionando ao menos um autor e um assunto.
4. Consulte, edite ou exclua itens do acervo pelas respectivas listagens.
5. Abra `Relatórios` e, se desejar, aplique filtros.

## Testes

Execute:

```bash
docker compose exec app php bin/phpunit
```

## Estrutura principal

```
src/
├── Controller/       # Rotas e fluxos HTTP
├── Entity/           # Entidades do domínio
├── Form/             # Formulários e transformação monetária
├── Repository/       # Consultas de catálogo e relatório
├── Service/          # Persistência com tratamento de exceções
└── Exception/        # Exceções de domínio
migrations/           # Estrutura, view e dados iniciais
templates/            # Telas Twig e páginas de erro
tests/                # Testes automatizados
```