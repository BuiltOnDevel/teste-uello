
# Deploy Teste UELLO
1- Para começar a realizar o deploy, necessita clonar o repositorio do projeto.

git clone `https://github.com/BuiltOnDevel/teste-uello`

2- Realizar a instalação do composer

Com o arquivo composer.json atualizad é preciso instalar as depêndencias do projeto.
Rodando o comando: `composer install`

3- Adicionar o parametro PATH_TO_FILE no arquivo .env

    	PATH_TO_FILE = /foo/bar

4- Script MySql
Dentro da pasta raiz do projeto, necessário roda o comando para o deploy do banco:
`mysql -u <user> -p -h <host> < script.sql;`

5-Rodando a aplicação
No terminal, roda o comando `php artisan -serve`

por default o servidor embutido irá roda na porta 8000

6- Acessando a aplicação
no navegador, utilizar o endereço http://localhost:8000/load
