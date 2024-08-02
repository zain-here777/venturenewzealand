#!/bin/bash

# Navigate to the project root directory
cd ..

# Launch the docker-compose with the project name
docker-compose -p venturenewzealand up --build -d
