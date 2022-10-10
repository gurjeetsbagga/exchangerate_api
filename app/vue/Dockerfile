# base image
FROM node:12.2.0-alpine as frontend

# set working directory
WORKDIR /var/www

# add `/app/node_modules/.bin` to $PATH
ENV PATH /var/www/node_modules/.bin:$PATH

# To handle 'not get uid/gid'
RUN npm config set unsafe-perm true

# install and cache app dependencies
COPY package*.json ./

RUN npm install
#RUN npm install @vue/cli@3.7.0 -g

# copy project files and folders to the current working directory (i.e. 'app' folder)
COPY . .

# build app for production with minification
RUN npm run build

CMD [ "npm", "run", "serve" ]

#EXPOSE 8080
#CMD [ "http-server", "dist" ]