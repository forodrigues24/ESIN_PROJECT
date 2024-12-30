# Projeto de uma Cliníca Privada

## Descrição

Este projeto baseia-se no desenvolvimento de um website que deverá ser utilizado por uma pequena cliníca privada.
Tem como funcionalidades a marcação de consultas de pacientes e a atribuição de diversas funções pelo admin que permitem aos trabalhadores acederem certas páginas dependendo do seu trabalho.
Funções dos diversos funcionários:

Admin: atribuído imediatamente ao primeiro perfil que é registrado no website. Tem como função a atribuição de funções a funcionários e a inserção dos seus dados na base de dados. como o inicio de contrato,
fim de contrato e especialidade caso se adeque.

Secretária: responsável por registrar os diversos horários de trabalho diários de cada funcionário. É importante ela registar os diversos horários antecipadamente, uma vez que estes interferem na marcação de consultas.

Doutor: responsável por fazer o relatório das consultas que lhe são atribuidas. Consegue editar o relatório e esconder os relatórios, de forma a melhorar a visualização da página. Possuem diversas especialidades.

Enfermeira: dependendo do horário que possuem, conseguem ver as consultas que foram marcadas e atribuem-se às consultas que lhe são adequadas. Nem todas as consultas precisam de enfermeira,
por isso, elas conseguem ver a idade e especialidade do usuário e associarem-se à consulta.

Paciente: consegue escolher a especialidade e o dia para o qual pretende marcar a sua consulta. As opções de horários e médicos que lhe aparecem dependem de inúmeros fatores: se o médico trabalha nesse dia e
o seu horário de trabalho, da especialidade do médico e apenas aparecem opções nas quais o médico não tem qualquer outra consulta.

O horário de funcionamento da consulta é das 8h-20h, não podendo marcar outras consultas fora deste horário.

No perfil de cada usuário, há a opção de ele alterar os dados no qual se registou e também consegue ver as consultas que marcou e ,caso seja um funcionário, ver os seus horários de trabalho.
Todos os empregados da cliníca também podem marcar consultas caso necessitem.

Existem páginas acessórias, na qual pode-se ver o percurso profissional da direção da cliníca, ver a sua localização com um mapa interativo e informações sobre ela.

## Aplicação dos conceitos aprendidos

O código foi separado tal como foi representado nas aulas de Engenharia de Sistemas de Informação, dividindo-se em templates, actions(ficheiros usados quando se submite forms), funções da database e funções acessórias.

Para além disto o CSS também foi dividido em layout(organização da estrutura da página),style(elementos estéticos) e responsividade.

## Autor(es)

- Fábio Rodrigues 202107030
- Sandro Oliveira 202104703
- Tiago Castanheira 202104958

## Como Executar o Projeto

 O site é baseado em HTML, CSS e PHP e pode ser executado facilmente utilizando Docker.

Este projeto usa Docker para ser executado de forma simples e rápida. Para executar o site, siga as instruções abaixo:

1. **Certifique-se de que o Docker está instalado** em sua máquina. Se não estiver, pode ser baixado e instalar o Docker [aqui](https://www.docker.com/get-started).

2. **Extraia a pasta do projeto e coloque na raiz do drive C** 

3. **Abra o terminal powershell com requisitos de administrador** :  docker run -d -p 9000:8080 -it --name=php -v C:\html:/var/www/projeto gfcg/vesica-php73:dev

4. **Na aplicação docker desktop dar run ao container**

5. **Digitar 9000:8080 no navegador Chrome**

   