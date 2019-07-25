#!/bin/bash
if [ $# -eq 0 ]; then
	printf "usage: $0 dir/*\n\twhere dir is the directory containing your tests\n"
else
	for file in $@; do
		printf "\n*** \033[32mbegin $file\033[0m ***\n"
		./$file
        TEST=$?
        echo "test"
        echo $TEST
        if [ $TEST -ne 0 ]
        then
            exit 1
        fi
	done
fi
exit 0
