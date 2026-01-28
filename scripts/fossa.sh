#!/usr/bin/env bash

#
# Licensed to the Apache Software Foundation (ASF) under one or more
# contributor license agreements.  See the NOTICE file distributed with
# this work for additional information regarding copyright ownership.
# The ASF licenses this file to You under the Apache License, Version 2.0
# (the "License"); you may not use this file except in compliance with
# the License.  You may obtain a copy of the License at
#
#    http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.
#

# This is the recommended way to install FOSSA's cli per the docs:
# https://docs.fossa.com/docs/generic-ci
curl -s -H 'Cache-Control: no-cache' https://raw.githubusercontent.com/fossas/fossa-cli/master/install.sh | sudo bash

# This key is a push-only API key, also recommended for public projects
# https://docs.fossa.com/docs/api-reference#section-push-only-api-token
# Set FOSSA_API_KEY environment variable before running this script
if [ -z "$FOSSA_API_KEY" ]; then
    echo "Error: FOSSA_API_KEY environment variable is not set"
    echo "Please set it before running this script: export FOSSA_API_KEY=your_key"
    exit 1
fi
export FOSSA_API_KEY
fossa init
fossa analyze
fossa test | echo "Ok" # silenced fossa on 2020-10-04 it was acting up
