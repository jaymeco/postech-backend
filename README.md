# API Tech Challenge

Esta aplicação foi desenvolvida utilizando a arquitetura hexagonal e alguns método do DDD. Nas seções abaixo terão as explicações quais camadas o projeto possui, junto com a explicação da organização física dos arquivos e o que a aplicação necessita para ser utilizada

## Rodando o projeto
O projeto possui arquivos de configuração docker (dockerfile e docker-compose) para rodar em ambientes de desenvolvimento.

A configuração para o projeto ser executado está completamente provisionado no arquivo docker-compose. Para executar o projeto para testes, basta seguir os passos a seguir e executar os devidos comandos.
#### Montagem do ambiente
Montagem do ambiente utilizando o docker compose:
```
docker compose -d --build
```

Com o ambiente provisionado, basta realizar o acesso ao terminal dentro do container utilizando o comando:
```
docker exec -it post-tech-backend-1 bash
```
Obs.: Caso o nome do *container* criado não seja o mesmo do citado acima, basta apenas colocar o nome do *container* que foi criado após a montagem do ambiente.
#### Instalação do projeto
O aplicação foi desenvolvida utilizando php 8.3 com Laravel 11 e banco Postgresql. Uma vez dentro do *container*, para realizar a instalação do projeto é necessário executar os comandos abaixo

**Instalação das dependências**:
```
composer install
```

**Rodando migração do banco de dados**:
```
php artisan migrate
```

**Rodando seeders para o banco de dados**:
```
php artisan db:seed
```
#### Execução do projeto

Para executar a aplicação, basta executar o comando abaixo e a aplicação estará pronto para uso:
```
php artisan serve --host 0.0.0.0
```

**Documentação**
Ao executar o projeto, documentação da API criada utilizando o Swagger, estará disponível na seguinte url: `http://localhost:8000/api/documentation`
## Explicação das Camadas
Utilizando os conceitos da arquitetura hexagonal, a aplicação foi construída isolando o domínio da aplicação das camadas mais externas do projeto. Com a utilização do framework Laravel, a organização física das pastas tornou-se diferente quando o assunto são os *adapters* com seus *driven* e *driver*.

- `/core`: Nesta pasta se encontra o centro do hexagonal, contendo toda a logica de negocio do projeto.
	- `/core/Domain`: Na pasta `Domain` encontra-se toda a definição do domínio da aplicação, é nela que se encontram as entidades e seus value objects que validam a regra de negocio da aplicação.
	- `/core/Application`: Esta pasta é destinada a camada de aplicação do projeto, onde toda a orquestração das entidades e consumo de interfaces acontece. Nela entram-se duas pasta
- `/app`: Esta pasta é nativa do framework Laravel, e ela representa a camada de *adapters* da aplicação é nela que a implementação da camada de infra e API se encontram.
	- `/app/Http`: Ainda se utilizando da estruturação do framework, a pasta `/Http` contém toda a definição do ator condutor da aplicação, nesse caso a API. É nesta pasta que a criação e implementação das *controllers* se encontram.
	- `/app/Infra`: Nesta pasta se encontra a implementação dos contratos definidos pelo domínio  da aplicação, é nela que o ator conduzido (nesse caso o repositório) se encontra. Existem duas implementações dos repositórios, uma utilizando dados em memória e outra utilizando o ORM Eloquent. Os repositórios em memória foram utilizados para a implementação dos testes da aplicação enquanto os com Eloquent são as implementações definitivas.

OBS.: Sobre a camada dos atores condutores, a definição das rota são feita na pasta `/routes` seguindo a estruturação do Laravel.
