#!/bin/bash
if [ $# -eq 0 ]; then
	printf "usage: $0 dir/*\n\twhere dir is the directory containing your tests\n"
else
	for file in $@; do
		printf "\n*** \033[32mbegin $file\033[0m ***\n"
		bash $file
	done
fi
