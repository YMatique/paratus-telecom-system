# 🎯 PORTAL DO CLIENTE - LIVEWIRE VERSION

## 📋 ESTRUTURA COMPLETA

### **Arquitetura:**
- **Backend:** Laravel 11+ com Guards separados
- **Frontend:** Livewire 3+ (SPA-like experience)
- **Auth:** Customer guard independente
- **Layout:** Components reutilizáveis

---

## 📁 ESTRUTURA DE ARQUIVOS

### **Livewire Components**
```
app/Livewire/Customer/
├── Auth/
│   ├── Login.php                    ✅ Criado
│   ├── Register.php                 ✅ Criado
│   ├── ForgotPassword.php          ⏳ Criar
│   └── ResetPassword.php           ⏳ Criar
│
├── Dashboard.php                    ✅ Criado
│
├── Subscriptions/
│   ├── Index.php                    ✅ Criado
│   └── Show.php                     ✅ Criado
│
├── Invoices/
│   ├── Index.php                    ⏳ Criar
│   └── Show.php                     ⏳ Criar
│
├── Tickets/
│   ├── Index.php                    ⏳ Criar
│   ├── Create.php                   ⏳ Criar
│   └── Show.php                     ⏳ Criar
│
├── Profile/
│   └── Edit.php                     ⏳ Criar
│
└── Plans/
    └── Index.php                    ⏳ Criar
```

### **Blade Views**
```
resources/views/
├── components/layouts/
│   ├── customer-auth.blade.php     ⏳ Layout de auth (login/register)
│   └── customer-portal.blade.php   ⏳ Layout do portal (dashboard, etc)
│
└── livewire/customer/
    ├── auth/
    │   ├── login.blade.php          ⏳ View do Login
    │   └── register.blade.php       ⏳ View do Register
    │
    ├── dashboard.blade.php          ⏳ View do Dashboard
    │
    ├── subscriptions/
    │   ├── index.blade.php          ⏳ Lista de subscrições
    │   └── show.blade.php           ⏳ Detalhes da subscrição
    │
    └── ... (outros)
```

---

## ✅ JÁ CRIADO

### **1. Migration**
📁 `database/migrations/XXXX_add_authentication_to_customers_table.php`

### **2. Model**
📁 `app/Models/Customer.php` (atualizado)
- Extends `Authenticatable`
- Traits: `HasFactory`, `SoftDeletes`, `Notifiable`

### **3. Config**
📁 `config/auth.php`
- Guard: `customer`
- Provider: `customers`
- Broker: `customers`

### **4. Middleware**
📁 `app/Http/Middleware/CustomerAuth.php`
- Protege rotas do portal
- Verifica status do cliente

### **5. Livewire Components** (Auth)
✅ `Login.php` - Login com rate limiting
✅ `Register.php` - Ativação de conta
✅ `Dashboard.php` - Dashboard principal
✅ `Subscriptions/Index.php` - Lista de subscrições
✅ `Subscriptions/Show.php` - Detalhes da subscrição

### **6. Routes**
📁 `routes/customer.php`
- Todas as rotas mapeadas para Livewire

---

## ⏳ PRÓXIMOS COMPONENTES A CRIAR

### **Prioridade ALTA:**
1. **Invoices/Index.php** - Lista de faturas
2. **Invoices/Show.php** - Detalhes/download de fatura
3. **Tickets/Index.php** - Lista de tickets
4. **Tickets/Create.php** - Criar ticket
5. **Tickets/Show.php** - Ver ticket + respostas

### **Prioridade MÉDIA:**
6. **Profile/Edit.php** - Editar perfil + senha
7. **Plans/Index.php** - Ver planos + solicitar upgrade

### **Prioridade BAIXA:**
8. **Auth/ForgotPassword.php** - Recuperar senha
9. **Auth/ResetPassword.php** - Reset senha

---

## 🎨 LAYOUTS NECESSÁRIOS

### **1. customer-auth.blade.php**
Layout minimalista para login/register:
```blade
<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? 'Portal do Cliente' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        {{ $slot }}
    </div>
    @livewireScripts
</body>
</html>
```

### **2. customer-portal.blade.php**
Layout completo com sidebar/header:
```blade
<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? 'Portal do Cliente' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <x-customer-portal.header />
    
    <div class="flex">
        <!-- Sidebar -->
        <x-customer-portal.sidebar />
        
        <!-- Main Content -->
        <main class="flex-1 p-6">
            {{ $slot }}
        </main>
    </div>
    
    @livewireScripts
</body>
</html>
```

---

## 🚀 PRÓXIMOS PASSOS

### **Fase 1: Setup Básico**
1. ✅ Migration criada
2. ✅ Model atualizado
3. ✅ Config auth.php
4. ✅ Middleware criado
5. ⏳ Rodar migration
6. ⏳ Registrar middleware no Kernel
7. ⏳ Incluir routes no web.php

### **Fase 2: Criar Layouts**
8. ⏳ Layout customer-auth.blade.php
9. ⏳ Layout customer-portal.blade.php
10. ⏳ Components: header, sidebar, footer

### **Fase 3: Views Livewire**
11. ⏳ View login
12. ⏳ View register
13. ⏳ View dashboard
14. ⏳ Views subscriptions
15. ⏳ Views invoices
16. ⏳ Views tickets
17. ⏳ View profile

### **Fase 4: Componentes Restantes**
18. ⏳ Criar InvoicesIndex
19. ⏳ Criar InvoicesShow
20. ⏳ Criar TicketsIndex
21. ⏳ Criar TicketsCreate
22. ⏳ Criar TicketsShow
23. ⏳ Criar ProfileEdit
24. ⏳ Criar PlansIndex

### **Fase 5: Testes**
25. ⏳ Seeder com customers de teste
26. ⏳ Testar login
27. ⏳ Testar navegação
28. ⏳ Testar funcionalidades

---

## 📝 EXEMPLOS DE USO

### **Criar Customer de Teste:**
```php
Customer::create([
    'type' => 'individual',
    'name' => 'João Silva',
    'document' => '123456789',
    'document_type' => 'bi',
    'email' => 'joao@teste.com',
    'password' => Hash::make('senha123'),
    'phone' => '840000000',
    'whatsapp' => '840000000',
    'status' => 'active',
]);
```

### **Testar Auth:**
```php
// No tinker
Auth::guard('customer')->attempt([
    'email' => 'joao@teste.com',
    'password' => 'senha123'
]);
```

---

## 🎯 BENEFÍCIOS DO LIVEWIRE

✅ **SPA-like** - Navegação sem recarregar página
✅ **Reatividade** - Dados atualizados em tempo real
✅ **Menos JavaScript** - Lógica no backend
✅ **Validação fácil** - Atributos do Livewire
✅ **SEO friendly** - Server-side rendering
✅ **Performance** - Lazy loading com #[Computed]

---

## 🔐 SEGURANÇA

✅ **Guard separado** - customers != users
✅ **Rate limiting** - Login protegido
✅ **CSRF protection** - Livewire automático
✅ **Authorization** - Apenas dados do próprio cliente
✅ **Password hashing** - Bcrypt padrão

---

FIM DA DOCUMENTAÇÃO