# 💬 PHP Realtime Chat

Aplicação web de **chat em tempo real desenvolvida com PHP, JavaScript, MySQL e AJAX**, criada inicialmente como um projeto de estudo a partir de um mini-curso do youtuber Error Solution e posteriormente expandida com diversas **correções, melhorias e adaptações próprias**.

O projeto foi utilizado como forma de aprofundar conhecimentos em desenvolvimento web, principalmente em **PHP, manipulação de sessões, banco de dados, requisições assíncronas, organização de código e comunicação entre frontend e backend**.

> 📚 **Origem do projeto:** este projeto teve como ponto de partida um tutorial educativo do youtuber Error Solution. Durante o desenvolvimento, foram realizadas modificações, correções de problemas e melhorias para ampliar o aprendizado e tornar a aplicação mais consistente.

---

## 🚀 Sobre o projeto

O PHP Realtime Chat é uma aplicação de mensagens que permite usuários se cadastrarem, realizarem login e conversarem através de uma interface web.

A comunicação entre o cliente e o servidor utiliza **AJAX**, permitindo atualizar as mensagens e informações da aplicação sem a necessidade de recarregar completamente a página.

O projeto também foi utilizado para praticar conceitos importantes de desenvolvimento backend com PHP, incluindo:

* Autenticação de usuários
* Gerenciamento de sessões
* Comunicação com banco de dados
* Requisições AJAX
* Manipulação de dados com PHP
* Validação de informações
* Organização de arquivos
* Configuração de ambiente
* Uso de Composer
* Variáveis de ambiente

---

## ✨ Funcionalidades

* 👤 Cadastro de usuários
* 🔐 Login e autenticação por sessão
* 💬 Conversas entre usuários
* 🔎 Pesquisa de usuários
* 🟢 Listagem de usuários disponíveis
* 📩 Envio e recebimento de mensagens
* 🔄 Atualização das mensagens através de AJAX
* 🗄️ Persistência de dados no banco de dados
* 🔒 Utilização de sessões para controle de autenticação
* ⚙️ Configuração através de variáveis de ambiente

---

## 🛠️ Tecnologias utilizadas

### Backend

* **PHP**
* **MySQL**
* **AJAX**
* **Composer**
* **PHP dotenv**

### Frontend

* **HTML5**
* **CSS3**
* **JavaScript**

### Ferramentas

* **Git**
* **GitHub**
* **XAMPP / Apache**
* **MySQL**

O projeto utiliza `vlucas/phpdotenv` para gerenciamento de variáveis de ambiente e autoload PSR-4 para as classes localizadas em `src/`.

---

## 📁 Estrutura do projeto

```text
php-realtime-chat/
│
├── public/
│   └── Arquivos públicos da aplicação
│
├── src/
│   └── config/
│       └── Configurações da aplicação
│
├── vendor/
│   └── Dependências instaladas pelo Composer
│
├── .htaccess
├── composer.json
├── composer.lock
└── README.md
```

---

## 🔧 Instalação

### 1. Clone o repositório

```bash
git clone https://github.com/HenriqueBossle/php-realtime-chat.git
```

Entre no diretório:

```bash
cd php-realtime-chat
```

### 2. Instale as dependências

```bash
composer install
```

### 3. Configure o banco de dados

Crie um banco de dados MySQL para a aplicação e configure as credenciais de acesso através das variáveis de ambiente utilizadas pelo projeto.

Exemplo:

```env
DB_HOST=localhost
DB_USER=root
DB_PASSWORD=
DB_NAME=chat
```

> Os nomes das variáveis devem corresponder às utilizadas na configuração atual do projeto.

### 4. Configure o servidor

Coloque o projeto no diretório público do seu servidor Apache/XAMPP e configure o acesso para o diretório `public`.

Depois, acesse a aplicação através do navegador.

---

## 📚 Origem e evolução do projeto

Este projeto começou como um **exercício prático baseado em um mini-curso de um chat em tempo real com PHP e JavaScript**.

Após reproduzir o código apresentado nas aulas do youtuber Error Solution, eu fiz uma analise própria do projeto e decide deixa-lo um pouco mais robusto e escalável, implementando mais praticas de segurança e arquitetura uteis ao sistema, deixando-o um pouco mais profissional. 

Entre as melhorias realizadas estão:

* Ajustes na comunicação entre frontend e backend;
* Melhorias nas consultas ao banco de dados;
* Ajustes no sistema de pesquisa de usuários;
* Tratamento de erros;
* Implementação de praticas para melhor segurança;
* Melhorias na organização do código;
* Utilização de variáveis de ambiente;
* Configuração de autoload com Composer;
* Adaptações realizadas durante o processo de desenvolvimento;

Esse processo fez com que o projeto deixasse de ser apenas uma reprodução de tutorial e se tornasse também um **projeto de aprendizado e experimentação**, no qual foram aplicados conhecimentos adquiridos durante os estudos de desenvolvimento web.

## 🔮 Possíveis melhorias futuras

Algumas funcionalidades que ainda podem ser adicionadas futuramente:

* [ ] WebSockets para comunicação realmente em tempo real
* [ ] Envio de imagens e arquivos
* [ ] Mais melhorias na segurança
* [ ] Paginação das mensagens
* [ ] Mais melhorias na arquitetura do sistema
* [ ] Dockerização da aplicação
* [ ] Deploy no render
* [ ] Banco de dados no NeonDB


## 📄 Observação

Este projeto possui finalidade principalmente **educacional e de portfólio**.

A implementação inicial teve como referência uma videoaula/tutorial, sendo posteriormente modificada por mim.
