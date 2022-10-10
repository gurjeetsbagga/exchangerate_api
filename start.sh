docker compose up -d

cd app/vue
echo "Running BUILD"
docker build --no-cache -t era:dev .

echo "By default Accepting 8080 port"
docker run -v ${PWD}:/app -v /app/node_modules -p 8080:8080 --rm era:dev
