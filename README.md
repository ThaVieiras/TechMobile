# 📱 TechMobile - E-commerce

## 🎓 Sobre o Projeto
Este projeto faz parte da Unidade Curricular (UC) de **Projeto Integrador** turma TI99 do curso de **Assistente de Desenvolvimento de Aplicativos Computacionais** do **SENAC**. 

O TechMobile é uma aplicação web que simula um e-commerce completo focado na venda de smartphones e acessórios. O objetivo principal é consolidar os conhecimentos de programação front-end, back-end e modelagem de banco de dados, unindo regras de negócio e boas práticas de UX/UI.

## ⚙️ Funcionalidades Desenvolvidas
* **Vitrine Dinâmica:** Exibição de produtos (Destaques e Lançamentos) carregados diretamente do banco de dados.
* **Carrinho de Compras:** Sistema de sessão para gerenciar itens escolhidos (adicionar, subtrair, excluir) com cálculo dinâmico de subtotais e valor geral.
* **Checkout Seguro:** Fluxo de finalização de compra com validação de login, proteção de dados via transações atômicas (`beginTransaction` e `commit`) e regra de negócio para **baixa automática de estoque**.
* **Autenticação de Usuários:** Sistema de Login e Cadastro de clientes integrado ao banco de dados, com feedback visual amigável (Toasts/Modais).
* **Design Responsivo:** Interface estruturada e fiel aos wireframes de alta fidelidade, garantindo usabilidade em múltiplas telas.

## 🛠️ Tecnologias Utilizadas
* **Front-end:** HTML5, CSS3, Bootstrap 5.
* **Back-end:** PHP 8 (Arquitetura orientada a inclusão de arquivos modulares e segurança via PDO).
* **Banco de Dados:** MySQL (Modelagem relacional com tabelas de `produtos`, `clientes`, `pedidos`, `itens_pedidos` e `estoque`).
* **Design & Prototipagem:** Figma.
* **Controle de Versão:** Git & GitHub.

## 🚀 Como Executar o Projeto Localmente

1. **Pré-requisitos:** Certifique-se de ter um servidor local instalado (como XAMPP, WAMP ou MAMP) rodando os serviços do Apache e MySQL.
2. **Clonar o Repositório:**
   ```bash
   git clone [https://github.com/seu-usuario/techmobile.git](https://github.com/seu-usuario/techmobile.git)

Certifique-se de que a estrutura de pastas está correta, com a pasta assets dentro de public.

Acesse no seu navegador: http://localhost/seu-diretorio/techmobile/public/index.php


## 🎥 Demonstração (em Funcionamento)






✍️ Desenvolvido por
Thaís - Aluna do curso de Assistente de Desenvolvimento de Aplicativos Computacionais (SENAC).
