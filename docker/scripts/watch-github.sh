#!/bin/bash

# Configurações
REPO_URL="https://github.com/${GITHUB_REPO}.git"
BRANCH="${GITHUB_BRANCH:-main}"
CHECK_INTERVAL=300  # 5 minutos

# Função para verificar atualizações
check_updates() {
    echo "Verificando atualizações em ${REPO_URL} branch ${BRANCH}..."
    
    # Clonar ou atualizar repositório
    if [ ! -d "/app/.git" ]; then
        git clone -b ${BRANCH} ${REPO_URL} /tmp/repo
        cp -r /tmp/repo/* /app/
        rm -rf /tmp/repo
    else
        cd /app
        git fetch origin ${BRANCH}
        
        LOCAL=$(git rev-parse HEAD)
        REMOTE=$(git rev-parse origin/${BRANCH})
        
        if [ "$LOCAL" != "$REMOTE" ]; then
            echo "Novas atualizações encontradas!"
            git pull origin ${BRANCH}
            
            # Reiniciar containers
            docker-compose restart web
            echo "Aplicação atualizada e reiniciada!"
        else
            echo "Nenhuma atualização encontrada."
        fi
    fi
}

# Loop principal
while true; do
    check_updates
    sleep ${CHECK_INTERVAL}
done 