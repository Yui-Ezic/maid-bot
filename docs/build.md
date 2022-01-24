# Сборка проекта с помощью docker

## Linux
Для сборки проекта с помощью докер достаточно запустить `make init` и магия все сделает за вас.

## Windows wsl2
Установите docker desktop и выберите wsl2 в качестве бекграунд сервера для докера.
Введите `wsl` в командной строке находясь в директории с проектом. 
Дальше осталось запустить `make init` и готово. 

Если у вас возникла ошибка `failed to solve with frontend dockerfile.v0: failed to create LLB definition: failed to 
authorize: rpc error: code = Unknown desc = failed to fetch anonymous token`, то попробуйте отключить docker buildkit. 
Для этого перед 'make init' нужно выполнить следующие команды:

```bash
user@desktop:~$ export DOCKER_BUILDKIT=0
user@desktop:~$ export COMPOSE_DOCKER_CLI_BUILD=0
```