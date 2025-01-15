
# **Desafio Gupy**

Este é o repositório do Desafio Gupy, contendo o backend em Laravel e o frontend em Vue.js. Abaixo estão as instruções para rodar o projeto localmente.

---

## **Clonando o Repositório**

Primeiro, clone o repositório do projeto:

```bash
git clone https://github.com/Brendon3421/DesafioGupy.git
```

### **Entrando no Diretório do Backend**

Navegue para o diretório `backend` do projeto:

```bash
cd .\DesafioGupy\
cd .\backend\
```

---

## **Rodando o Backend**

1. **Instalar Dependências:**

Execute o comando abaixo para instalar as dependências do backend:

```bash
composer install
```

2. **Rodar o Servidor:**

Para iniciar o servidor do backend, execute:

```bash
php artisan serve
```

---

## **Configuração do Banco de Dados**

### **Configuração do `.env`**

1. Acesse o arquivo `.env.example` e renomeie para `.env`.

2. Em seguida, configure os dados do banco de dados conforme necessário:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=to_do_list
DB_USERNAME=sua credencial
DB_PASSWORD=sua credencial
```

---

## **Rodando as Migrações do Banco de Dados**

1. **Executar as Migrações:**

Execute o comando para rodar as migrações do banco:

```bash
php artisan migrate
```

2. **Rodar Migrações de Chaves Estrangeiras:**

Em seguida, execute:

```bash
php artisan migrate --path=database/migrations/FK/
```

3. **Semear o Banco de Dados:**

Para preencher o banco de dados com dados iniciais, execute:

```bash
php artisan db:seed
```

---

## **Desfazendo as Migrações (Rollback)**

Se precisar derrubar o banco de dados e reverter as migrações, execute os seguintes comandos:

1. **Reverter Migrações de Chaves Estrangeiras:**

```bash
php artisan migrate:rollback --path=database/migrations/FK/
```

2. **Reverter Todas as Migrações:**

```bash
php artisan migrate:rollback
```

---

## **Rodando o Frontend**

### **Entrando no Diretório do Frontend**

Navegue para o diretório `frontend`:

```bash
cd .\frontend\
```

### **Instalar Dependências do Frontend**

Instale as dependências necessárias com o comando:

```bash
npm install
```

### **Rodar o Frontend**

Para rodar o frontend em modo de desenvolvimento, execute:

```bash
npm run dev
```

---

Agora você está pronto para rodar o projeto! 😊

Se encontrar algum problema, verifique as configurações de banco e as dependências.
