SHELL = /bin/sh

DOCKER ?= $(shell which docker)
VOLUME := /srv
DOCKER_RUN_BASE := ${DOCKER} run --rm -t -v $$(pwd):${VOLUME} -w ${VOLUME}
DOCKER_RUN := docker-compose run --rm test

PREFER_LOWEST ?=

.PHONY: build build-update composer-% clean help run
.PHONY: lint lint-fix
.PHONY: test test-unit test-integration test-lowest test-matrix test-coverage test-coverage-html test-coverage-clover

.SILENT: help

# Building

build: ## Download the dependencies then build the image :rocket:.
	make 'composer-install --prefer-dist --optimize-autoloader'

build-update: ## Update all dependencies
	make 'composer-update --prefer-dist --optimize-autoloader ${PREFER_LOWEST}'

composer-%: ## Run a composer command, `make "composer-<command> [...]"`.
	${DOCKER} run -t --rm \
        -v $$(pwd):/usr/src/app \
        -v ~/.composer:/root/.composer \
        -v ~/.ssh:/root/.ssh:ro \
        graze/composer --ansi --no-interaction $* $(filter-out $@,$(MAKECMDGOALS))

# Testing

test: ## Run the unit and integration testsuites.
test: lint test-unit test-integration

lint: ## Run phpcs against the code.
	${DOCKER_RUN} vendor/bin/phpcs -p --warning-severity=0 src/ tests/

lint-fix: ## Run phpcsf and fix possible lint errors.
	${DOCKER_RUN} vendor/bin/phpcbf -p src/ tests/

test-unit: ## Run the unit testsuite.
	${DOCKER_RUN} vendor/bin/phpunit --testsuite unit

test-integration: ## Run the integration testsuite.
	${DOCKER_RUN} vendor/bin/phpunit --testsuite integration

test-lowest: ## Test using the lowest possible versions of the dependencies
test-lowest: PREFER_LOWEST=--prefer-lowest
test-lowest: build-update test

test-matrix: ## Run the unit tests against multiple targets.
	${MAKE} DOCKER_RUN="${DOCKER_RUN_BASE} php:5.5-alpine" PREFER_LOWEST=--prefer-lowest build-update test
	${MAKE} DOCKER_RUN="${DOCKER_RUN_BASE} php:5.6-alpine" PREFER_LOWEST=--prefer-lowest build-update test
	${MAKE} DOCKER_RUN="${DOCKER_RUN_BASE} php:7.0-alpine" PREFER_LOWEST=--prefer-lowest build-update test
	${MAKE} DOCKER_RUN="${DOCKER_RUN_BASE} php:7.1-alpine" PREFER_LOWEST=--prefer-lowest build-update test
	${MAKE} DOCKER_RUN="${DOCKER_RUN_BASE} hhvm/hhvm:latest" PREFER_LOWEST=--prefer-lowest build-update test
	${MAKE} DOCKER_RUN="${DOCKER_RUN_BASE} php:5.5-alpine" build-update test
	${MAKE} DOCKER_RUN="${DOCKER_RUN_BASE} php:5.6-alpine" build-update test
	${MAKE} DOCKER_RUN="${DOCKER_RUN_BASE} php:7.0-alpine" build-update test
	${MAKE} DOCKER_RUN="${DOCKER_RUN_BASE} php:7.1-alpine" build-update test
	${MAKE} DOCKER_RUN="${DOCKER_RUN_BASE} hhvm/hhvm:latest" build-update test

test-coverage: ## Run all tests and output coverage to the console.
	${DOCKER_RUN} phpdbg7 -qrr vendor/bin/phpunit --coverage-text

test-coverage-html: ## Run all tests and output coverage to html.
	${DOCKER_RUN} phpdbg7 -qrr vendor/bin/phpunit --coverage-html=./tests/report/html

test-coverage-clover: ## Run all tests and output clover coverage to file.
	${DOCKER_RUN} phpdbg7 -qrr vendor/bin/phpunit --coverage-clover=./tests/report/coverage.clover

# Help

help: ## Show this help message.
	echo "usage: make [target] ..."
	echo ""
	echo "targets:"
	egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'
