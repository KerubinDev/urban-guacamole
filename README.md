# Sistema SaaS de E-commerce

Este é um sistema SaaS de e-commerce robusto e completo, desenvolvido com PHP, JavaScript, jQuery e Vue.js. O sistema permite que lojistas criem suas lojas online com planos gratuitos ou pagos.

## Características Principais

- Sistema de multi-tenancy para múltiplas lojas
- Integração com Stripe para pagamentos de assinatura
- Integração com PIX para pagamentos de produtos
- Sistema de plugins extensível
- Auto-deploy via Docker
- Sistema de logs e monitoramento
- Painel administrativo completo

## Requisitos

- Docker e Docker Compose
- PHP 8.2 ou superior
- MySQL 8.0
- Redis
- Composer

## Instalação

1. Clone o repositório:
```bash
git clone https://github.com/seu-usuario/ecommerce-saas.git
cd ecommerce-saas
```

2. Copie o arquivo de ambiente:
```bash
cp .env.example .env
```

3. Configure as variáveis de ambiente no arquivo `.env`

4. Inicie os containers Docker:
```bash
docker-compose up -d
```

5. Instale as dependências:
```bash
docker-compose exec web composer install
```

6. Execute as migrações do banco de dados:
```bash
docker-compose exec web php artisan migrate
```

## Estrutura do Projeto

```
.
├── app/
│   ├── core/           # Núcleo do sistema
│   ├── plugins/        # Plugins do sistema
│   ├── config/         # Configurações
│   └── public/         # Arquivos públicos
├── docker/
│   ├── Dockerfile     # Dockerfile principal
│   └── scripts/       # Scripts Docker
├── logs/              # Logs do sistema
├── tests/             # Testes automatizados
├── .env.example       # Exemplo de configuração
├── composer.json      # Dependências PHP
└── docker-compose.yml # Configuração Docker
```

## Sistema de Plugins

O sistema possui um robusto sistema de plugins que permite estender suas funcionalidades. Para criar um plugin:

1. Crie uma pasta com o nome do seu plugin em `app/plugins/`
2. Crie um arquivo `plugin.php` com a estrutura básica:

```php
return [
    'name' => 'NomeDoPlugin',
    'version' => '1.0.0',
    'hooks' => [
        'hook_name' => function($params) {
            // Sua lógica aqui
            return $params;
        }
    ]
];
```

### Hooks Disponíveis

- `before_product_create`
- `after_product_create`
- `before_order_create`
- `after_order_create`
- `before_user_create`
- `after_user_create`

## Auto Deploy

O sistema possui um container Docker dedicado para monitorar alterações no repositório Git. Quando uma alteração é detectada:

1. O código é atualizado automaticamente
2. As dependências são reinstaladas
3. As migrações são executadas
4. O sistema é reiniciado

## Desenvolvimento

Para desenvolver novas funcionalidades:

1. Crie um branch para sua feature:
```bash
git checkout -b feature/nova-funcionalidade
```

2. Desenvolva e teste sua funcionalidade

3. Envie um Pull Request

## Logs e Monitoramento

Os logs do sistema são armazenados em `/var/www/logs/` e podem ser acessados via:

```bash
docker-compose exec web tail -f /var/www/logs/app.log
```

## Suporte

Para suporte, abra uma issue no repositório do GitHub ou entre em contato com a equipe de desenvolvimento.

## Licença

Este projeto está licenciado sob a licença MIT - veja o arquivo LICENSE para detalhes. # urban-guacamole
# urban-guacamole
