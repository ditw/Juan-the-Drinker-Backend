#! /bin/bash

# System update
apt update;

#  Git installation
apt install git;
git --version;

# System libraries
sudo apt install libz-dev libssl-dev libcurl4-gnutls-dev libexpat1-dev gettext cmake gcc;

# Docker isntallation
sudo curl -fsSL https://get.docker.com/ | sh;
sudo groupadd docker;
sudo usermod -aG docker $USER;
sudo systemctl restart docker;

# Docker compose installation
sudo apt install docker-compose;
mkdir -p ~/.docker/cli-plugins/;
curl -SL https://github.com/docker/compose/releases/download/v2.3.3/docker-compose-linux-x86_64 -o ~/.docker/cli-plugins/docker-compose;
chmod +x ~/.docker/cli-plugins/docker-compose;
docker compose version;