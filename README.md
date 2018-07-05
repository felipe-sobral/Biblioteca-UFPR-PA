# Consulta Local - UFPR Palotina

Olá! Tudo bem? Aqui está armazenado o projeto do novo **Consulta Local** da UFPR Setor Palotina. :smile:

# [ENTRAR NO SISTEMA](http://bibliotecaufprpa.hol.es/login.html)
>  http://bibliotecaufprpa.hol.es

## Por que esse projeto é melhor do que o anterior?
- Banco de Dados dedicado :heavy_check_mark:
- Melhor sincronização :heavy_check_mark:
- Mais facilidade :heavy_check_mark:
- Maior compatibilidade :heavy_check_mark:
- Novas funções :heavy_check_mark:
- Possibilidade de backups :heavy_check_mark:
- Acesso em qualquer lugar **sem precisar baixar/instalar nada** :heavy_check_mark:

## Projeto em desenvolvimento :fire:

Estou desenvolvendo no momento os seguintes tópicos:
 - **Automatizador Contador de Usuários**

## Menu

+ **Contador de usuários** - Atalho para registrar entrada/saída de usuários na biblioteca;
+ **Registrador consulta local** - Atalho para registrar códigos dos livros para fazer a estatística de consulta local;
+ Estatística de Usuários - Abre menu com todas opções da estatística de usuários;
  + Contador - Registrar entrada/saída de usuários na biblioteca;
  + Adicionar - Adicionar algum dia que não foi registrado no banco de dados;
  + Histórico - Exibir o histórico detalhado do número de entradas/saidas da biblioteca;
  + Alterar - Opção de alterar alguma data, caso tenha ocorrido algum erro;
+ Estatística Consulta Local - Abre menu com todas consulta local;
  + Registrar códigos - Registrar códigos dos livros para fazer a estatística de consulta local;
  + Adicionar - Adicionar algum dia que não foi registrado no banco de dados;
  + Histórico - Exibir o histórico detalhado de quantos livros foram registrados no mês;
  + Alterar - Opção de alterar alguma data, caso tenha ocorrido algum erro;
  + Baixar - Fazer *download* dos códigos registrados no mês;
+ Gerenciar conta - Configurações que o usuário pode alterar em sua conta (Exemplo: trocar senha; excluir conta);
+ Administração - Configurações administrativas (Exemplo: registrar usuário; alterar usuário; exibir usuários registrados; log do usuário);
+ Reportar - Formulário para reportar erros/bugs ou sugerir melhorias;
+ Sair - Desconectar do usuário atual;


## Como utilizo o Contador de Usuários?
Para registrar um usuário basta clicar no botão **+** contido na tela inicial e verificar se foi incrementado +1 no contador. Caso você adicione pessoas por engano, poderá clicar no botão **-** para remover -1 do contador.

#### Outras opções

- **Adicionar** - Adicionar estatística do usuário de um dia que não foi marcado, o formulário irá receber quantos usuários entrou pela manhã, tarde e noite. Utilize como exemplo as demonstrações contidas no próprio formulário;
- **Histórico** - Ao setar o mês e o ano desejado, o sistema lhe retornará um resumo detalhado da estatística de usuários da data escolhida;
- **Alterar** - Ao colocar uma data digitada da forma "AAAA-MM-DD" (Exemplo: 2018-06-21) irá te retornar campos para fazer a edição, tais como a quantia de usuários registrados nos períodos da *manhã*, *tarde* e *noite*. No final do formulário selecione se você quer *alterar* ou *excluir* os dados da data informada;

## Como utilizo o Consulta Local?
Para registrar um livro no consulta local é bem simples, basta inserir o código manualmente ou com o leitor de códigos de barras no campo abaixo de onde está escrito **Insira o código do livro**. Caso insira manualmente, clique no botão **registrar**, se registrou com um leitor não precisa.

#### Outras opções

- **Adicionar** - Aqui poderá ser inserido os códigos junto com o dia, mês e ano, caso não tenha registrado no sistema aquela data em específico;
-  **Histórico** - Ao setar o mês e o ano desejado, o sistema lhe retornará um resumo detalhado da estatística de livros registrados da data escolhida;
- **Alterar** - Recebe dia, mês e ano, e então lhe dará um retorno com todos os códigos registrados naquele dia para fazer alguma alteração ou correção de erro manualmente;
- **Baixar** - Recebe mês e ano para fazer o download em arquivos txt (*text*) da data informada;
  - O arquivo baixado irá vir compactado como **ZIP**, para descompacta-lo basta clicar com o botão direito do mouse sobre ele e selecionar a opção "Extrair para local ...", caso tenha o WinRar instalado no computador, selecione  respectivamente "WinRAR -> Extract to ... / ou / Extrair para ...";

# Atualizações
- **20/06/2018**;
  - Melhorias de código;
  - Atualizado a página inicial do painel de controle (home_restrita.html);
    - Adicionado total de pessoas registradas no dia;
    - Adicionado total de livros registrados no dia;
    - Adicionado a data da última atualização do sistema;
- **21/06/2018**;
  - Corrigido erro gerado pela atualização (20/06/2018) que não mostrava contador de usuários registrados caso fosse 0 (zero);
  - Atualizado esta documentação;
- **05/07/2018**;
  - Atualizado a página inicial do painel de controle (home_restrita.html);
    - Adicionado aviso temporário;
  - Adicionado botão "Atualizações" no menu principal; 
# Bom, é isso. Por enquanto.

Ainda estou escrevendo esta documentação, fique de olho.
Você também pode entrar em contato comigo.

 - **E-mail**: xfelipesobral@gmail.com
 -  [**Facebook**](https://www.facebook.com/krepper.fs)
 - **WhatsApp**: (44) 9 9814-0644

Encontrou algum bug/erro? Quer fazer alguma sugestão? Você pode preencher o formulário para me informar. Link do formulário: <https://goo.gl/forms/QvhPwxZpUs0IT1Ys1>

*Projeto em desenvolvimento. Desenvolvido por [Felipe Vieira Sobral](http://lattes.cnpq.br/1682042608972339), estudante de Licenciatura em Computação na Universidade Federal do Paraná - Setor Palotina.*
