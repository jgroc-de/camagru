#!/bin/bash
printf "*** --> \033[31mWarning!!\033[0m: test should be run on port \033[42m8080\033[0m!!<-- ***\n"

files=(\
    "signup.sh"
    "login.sh"
    "createPic.sh"
    "get.sh"
    )
for file in ${files[@]}; do
    printf "\n*** \033[32mbegin $file\033[0m ***\n"
    ./curlTest/$file
    TEST=$?
    if [ $TEST -ne 0 ]; then
        exit 1
    fi
done
exit 0
