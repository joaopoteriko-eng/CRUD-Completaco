# Estoque Didático MVC — PHP 8.1+ + PDO + MySQL

Aplicação educacional completa, organizada conforme **Model–View–Controller (MVC)**.
**Esta versão substitui os scripts PHP isolados da raiz.** Apenas `public/` deve ser publicada pelo Apache.

## Funcionalidades
Login, logout, troca de senha (hash com `password_hash`), usuários admin/operador, dashboard, CRUD de produtos, entradas e saídas, histórico e validações Bootstrap + JavaScript. Segurança introdutória: CSRF, prepared statements, escape HTML, sessões HttpOnly, rechecagem de usuário ativo e transações.

## Estrutura de diretórios
```text
CRUD-Estoque-Completo-PHP/
├── app/
│   ├── bootstrap.php
│   ├── Core/
│   │   ├── Auth.php
│   │   ├── Csrf.php
│   │   ├── Database.php
│   │   └── View.php
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── ProductController.php
│   │   ├── MovementController.php
│   │   └── UserController.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Product.php
│   │   └── Movement.php
│   └── Views/
│       ├── layout/ (header.php, footer.php)
│       ├── auth/ (login.php, password.php)
│       ├── dashboard/ (index.php)
│       ├── products/ (index.php, form.php)
│       ├── movements/ (index.php, form.php)
│       └── users/ (index.php)
├── public/
│   ├── index.php                   # único ponto de entrada
│   └── assets/
│       ├── css/estilo.css
│       └── js/app.js
├── sql/banco.sql
├── .gitignore
└── README.md
```

## Instalação com XAMPP
1. Use **PHP 8.1+** com `pdo_mysql` e `mbstring` habilitados. Inicie Apache e MySQL.
2. Clone este repositório na pasta `C:\xampp\htdocs\CRUD-Estoque-Completo-PHP` (ou `htdocs/CRUD-Estoque-Completo-PHP`).
3. Importe `sql/banco.sql` pelo phpMyAdmin (cria o banco `estoque_didatico`).
4. Configure as variáveis `DB_HOST`, `DB_NAME`, `DB_USER` e `DB_PASS` no ambiente do Apache quando necessário. Na instalação XAMPP local padrão, o sistema usa host 127.0.0.1, banco estoque_didatico, root e senha vazia. **Não publique com esse usuário/senha.**
5. Em ambiente de laboratório: `http://localhost/CRUD-Estoque-Completo-PHP/public/index.php?r=login`.
6. Administrador didático: `admin@escola.local` / `Admin@12345!`. **Troque a senha inicial** em “Minha senha”.

Para implantação real, ajuste o **DocumentRoot do VirtualHost para a pasta `public/`**; não exponha o diretório raiz da aplicação. Em hospedagens que não permitem isso, não publique o projeto inteiro sem controles equivalentes.

## Como funciona MVC
- **Front Controller** `public/index.php`: mapeia apenas rotas permitidas e respectivos métodos GET/POST.
- **Controller**: confere permissões, valida POST e CSRF, chama Models e envia os resultados à View.
- **Model**: reúne SQL parametrizado e operações com PDO.
- **View**: HTML, Bootstrap, `htmlspecialchars` e formulários.
- **Core**: centraliza conexão, autenticação, token CSRF e renderização.

### Rotas principais (todas via `public/index.php?r=...`)
| GET | POST |
| --- | --- |
| `login` | `login.submit` |
| `dashboard` | `logout` |
| `products`, `products.create`, `products.edit&id=1` | `products.save`, `products.delete` |
| `movements`, `movements.create&produto_id=1` | `movements.save` |
| `users` | `users.save`, `users.toggle` |
| `password` | `password.save` |

## Permissões
- Administrador: gerenciamento de produtos e usuários, movimentações, consultas e troca da própria senha.
- Operador: consulta de produtos, entradas/saídas, histórico, dashboard e troca da própria senha.
- O servidor reconsulta o usuário em cada requisição, evitando acesso após desativação.

## Exercício guiado / testes manuais
1. Digite senha errada: não autentica. Use o admin inicial, altere a senha e faça logout.
2. Cadastre um produto: saldo inicial **0**.
3. Registre entrada **10** e saída **3**: saldo **7**, dois eventos no histórico.
4. Tente sair **99**: deve recusar e manter saldo/histórico.
5. Tente excluir um produto com movimentação: bloqueio por FK.
6. Cadastre operador: confirme **403** nas rotas de administração.
7. Remova o campo CSRF de um POST: deve retornar **419**.
8. Cadastre produto com o nome literal `<script>alert(1)</script>`: deve aparecer como texto, sem executar JavaScript.
9. Confira o dashboard atualizado e compare os dados no phpMyAdmin.

## Limites e observações
Projeto de ensino, não pronto para produção: implementar HTTPS obrigatório, rate limiting, auditoria, backups e tratamento avançado de sessões. O Bootstrap é carregado de CDN e requer internet. SQL com seed didático deve ser usado apenas em ambiente de aula. Em instalações repetidas, `INSERT` do administrador usa `ON DUPLICATE KEY`; os três produtos de exemplo são inseridos novamente, então importe uma única vez.



