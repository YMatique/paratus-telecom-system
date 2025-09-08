# 🚀 Faturamento Automatizado - Guia Completo

## 📋 O que foi implementado

### ✅ Commands Artisan
- `php artisan invoices:generate` - Gera faturas mensais
- `php artisan invoices:mark-overdue` - Marca faturas vencidas e suspende clientes

### ✅ Service Layer
- `InvoiceGenerationService` - Lógica centralizada de faturamento
- Validações, cálculos e regras de negócio

### ✅ Background Jobs
- `GenerateInvoiceJob` - Processa faturas em background
- Sistema de retry e tratamento de erros

### ✅ Scheduler Automático
- Execução automática via cron
- Logs e notificações por email

---

## 🔧 Como usar

### 1. **Teste Manual (Recomendado primeiro)**

```bash
# Simular geração (não cria faturas reais)
php artisan invoices:generate --dry-run

# Gerar faturas reais
php artisan invoices:generate

# Forçar geração para todas as subscrições ativas
php artisan invoices:generate --force

# Gerar para data específica
php artisan invoices:generate --date=2024-12-01
```

### 2. **Verificar Inadimplência**

```bash
# Simular verificação
php artisan invoices:mark-overdue --dry-run

# Executar verificação real
php artisan invoices:mark-overdue

# Suspender após 10 dias (ao invés de 7)
php artisan invoices:mark-overdue --suspend-days=10
```

### 3. **Configurar Automação**

```bash
# Adicionar ao crontab do servidor
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

---

## 📊 Funcionalidades Principais

### 🎯 **Geração Inteligente**
- ✅ Verifica se fatura já existe no período
- ✅ Calcula período de cobrança automaticamente
- ✅ Considera dia de vencimento da subscrição
- ✅ Gera numeração sequencial automática
- ✅ Aplica IVA 17% automaticamente

### 💡 **Regras de Negócio**
- ✅ Só gera para subscrições ativas com auto_renew=true
- ✅ Evita fins de semana nas datas de vencimento
- ✅ Atualiza next_invoice_date automaticamente
- ✅ Cria itens detalhados com período

### 🚨 **Controle de Inadimplência**
- ✅ Marca faturas vencidas automaticamente
- ✅ Suspende clientes após X dias configurable
- ✅ Logs completos para auditoria
- ✅ Preserva histórico nas notas

---

## 🗓️ Cronograma Automático

| Horário | Ação | Frequência |
|---------|------|------------|
| **1º dia, 08:00** | Gerar faturas mensais | Mensal |
| **Todo dia, 09:00** | Verificar vencidas | Diário |
| **Segunda, 10:00** | Suspender inadimplentes | Semanal |
| **Domingo, 02:00** | Limpeza de jobs | Semanal |
| **Domingo, 03:00** | Backup BD | Diário |

---

## 🧪 Testando o Sistema

### **Cenário 1: Primeira Execução**
```bash
# 1. Verificar subscrições elegíveis
php artisan invoices:generate --dry-run

# 2. Se OK, gerar faturas reais
php artisan invoices:generate

# 3. Verificar no dashboard quantas foram criadas
```

### **Cenário 2: Teste de Inadimplência**
```bash
# 1. Simular verificação
php artisan invoices:mark-overdue --dry-run

# 2. Ver quais faturas seriam marcadas
# 3. Executar real se OK
php artisan invoices:mark-overdue
```

### **Cenário 3: Forçar Faturamento**
```bash
# Para regenerar todas (cuidado!)
php artisan invoices:generate --force --dry-run
```

---

## 🔍 Monitoramento

### **Logs Importantes**
```bash
# Logs de faturamento
tail -f storage/logs/invoices-generation.log

# Logs de inadimplência  
tail -f storage/logs/overdue-check.log

# Logs gerais do Laravel
tail -f storage/logs/laravel.log
```

### **Verificações no Banco**
```sql
-- Faturas geradas hoje
SELECT COUNT(*) FROM invoices WHERE DATE(created_at) = CURDATE();

-- Subscrições com próxima fatura vencida
SELECT COUNT(*) FROM subscriptions 
WHERE next_invoice_date <= CURDATE() AND status = 'active';

-- Faturas vencidas
SELECT COUNT(*) FROM invoices 
WHERE status = 'overdue';
```

---

## ⚙️ Configurações Importantes

### **Queue Configuration**
```php
// .env
QUEUE_CONNECTION=database
# ou redis para melhor performance
```

### **Email Notifications**
```php
// .env
MAIL_FROM_ADDRESS=sistema@suaisp.co.mz
ADMIN_EMAIL=admin@suaisp.co.mz
```

### **Backup (Opcional)**
```php
// config/backup.php
'enabled' => env('BACKUP_ENABLED', true),
```

---

## 🚨 Alertas e Cuidados

### ⚠️ **Antes de Produção**
- [ ] Testar com `--dry-run` sempre primeiro
- [ ] Verificar configurações de email
- [ ] Configurar queue workers se usar redis
- [ ] Testar backup se habilitado
- [ ] Verificar permissões de logs

### 🔒 **Segurança**
- [ ] Logs não devem ter dados sensíveis
- [ ] Commands só admin deve executar  
- [ ] Cron configurado corretamente
- [ ] Backup em local seguro

### 📈 **Performance**
- Jobs em background para muitas faturas
- Índices nas tabelas (invoice_date, status)
- Limpeza regular de logs antigos

---

## 🎯 Próximos Passos

1. **Testar sistema** com dados reais
2. **Implementar notificações** por email/SMS
3. **Criar relatórios** de faturamento
4. **Integrar com pagamentos** automáticos
5. **Dashboard** com métricas de cobrança

---

## 🆘 Troubleshooting

### **Problema: Faturas não são geradas**
```bash
# Verificar subscrições elegíveis
php artisan invoices:generate --dry-run

# Verificar se next_invoice_date está correta
# Verificar se status = 'active' e auto_renew = true
```

### **Problema: Jobs não executam**
```bash
# Verificar workers
php artisan queue:work

# Verificar jobs failed
php artisan queue:failed
```

### **Problema: Scheduler não roda**
```bash
# Testar schedule manualmente
php artisan schedule:run

# Verificar crontab
crontab -l
```

---

**🎉 Sistema de Faturamento Automatizado implementado com sucesso!**

Agora a ISP pode processar centenas de faturas automaticamente, sem intervenção manual, com controle completo de inadimplência e logs para auditoria.