<?php

return [
    'name' => 'ExamplePlugin',
    'version' => '1.0.0',
    'description' => 'Um plugin de exemplo para demonstrar o sistema de plugins',
    'author' => 'Sistema E-commerce SaaS',
    'hooks' => [
        'before_product_create' => function($params) {
            // Exemplo de validação antes de criar um produto
            if (empty($params['name'])) {
                throw new \Exception('O nome do produto é obrigatório');
            }
            
            // Exemplo de modificação dos dados antes de criar
            $params['name'] = trim($params['name']);
            return $params;
        },
        
        'after_product_create' => function($params) {
            // Exemplo de ação após criar um produto
            $logger = \Core\Log\Logger::getInstance();
            $logger->info('Novo produto criado', [
                'product_id' => $params['id'],
                'product_name' => $params['name']
            ]);
            
            // Exemplo de notificação
            // Aqui você poderia enviar um email, notificação, etc.
            return $params;
        },
        
        'before_order_create' => function($params) {
            // Exemplo de validação antes de criar um pedido
            if ($params['total_amount'] <= 0) {
                throw new \Exception('O valor total do pedido deve ser maior que zero');
            }
            return $params;
        },
        
        'after_order_create' => function($params) {
            // Exemplo de ação após criar um pedido
            $logger = \Core\Log\Logger::getInstance();
            $logger->info('Novo pedido criado', [
                'order_id' => $params['id'],
                'total_amount' => $params['total_amount']
            ]);
            return $params;
        }
    ],
    'config' => [
        'enable_notifications' => true,
        'notification_email' => 'admin@example.com'
    ]
]; 