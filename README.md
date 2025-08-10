# ByteTech - Leia e escreva artigos
O projeto é uma plataforma simples e intuitiva que permite ser realizado a leitura e escrita de publicações. Integrado com um editor de texto rico, escrever artigos, tutoriais ou blogs pessoais ficou muito mais rápido! Com uma interface construída em **TailwindCSS** e **Blade**, é possível navegar e realizar ações com facilidade


## ✨ Funcionalidades

- Cadastro e Login de Usuários
- Criação, edição e exclusão de posts
- Busca inteligente por título, descrição ou tags
- Categorias e tags personalizadas
- Posts mais curtidos em destaque
- Comentários em posts
- Perfil de usuário com upload de foto
- Design responsivo
- Preview em tempo real da escrita do conteúdo
- Integração com TinyMCE para edição rica

## 👨‍💻 Tecnologias Utilizadas
- **Laravel**: Toda lógica do Back-end e construção de interfaces com Blade
- **TailwindCSS**: Estilização da página 
- **TinyMCE**: Editor de texto
- **Vite**: Build do Front-end
- **MySQL**: Banco de dados relacional

## 💻 Como executar o projeto
### 1. Clone o repositório
```bash
git clone https://github.com/Gustavo7327/BlogPage.git
cd BlogPage
```
### 2. Instale as dependências
```bash
composer install
pnpm install
```
### 3. Configure o ambiente
```bash
cp .env.example .env
php artisan key:generate
```
### 4. Adicione a sua chave de API do TinyMCE
```bash
VITE_TINYMCE_API_KEY=SUA_CHAVE
```
### 5. Execute as migrations
```bash
php artisan migrate
```
### 6. Popule o banco de dados (opcional)
```bash
php artisan db:seed
```
### 7. Inicie o servidor
```bash
php artisan serve
pnpm run dev
```
### 8. Acesse em http://localhost:8000

## 💡 Contribua
Sinta-se à vontade para abrir issues, sugerir melhorias ou enviar pull requests!