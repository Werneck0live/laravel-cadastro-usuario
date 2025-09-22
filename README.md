

# Cadastro de Usuário - Laravel

Sistema de cadastro, edição e remoção de usuários utilizando o framework Laravel 5.8.

## Sumário
1. [Sobre o Projeto](#sobre-o-projeto)
2. [Requisitos](#requisitos)
3. [Instalação](#instalação)
4. [Configuração](#configuração)
5. [Execução](#execução)
6. [Uso do Sistema](#uso-do-sistema)
7. [Testes](#testes)
8. [Contribuição](#contribuição)
9. [Licença](#licença)
10. [Observações](#observações)

## Sobre o Projeto
Sistema web para cadastro de usuários, com autenticação, permissões e operações CRUD. Desenvolvido para fins de avaliação técnica.

## Requisitos
- PHP >= 7.1.3
- Composer
- Laravel 5.8
- Apache com extensões: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath
- MySQL Server >= 5.0

## Instalação
Clone o projeto e instale as dependências:

```bash
git clone https://github.com/Werneck0live/laravel-cadastro-usuario.git
cd laravel-cadastro-usuario
composer install
npm install
```

Se necessário, instale o Laravel globalmente:

```bash
composer global require "laravel/installer"
```

## Configuração
Copie o arquivo de exemplo e configure o banco de dados:

```bash
cp .env.example .env
```

Edite o arquivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=infobase-prova-php
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

Gere a chave da aplicação:

```bash
php artisan key:generate
```

## Execução
Inicie o servidor de desenvolvimento:

```bash
php artisan serve
```

Crie as tabelas do banco:

```bash
php artisan migrate
```

Crie o usuário administrador:

```bash
php artisan db:seed
```

## Uso do Sistema
Acesse [http://localhost:8000/](http://localhost:8000/) após iniciar o servidor.

### Login
Clique em "Login" no canto superior direito. Use as credenciais:

```text
E-Mail Address: werneck.oliveira@infobase.com.br
Password: 123546
```

### Operações
- **Cadastro de usuário:** Apenas administradores podem cadastrar.
- **Edição de usuário:** Administradores ou o próprio usuário podem editar.
- **Remoção de usuário:** Apenas administradores podem remover, pela tela de visualização de dados.

> Observação: A tela de remoção utiliza o método DELETE, por isso é acessada separadamente.

## Testes
Para rodar os testes:

```bash
php artisan test
```
ou
```bash
vendor/bin/phpunit
```

## Contribuição
Contribuições são bem-vindas! Abra uma issue ou envie um pull request.

## Licença
Este projeto está sob a licença MIT.

## Observações
1. Os campos `cpf` e `telefone` da tabela `ib_users` estão como string por limitações do migrator.
2. Permissões de perfil foram validadas manualmente, não via policies do Laravel.