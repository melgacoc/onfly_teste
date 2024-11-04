# Teste Onfly Backend

Este é o CRUD para o teste técnico da Onfly construído com PHP, Laravel, MySQL e PHPUnit. A API gerência autenticação de usuários e gerenciamento de despesas;

## Funcionalidades

- **Autenticação de Usuários**: Registre e autentique usuários com senhas criptografadas.
- **Gerenciamento de Despesas**: Cadastre uma nova despesa e receba um email relatando o cadastro.

## Tecnologias
![PHP Badge](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Laravel Badge](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2CA5E0?style=for-the-badge&logo=docker&logoColor=white)
![Postman](https://img.shields.io/badge/Postman-FF6C37?style=for-the-badge&logo=Postman&logoColor=white)

## Primeiros Passos

### Pré-requisitos

- PHP (v8.2 ou superior)
- Composer
- Docker
- Docker composer (Opcional)
- Postman 

### Instalação

1. Clone o repositório:

```bash
git@github.com:melgacoc/onfly_teste.git
cd onfly_teste
```

2. Instale as dependências:
```bash
composer install
```

3. Rode as migrations:
```bash
php artisan migrate
```

4. Instale as dependências:
```bash
php artisan passport:install
```

5. Configure as variáveis de ambiente com o env example
   
6. Suba o banco de dados
 ```bash
docker run -d \
  --name mysql-container \
  -e MYSQL_DATABASE=teste_onfly_claudio \
  -e MYSQL_USER=root \
  -e MYSQL_PASSWORD= \
  -e MYSQL_ROOT_PASSWORD=root_password \
  -p 3306:3306 \
  mysql:5.7
```

7. Inicie o servidor
```bash
php artisan serve
```

O projeto possui um docker composer. Se preferir pode executa-lo. Após abra o bash do container da aplicação e rode os comandos.

### Operações

Construído usando o modelo de API Restfull possíu as seguintes operações:

## User

### Login
Utilizando a rota /api/login e passando um body do tipo:<br/>
{<br/>
   "email": string,<br/>
   "senha": string<br/>
}<br/>
Receberá um retorno contando um sucesso ou falha em caso de credenciais incorretas. No caso de sucesso um token será retornado que servirá como autenticador para as requisições de Expanses

### Criar novo usuário
Utilizando a rota /api/newUser e passando um body do tipo:<br/>
{<br/>
   "nome": string [Campo não pode ser do tipo vazio],<br/>
   "email": string [Campo não pode ser do tipo vazio e estring precisa seguir o modelo email contendo "@email.com"],<br/>
   "senha": string [Campo não pode ser do tipo vazio e precisa ter mais que 7 caracteres]<br/>
}<br/>

Receberá um retorno contando um sucesso ou falha em caso de credenciais incorretas. No caso de sucesso um token será retornado que servirá como autenticador para as requisições de Expanses

## Expanses

### Vizualizar despesas cadastradas
Ao fazer um get na rota /api/expenses uma lista de despesas será retornada, se houver alguma cadastrada, que estiver relacionada ao usuário associado ao token passado em Authorization.

### Cadastrar uma nova despesa
Ao fazer um post na rota /api/expenses passando o seguinte body:<br/>
{<br/>
   "description": string [Campo não pode ser vazio e maior que 191 caracteres],<br/>
   "amount": number [Campo não pode ser vazio e negativo],<br/>
   "date": date (YYYY/MM/DD) [Campo não pode ser vazio e ter uma data futura à criação da despesa]<br/>
}<br/>

A rota cadastra o user_id na tabela pelo id do usuário associado ao token passado para a requisição.

### Deletar uma despesa
Ao fazer um delete na rota /api/expenses/{id_expense} a despesa será excluída, se existir. Somente o usuário relacionado ao user_id da despesa poderá excluí-la



   
