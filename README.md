![IPLeiria](doc/ipl.png)

# PLATAFORMAS DE SISTEMAS DE INFORMAÇÃO

# Desenvolvido pelos alunos do TeSP de PSI-PL 23/24.

**2220894 Andre Duarte
2220905 Patrick Soares
2220907 Rafael Coelho**

-- Descrição

Este sistema, desenvolvido em Framework Yii2 na unidade de Plataformas de Sistemas de Informação (PSI), segue as regras e convenções de uma arquitetura MVC, usando mecanismos de controlo de acesso, RBAC e ACF, que regem permissões e privilégios dentro de um sistema com base em atributos predefinidos. O projeto abrange a implementação de um website de venda de brindes publicitários com o nome BrindesZorro, plataforma web que oferece um conjunto de funcionalidades, incluindo registo e login de utilizadores, visualização de artigos e faturas, carrinho de compras, área pessoal de cliente e a capacidade de avaliar artigos já comprados.
A estrutura da plataforma é composta por um back-office destinado a administradores e funcionários, permitindo-lhes gerir eficientemente os dados e processos internos. Por outro lado, o front-office é direcionado para clientes, proporcionando uma experiência intuitiva de navegação e utilização. Para validar o bom funcionamento da plataforma, estão incorporados testes Unitários, Funcionais e de Aceitação

## Requisitos de Sistema

- Sistema operacional: Windows
- Plataforma: Servidor Apache e Browser
- Outros requisitos: Processador: Intel Core i3 ou superior

## Instalação

1. Faça o download da aplicação [aqui](https://github.com/Patricksoares100/PSI_Web). Caso não consiga aceder, peça através do Teams pelo número de aluno a um dos desenvolvedores.
2. Configure a base de dados (bdbrindeszorro.sql). [aqui](https://github.com/Patricksoares100/PSI_Web/tree/77f824ad15cf62353a97b8174d1fbec7a4bb52ad/doc)
   - Possivel de configurar no diretorio de projeto - web/common/config/main-local.php - no campo 'dsn' => 'mysql:host=localhost;dbname=bdbrindeszorro'
3. Descompacte o arquivo em uma pasta de sua escolha.
4. Abrir e utilizar.

## Configuração

1. É nescessario utilizar o ficheiro da base de dados (bdbrindeszorro.sql) para o programa correr sem erros.
2. Para ter acesso ao back-office é necessário realizar o login como **Administrador** ou **Funcionário**.
   - Utilizar credenciais de Utilizador **Administrador**: 'admin' e Password: 'teste123'.
   - Utilizar credenciais de Utilizador **Funcionário**: 'funcionario' e Password: 'teste123'.
3. Para ter acesso ao front-office não é necessário obrigaoriamente login, contudo as funcionalidades de cliente apenas poderão ser acedidas quando realizadas como **Cliente**.
   - Utilizar credenciais de Utilizador: 'cliente' e Password: 'teste123'.
4. Para os testes funcionais é necessária a base de dados de testes (bdbrindeszorro_test.sql). Possivel de aceder [aqui](https://github.com/Patricksoares100/PSI_Web/tree/77f824ad15cf62353a97b8174d1fbec7a4bb52ad/doc)
   - Possivel de configurar no diretorio de projeto - web/common/config/test-local.php - no campo 'dsn' => 'mysql:host=localhost;dbname=bdbrindeszorro_test'

## Execução

1. Navegue até a pasta onde a aplicação foi extraída.
2. Utilize o ficheiro da base de dados (bdbrindeszorro.sql). [aqui](https://github.com/Patricksoares100/PSI_Web/tree/77f824ad15cf62353a97b8174d1fbec7a4bb52ad/doc)
3. Abra a aplicação atraves do WWW.

## Execução de Testes de Aceitação

1. Instalação do Selenium e do chromedriver.exe:
2. Download do WebDriver correspondente ao navegador que você pretende automatizar:
- ChromeDriver 
- GeckoDriver (Firefox)
3. Executar o cmd de teste "php vendor/bin/codecept run acceptance -c frontend"

## Licença

Este projeto é um trabalho académico desenvolvido para a UC de PSI.
O código está disponível apenas para fins educacionais e não deve ser utilizado para fins comerciais.
O uso deste código-fonte está sujeito às leis e regulamentos aplicáveis.

## Contato

Os utilizadores podem obter suporte ou fornecer feedback, para tal basta contactar qualquer desenvolvedor através do número de aluno.
