# API Tech Challenge

Esta aplicação foi desenvolvida utilizando a arquitetura hexagonal e alguns método do DDD. Nas seções abaixo terão as explicações quais camadas o projeto possui, junto com a explicação da organização física dos arquivos e o que a aplicação necessita para ser utilizada

## Rodando o projeto
O projeto possui arquivos de configuração docker (dockerfile e docker-compose) para rodar em ambientes de desenvolvimento.

A configuração para o projeto ser executado está completamente provisionado no arquivo docker-compose. Para executar o projeto para testes, basta seguir os passos a seguir e executar os devidos comandos.
#### Montagem do ambiente
Montagem do ambiente utilizando o docker compose:
```
docker compose -d --build up
```

Com o ambiente provisionado, basta realizar o acesso ao terminal dentro do container utilizando o comando:
```
docker compose exec -it backend bash
```
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

## Executando projeto no kubernetes
Para excutar o projeto utilizando o kubernetes, basta executar os arquivos presentes na pasta `/k8s` presente na raiz do projeto.
Seguindo os comandos abaixo, o projeto estará configurado para ser utilizado.

### Configurações inicias
Os comandos abaixo irão criar o config map, secrets e a estratégia HPA para a aplicação API.

**Criando ConfigMap**
```
kubectl apply -f configmap.yaml
```

**Criando Secrets**
```
kubectl apply -f secrets.yaml
```

**Criando HPA**
```
kubectl apply -f hpa.yaml
```

### Configuração das aplicações
Para que o projeto seja completamente provisonado é necessário executar os arquivos para a API e banco de dados.
É de extrema importância que os arquivos do banco de dados presentes na pasta `/k8s/db` sejam executados primeiro
para depois os arquivos da API presentes na pasta `/k8s/api`.

**Executando arquivos para o banco de dados**
Uma vez estando dentro da pasta `/k8s`, basta executar o camando abaixo:
```
kubectl apply -f db/
```

**Executando arquivos para a API**
Uma vez estando dentro da pasta `/k8s`, basta executar o camando abaixo:
```
kubectl apply -f api/
```

**Executando arquivos para o PgAdmin**
Uma vez estando dentro da pasta `/k8s`, basta executar o camando abaixo:
```
kubectl apply -f pgadmin/
```

> Os serviços executados estarão disponivéis nas seguintes portas:
- API na porta: 31100
- PgAdmin para visualização do banco de dados: 31102

# Documentação
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

# Requisitos da API
Esta API possui funcionalidades que atendendem a solução da criação de autoatendimento de lanchonente.
As rotas listadas abaixo contemplam os requisitos funcionais necesários para que a solução seja atendida.
Cada requisito funcional será explicado de forma breve junto com a sua rota.

> As rotas foram agrupadas de acordo com os dois tipos de usuários do sistema, são eles: Estabelecimento e clientes.

## Requisitos funcionais do estabelecimento
O estabelecimento tem duas frentes para os requisitos funcionais, atuar no gerenciamento de produtos e pedidos.
Nas próximas seções abaixo, estarão listadas as rotas e os requisitos funcionais que elas atendem.

### Produtos
Os requisitos funcionais que envolvem os produtos são bem suncistos. O estabelcimento deseja criar, editar, ler e excluir produtos
para dentro do sistema.

#### Criar Produto:
Funcionalidade de criação de produto dentro do sistema, pegando os dados básico como preço, descricão, nome do produto, imagem de ilustração
e categoria a qual ele pertence.
**Rota: POST /api/establishment/products**

#### Editar Produto:
Funcionalidade de edição de produto dentro do sistema, selecionando um produto e alterando suas informações.
**Rota: PUT /api/establishment/products/:productUuid**

#### Ler Produtos:
Funcionalidade de listagem de produto pertencentes a uma categoria. 
**Rota: GET /api/establishment/categories/:categoryUuid/products**

#### Excluir Produto:
Funcionalidade de exclusão de produto dentro do sistema.
**Rota: DELETE /api/establishment/products/:productUuid**

### Pedidos
> Os requisitos funcionais que envolvem os pedidos são mais elaborados e ajudam o estabelecimento
com as funcionalidades de listar pedidos em uma ordem definida e alterar o status de andamento do pedido.

#### Listar pedidos:
Funcionalidade de listagem de pedidos em uma ordem definidas. Os pedidos são ordenados pela data de solicitação, ou seja,
os pedidos antigos são exibidos primeiros. Além da ordem por data, existe uma ordenação pelo status do pedidos, sendo necessários
listar os pedidos prontos primeiro depois os em preparação e para no final os pedidos recebidos.
**Rota: GET /api/establishment/orders**

#### Enviar pedido para preparação:
Funcionalidade de alteração de status do pedido para "Em preparação". Esta funcionalidade apenas dará ao estabelecimento
a possibilidade de enviar o pedido para a preparação, dando assim continuidade ao fluxo do pedido.
**Rota: PUT /api/establishment/orders/:orderUuid/prepare**

#### Definir como "Pronto":
Funcionalidade para definir o pedido para "Pronto". Esta funcionalidade permite que o estabelecimento após ter a preparação do pedido finalizada, possa alterar
o status do pedido para "Pronto".
**Rota: PUT /api/establishment/orders/:orderUuid/complete**

#### Finalizar:
Funcionalidade para finalizar o processo do pedido. Esta funcionalidade permite que o estabelecimento possa alterar o status
do pedido para "Finalizado" após o cliente retirar seu pedido da lanchonete.
**Rota: PUT /api/establishment/orders/:orderUuid/finish**


## Requisitos funcionais do cliente
O Cliente tem o foco de funcionalidades em volta dos pedidos, onde ele pode criar um pedido, enviar para a etapa de pagamento
consultar o status do pagamento do pedido e consultar o pedido. O cliente também pode realizar o seu cadastro dentro do sistema
caso queira.

### Cadastro no sistema:
Requisito funcional que permite o cliente se cadastrar no sistema usando o seu nome e e-mail
**Rota POST /api/customer/**

### Pedidos:
Requisitos funcional que permitem o cliente criar, e visualizar o andamento do pedido.

#### Criar pedido:
Funcionalidade de criação do pedido, envolve o envio dos produtos selecionados pelo cliente e a identificação do cliente que está solicitando o pedido
**Rota POST /api/customer/orders**

#### Consultar pedido:
Funcionalidade que permite o cliente consulte o pedido afim de visualizar o seu andamento até a finalização da sua preparação.
**Rota GET /api/customer/orders/:orderUuid**

#### Checkout do pedido:
Funcionalidade que permite o cliente prossiga para a etapa para o pagamento, fazendo com que o sistema gere o qr code de pagamento do pedido para poder ser enviado
até a cozinha do estabelecimento
**Rota PUT /api/customer/orders/:orderUuid/checkout**

#### Consultar status do pagamento pedido:
Funcionalidade que permite o cliente consulte o status do pagamento pedido para saber se o pagamento foi aprovado ou não.
**Rota GET /api/customer/orders/:orderUuid/check-payment**
