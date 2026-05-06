# 📘 Laravel Breeze

**Laravel Breeze** é um kit de inicialização minimalista de autenticação desenvolvido pela equipe do Laravel. Ele fornece a implementação mais simples dos recursos de autenticação do framework, incluindo login, registro, redefinição de senha, verificação de e-mail e confirmação de senha.

É ideal para quem quer começar rapidamente um novo projeto Laravel com uma base sólida e totalmente personalizável.

---

## 🧠 Principais fatos

* **Lançamento inicial:** 2020
* **Desenvolvedor:** Equipe Laravel
* **Linguagem base:** PHP
* **Licença:** MIT
* **Estilo padrão:** Blade + Tailwind CSS

---

## ⚙️ Recursos e propósito

O Laravel Breeze oferece o alicerce essencial para autenticação de usuários em aplicações Laravel.

Ele:

* Gera automaticamente controladores, rotas e views
* Publica o código diretamente no projeto
* Permite total controle e personalização
* Mantém simplicidade sem camadas complexas

👉 É voltado para desenvolvedores que buscam agilidade e clareza.

---

## 🧱 Pilhas e opções de frontend

A pilha padrão utiliza:

```text
Blade + Tailwind CSS
```

Mas também suporta:

### 🔹 Inertia.js

* Com Vue ou React
* Ideal para SPAs (Single Page Applications)

### 🔹 Livewire

* Interfaces reativas usando apenas PHP
* Sem necessidade de JavaScript pesado

### 🔹 API Stack

* Backend pronto para consumo por:

  * Next.js
  * Nuxt.js
  * Apps mobile

---

## 🚀 Instalação

```bash
composer require laravel/breeze --dev
php artisan breeze:install
npm install && npm run dev
php artisan migrate
```

---

## 🔐 Rotas disponíveis

Após a instalação:

```text
/login
/register
```

👉 Todo o fluxo de autenticação já estará funcionando automaticamente.

---

## 🔗 Relação com outros kits Laravel

O Breeze é considerado a **porta de entrada** no ecossistema Laravel.

### 🔹 Comparação:

| Ferramenta | Característica                |
| ---------- | ----------------------------- |
| Breeze     | Leve, simples, direto         |
| Jetstream  | Avançado, com 2FA, times, API |
| Fortify    | Backend de autenticação       |

---

## 🧠 Conceito importante

```text
Breeze = Interface (telas)
Fortify = Lógica (backend)
```

---

## 🎯 Quando usar o Breeze?

Use quando você quer:

* Aprender Laravel
* Criar MVPs rápidos
* Ter controle total do código
* Evitar complexidade desnecessária

---

## 💡 Conclusão

O Laravel Breeze é a escolha ideal para iniciar projetos com autenticação de forma simples, organizada e profissional, permitindo evolução gradual conforme a necessidade da aplicação.

---


# 📘 Laravel Breeze — Opções de Stack

Quando você instala o **Laravel Breeze**, aparece a pergunta:

```text
Which Breeze stack would you like to install?
```

Cada opção define **como seu frontend vai funcionar**.

---

## 🟢 Blade with Alpine (blade)

A opção mais simples e direta.

```text
Backend + Frontend juntos (Blade)
JavaScript leve com Alpine.js
```

### ✅ Vantagens

* Fácil de aprender
* Rápido de desenvolver
* Ideal para CRUD e dashboards
* Perfeito para projetos iniciais

### 🎯 Indicado para:

* Sistemas administrativos
* Projetos como controle de ganhos
* Portfólio inicial

---

## 🟡 Livewire (Volt Class API) with Alpine

Frontend reativo usando PHP.

```text
Interface dinâmica sem recarregar página
Lógica escrita em PHP
```

### ✅ Vantagens

* Menos dependência de JavaScript
* Experiência mais dinâmica

### ⚠️ Desvantagens

* Curva de aprendizado maior que Blade

---

## 🟡 Livewire (Volt Functional API)

Versão mais moderna do Livewire.

```text
Código mais enxuto
Sintaxe funcional
```

### ✅ Vantagens

* Menos boilerplate
* Mais organizado

### ⚠️ Observação

* Ainda é Livewire, só muda o estilo

---

## 🔵 React with Inertia

Transforma sua aplicação em um SPA (Single Page Application).

```text
Laravel = backend
React = frontend
Inertia faz a conexão
```

### ✅ Vantagens

* Muito poderoso
* Muito usado no mercado
* Experiência moderna

### ⚠️ Desvantagens

* Mais complexo
* Exige conhecimento em React

---

## 🟣 Vue with Inertia

Semelhante ao React, mas usando Vue.

```text
Laravel + Vue + Inertia
```

### ✅ Vantagens

* Mais simples que React
* Muito usado no ecossistema Laravel

---

## ⚫ API only

Apenas backend.

```text
Sem frontend
Somente API
```

### 🎯 Usado para:

* Aplicações mobile
* Frontend separado (Next.js, Nuxt)
* Microserviços

---

## 🧠 Resumo geral

```text
Blade        → simples e direto
Livewire     → dinâmico sem JS pesado
React/Vue    → SPA moderno
API only     → apenas backend
```

---

## 🚀 Recomendação

Para projetos como o seu:

```text
👉 Blade + Alpine
```

### ✔ Por quê?

* Mais rápido para desenvolver
* Mais fácil de manter
* Ideal para sistemas administrativos

---

## 🔥 Evolução natural

```text
Blade → Livewire → React/Vue
```

---

## 💡 Conclusão

A escolha do stack depende do nível do projeto e da experiência desejada.

* Comece simples
* Evolua conforme a necessidade
* Priorize produtividade no início

---
