# Precifique Fácil
## Aplicação para precificar produtos
### Sistema de Assinaturas com Mercado Pago (PIX e Cartão)

Esta aplicação é uma plataforma de assinaturas desenvolvida em **Laravel**, com integração completa ao **Mercado Pago**, utilizando o **Checkout Transparente (API de Pagamentos)**.

O sistema permite que usuários escolham planos, realizem pagamentos via **PIX ou Cartão de Crédito** e tenham suas assinaturas ativadas automaticamente após a confirmação do pagamento.

Toda a lógica de pagamento é centralizada no Mercado Pago, garantindo maior simplicidade, segurança e facilidade de manutenção.


##### 🚀 Funcionalidades principais

- Cadastro e exibição de planos de assinatura
- Checkout transparente (sem redirecionamento)
- Pagamento via **PIX (QR Code automático)**
- Pagamento via **Cartão de Crédito**
- Integração única com o Mercado Pago
- Geração automática de QR Code PIX
- Registro de pagamentos no banco de dados
- Controle de status do pagamento
- Estrutura preparada para Webhooks
- Código organizado seguindo boas práticas do Laravel


#### 🛠 Tecnologias utilizadas

- PHP 8+
- Laravel 12
- Mercado Pago API (Checkout Transparente / API de Pagamentos)
- MySQL
- JavaScript
- HTML / CSS / Bootstrap / Blade e Sass
### 💳 Integração com Mercado Pago

A aplicação utiliza a **API de Pagamentos do Mercado Pago**, permitindo processar pagamentos de forma transparente diretamente no sistema, sem redirecionar o usuário para páginas externas.

#### Métodos de pagamento disponíveis:
- **PIX**: geração automática de QR Code
- **Cartão de Crédito**: pagamento direto via formulário

O backend é responsável por criar os pagamentos, enquanto o frontend apenas consome as informações retornadas pela API.

#### 🔹 Pagamento via PIX

1. O usuário seleciona um plano
2. Clica em **"Gerar QR Code PIX"**
3. O frontend envia uma requisição para o backend
4. O backend cria um pagamento PIX no Mercado Pago
5. O Mercado Pago retorna o QR Code
6. O QR Code é exibido na interface
7. O pagamento permanece pendente até confirmação

#### 🔹 Pagamento via Cartão de Crédito

1. O usuário seleciona um plano
2. Preenche os dados do cartão
3. O frontend envia os dados para o backend
4. O backend cria o pagamento via Mercado Pago
5. O Mercado Pago processa o pagamento
6. O sistema recebe o status da transação
7. A assinatura é ativada conforme o status

##  ⚠️ Observações

- Pagamentos PIX permanecem pendentes até confirmação
- Cartão de crédito pode retornar status aprovado, recusado ou em análise
- Recomenda-se uso de ambiente **TEST** durante desenvolvimento


### 🔢 Módulo de Cálculo de Precificação

O módulo de cálculo de precificação foi desenvolvido para auxiliar empreendedores e pequenos negócios a definirem corretamente o **preço de venda** de seus produtos ou serviços, garantindo lucro e evitando prejuízos.

Ele centraliza todas as regras de negócio no backend, assegurando **segurança, consistência dos cálculos e fácil manutenção**.



#### 🧠 Como funciona

1. O usuário acessa o formulário de cálculo após autenticação e verificação de assinatura ativa.
2. Os dados de custo, despesas, impostos e margem de lucro são enviados via requisição **POST**.
3. O sistema valida todas as informações recebidas.
4. O cálculo do preço de venda é realizado no backend.
5. O resultado final é exibido ao usuário de forma clara e objetiva.


#### 📊 Itens considerados no cálculo

- Custos fixos  
- Custos variáveis  
- Percentual de impostos  
- Margem de lucro desejada  


#### 🔐 Segurança e controle de acesso

- Acesso protegido por autenticação (`auth`)
- Middleware garante que apenas usuários com assinatura ativa utilizem o cálculo
- Validações feitas exclusivamente no backend


#### Fórmulas 

- Custo Total = Σ custos
- Taxa Total (%) = Σ taxas

- Taxa Decimal = Taxa Total / 100
- Lucro Decimal = Lucro / 100

- Denominador = 1 − Taxa Decimal − Lucro Decimal

- Valor de Venda = Custo Total / Denominador

- Preço Unitário = Valor de Venda / Quantidade


### 🧩 Diagramas de Arquitetura

```text
┌──────────────┐
│   Usuário    │
│ (Navegador)  │
└──────┬───────┘
       │ Gera PIX
       ▼
┌──────────────────────┐
│ View (Blade)         │
│ JavaScript (Fetch)   │
└──────┬───────────────┘
       │ POST /payment/pix
       ▼
┌──────────────────────┐
│ PaymentController    │
│ createPix()          │
└──────┬───────────────┘
       │ SDK Mercado Pago
       ▼
┌──────────────────────┐
│ Mercado Pago API     │
│ Pagamento PIX        │
└──────┬───────────────┘
       │ QR Code
       ▼
┌──────────────────────┐
│ Retorno JSON         │
│ (base64 / texto)     │
└──────┬───────────────┘
       │
       ▼
┌──────────────────────┐
│ Exibição do QR Code  │
│ na Interface         │
└──────────────────────┘


┌──────────────┐
│   Usuário    │
│ (Navegador)  │
└──────┬───────┘
       │ Envia dados do cartão
       ▼
┌──────────────────────┐
│ View (Blade)         │
│ JavaScript / Form    │
└──────┬───────────────┘
       │ POST /payment/card
       ▼
┌──────────────────────┐
│ PaymentController    │
│ createCardPayment()  │
└──────┬───────────────┘
       │ SDK Mercado Pago
       ▼
┌──────────────────────┐
│ Mercado Pago API     │
│ Pagamento Cartão     │
└──────┬───────────────┘
       │ Status
       ▼
┌──────────────────────┐
│ Sistema              │
│ Atualiza assinatura  │
└──────────────────────┘


┌───────────────┐
│     Usuário   │
└───────┬───────┘
        │
        │ Preenche formulário de cálculo
        ▼
┌────────────────────────┐
│   View (Blade)         │
│ Formulário de Cálculo  │
└─────────┬──────────────┘
          │ POST /calcular
          ▼
┌────────────────────────┐
│   CalculoController    │
│ - Validação dos dados  │
│ - Regras de negócio    │
│ - Cálculo do preço     │
└─────────┬──────────────┘
          │
          ▼
┌────────────────────────┐
│ Camada de Lógica       │
│ (Fórmulas de cálculo)  │
└─────────┬──────────────┘
          │
          ▼
┌────────────────────────┐
│ Retorno para a View    │
│ Resultado do cálculo   │
└────────────────────────┘


# calculadoradeprecoselucro
