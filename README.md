## Wallet Manager Api

### Build Image

```sh
docker build -t Wallet Manager:1.0 .
```
---

### Run Docker image

```sh
docker run -d  \
    -p 80:80 \
    -e APP_DEBUG=false \

    wallet_manager:1.0
```
---

### Environment file
```sh
copy .env-example content into a new .env file
```
---
