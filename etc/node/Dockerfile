FROM node:lts-alpine3.10

WORKDIR /app

COPY package.json ./

ADD ./ ./

RUN npm install yarn && \
    yarn install --dev --ignore-optional --force --silent && \
    yarn build

