FROM nginx:1.19

ARG UID
ARG APP_NAME

RUN adduser -u ${UID} --disabled-password --gecos "" appuser

COPY nginx.conf  /etc/nginx/
COPY default.conf /etc/nginx/conf.d/
RUN echo "upstream php-upstream { server ${APP_NAME}_php:9000; }" > /etc/nginx/conf.d/upstream.conf

EXPOSE 80
EXPOSE 443
