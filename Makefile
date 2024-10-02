# Define your default target
.PHONY: all
all: setup

# Setup the application by migrating the database and seeding data
.PHONY: setup
setup: migrate seed

# Run Laravel migrations
.PHONY: migrate
migrate:
	@echo "Running migrations..."
	@php artisan migrate --force

# Run Laravel seeders
.PHONY: seed
seed:
	@echo "Seeding the database..."
	@php artisan db:seed --force

# Optionally define a command to reset the database (drop all tables and re-run migrations and seeds)
.PHONY: reset
reset:
	@echo "Resetting the database..."
	@php artisan migrate:fresh --force
	@$(MAKE) seed
