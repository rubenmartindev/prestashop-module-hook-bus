-include .env
export

PS_VERSION    ?= 9
PS_HTTP_PORT  ?= 80

COMPOSE_PROJECT_NAME  := prestashop-module-hook-bus-$(subst .,-,$(PS_VERSION))
COMPOSE               := docker compose --project-name $(COMPOSE_PROJECT_NAME)

ARGS = $(filter-out $@, $(MAKECMDGOALS))

.DEFAULT_GOAL = help
.PHONY        : help build up down restart logs ps shell

## ——  🐳 🐧 The Docker Makefile 🐧 🐳 ——————————————————————————————————

help: ## Show this help
	@grep -E '(^[a-zA-Z0-9\./_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

up: ## Start the PrestaShop instance
	@$(COMPOSE) up --wait --detach $(ARGS)

down: ## Stop and remove the PrestaShop instance
	@$(COMPOSE) down --remove-orphans $(ARGS)

restart: ## Restart the PrestaShop instance
	@$(COMPOSE) restart $(ARGS)

logs: ## Follow the instance logs
	@$(COMPOSE) logs --follow $(ARGS)

ps: ## Show the instance status
	@$(COMPOSE) ps $(ARGS)

shell: ## Open a shell in the PrestaShop container
	@$(COMPOSE) exec prestashop bash $(ARGS)

%:
	@:
