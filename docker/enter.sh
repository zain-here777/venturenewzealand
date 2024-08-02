#!/bin/bash

# Navigate to the project root directory
cd ..

# Gain entrance into the running container's environment
docker exec -it $(docker ps -qf "name=venturenewzealand_web") /bin/bash
