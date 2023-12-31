FROM ubuntu:22.04 as app

COPY --from=spidermane/trunk * /trunk

ENV DEBIAN_FRONTEND=noninteractive
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV APP=/app

WORKDIR "$APP"

ARG TZ="UTC"
ENV TZ="$TZ"
RUN /trunk/setups/timezone

ARG LANG="en_US.UTF-8"
ENV LANG="$LANG"
RUN /trunk/setups/language

ARG PHP_VERSION=8.0
RUN /trunk/provisions/php --version "$PHP_VERSION" --dev true

RUN /trunk/setups/entrypoint
ENTRYPOINT [ "docker-entrypoint" ]

RUN /trunk/actions/cleanup

### build with enhanced interactive features ###
FROM app as app-interactive

COPY --from=spidermane/trunk * /trunk

ARG UNMINIMIZE=false
RUN /trunk/actions/unminimize "$UNMINIMIZE"

ARG LOCAL_REPOSITORY=/studio
RUN /trunk/provisions/studio --path "$LOCAL_REPOSITORY"

ARG GIT_USER
ARG GIT_EMAIL
ARG GIT_DEFAULT_BRANCH=master
ARG GIT_INSTALL_GCM=false
RUN /trunk/provisions/git --user "$GIT_USER" --email "$GIT_EMAIL" --default-branch "$GIT_DEFAULT_BRANCH" --install-gcm "$GIT_INSTALL_GCM"

RUN /trunk/bundles/shell
RUN /trunk/provisions/github

RUN /trunk/actions/cleanup
