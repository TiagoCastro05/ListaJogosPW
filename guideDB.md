# **Base de dados**
_Última atualização do doc. 16.Out.2025_

---

- [Configuração da base de dados](#configuração-da-base-de-dados)
- [Notas](#notas)

# Configuração da base de dados
O ficheiros `.sql`, disponibilizados para a configuração da base de dados, devem ser considerados/executados pela seguinte ordem:

1. Criação da base de dados _moviesdb_: `db.sql`;
2. Preenchimento da tabela dos géneros dos filmes: `genres_moviesdb.sql`;
3. Preenchimento da tabela dos filmes: `movies_moviesdb.sql`;

# Notas
Para a criação, configuração e manipulação da base de dados, pode ser utilizado qualquer sistema de gestão de base de dados.  
_No meu caso, nas aulas, utilizarei a seguinte VS Code Extension:_  

> MySQL  
> v8.4.2
> cweijan.vscode-mysql-client2 
> Database Management for MySQL/MariaDB, PostgreSQL, Redis and ElasticSearch.
