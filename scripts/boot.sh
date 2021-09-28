#!/usr/bin/env bash

# todo: move to gists that can be pulled

# exit when any command fails
set -e

COMPOSER_FLAGS=${1:-""}

# Git Branch
if [ -z "$TRAVIS_BRANCH" ]; then
    BRANCH=$(git rev-parse --abbrev-ref HEAD)
else
    BRANCH="${TRAVIS_BRANCH}"
fi

# Repo name & Docker username
if [ -z "$TRAVIS_REPO_SLUG" ]; then
    REPO=$(basename -s .git "$(git remote get-url origin)")

    DOCKER_USERNAME=$(git config user.name)
else
    USER_REPO=(${TRAVIS_REPO_SLUG//// })

    DOCKER_USERNAME="${USER_REPO[0]}"
    REPO="${USER_REPO[1]}"
fi


# PHP Version
PHP_VERSION=$(php --version)
PHP_VERSION=${PHP_VERSION:4:3}

# Allow for a php-composer image tag argument
PHP_COMPOSER_TAG=${2-$PHP_VERSION}

# Export Docker image Tag
TAG="$PHP_COMPOSER_TAG-$BRANCH${COMPOSER_FLAGS:8}"
export TAG

docker-compose down -v --remove-orphans

echo "Building image: ${DOCKER_USERNAME}/${REPO}:${TAG}"
docker build -t "${DOCKER_USERNAME}/${REPO}:${TAG}" \
    --build-arg php_composer_tag="${PHP_COMPOSER_TAG}" \
    --build-arg composer_flags="${COMPOSER_FLAGS}" \
     .

docker-compose up -d

docker logs -f "${REPO}"

while true; do
    if [[ $(docker inspect -f '{{.State.Running}}' "${REPO}") != true ]]; then
        break
    else
        echo "'package' container is still running... waiting 3 secs then checking again..."
        sleep 3
    fi
done

# Confirm it exited with code 0
docker inspect -f '{{.State.ExitCode}}' "${REPO}" > /dev/null 2>&1

# Confirm the image exists
docker image inspect "${DOCKER_USERNAME}/${REPO}:${TAG}" > /dev/null 2>&1
