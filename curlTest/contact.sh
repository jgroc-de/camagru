#!/bin/bash

url="/contact"
pseudo1="testRoot"
pass1="testRoot0"
pseudo="test42"
pseudobad1=""
pseudolong="test43aaaaaaaaaaaaaaaaaaaaiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"
message="troll"
messagebad=""
email="lol@lol.com"
emailbad1="lol@lol."
emailbad2="lol@.com"
subject="lol"
subjectbad=""

data=(
	"{\"pseudo\":\"$pseudo1\",\"password\":\"$pass1\"}"
	"{\"name\":\"$pseudo\",\"subject\":\"$subject\",\"message\":\"$message\",\"email\":\"$email\"}"
	"{}"
	"{\"name\":\"$pseudo\",\"subject\":\"$subject\",\"message\":\"$message\",\"email\":\"$email\"}"
	"{}"
	"{\"name\":\"$pseudo\",\"subject\":\"$subject\",\"message\":\"$message\"}"
	"{\"subject\":\"$subject\",\"message\":\"$message\",\"email\":\"$email\"}"
	"{\"name\":\"$pseudolong\",\"subject\":\"$subject\",\"message\":\"$message\",\"email\":\"$email\"}"
	"{\"name\":\"$pseudobad1\",\"subject\":\"$subject\",\"message\":\"$message\",\"email\":\"$email\"}"
	"{\"name\":\"$pseudo\",\"subject\":\"$subject\",\"message\":\"$messagebad\",\"email\":\"$email\"}"
	"{\"name\":\"$pseudo\",\"subject\":\"$subject\",\"message\":\"$message\",\"email\":\"$emailbad1\"}"
	"{\"name\":\"$pseudo\",\"subject\":\"$subject\",\"message\":\"$message\",\"email\":\"$emailbad2\"}"
	"{\"name\":\"$pseudo\",\"subject\":\"$subjectbad\",\"message\":\"$message\",\"email\":\"$email\"}"
)

tests=(
	"/login;200;POST"
	"$url;200"
	"/login;200;DELETE"
	"$url;200"
	"$url;400"
	"$url;400"
	"$url;400"
	"$url;400"
	"$url;400"
	"$url;400"
	"$url;400"
	"$url;400"
	"$url;400"
)

j=0
printf "*** \033[32mtests\033[0m *** \n"
success=0
total=${#tests[@]}
bool=0
for i in ${tests[@]}; do
	array=(${i//;/ })
	json=${data[$j]}
	method="GET"
	if [ -z ${array[2]} ]; then
		method="POST"
	else
		method=${array[2]}
	fi
	response=$(
	curl -w "%{http_code}\n"\
		-o /dev/null\
		-c cookieMonster\
		-b cookieMonster\
		-s "http://localhost:8080${array[0]}"\
		-H 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:64.0) Gecko/20100101 Firefox/64.0'\
		-H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'\
		-H 'Accept-Language: fr,fr-FR;q=0.8,en-US;q=0.5,en;q=0.3'\
		--compressed\
		-H 'Content-type: application/json' \
		-H 'Referer: http://localhost:8080/'\
		-H 'DNT: 1' -H 'Connection: keep-alive'\
		-H 'Upgrade-Insecure-Requests: 1'\
		-H 'Cookie: XDEBUG_SESSION=XDEBUG'\
		-X $method\
		-d $json\
		)
	printf "test $j: ";
	if [ $response -eq ${array[1]} ]; then
		out="32mOK"
		((success++))
	else
		out="31mFAIL"
		bool=1
	fi
	printf "$i:[\033[%s\033[0m]\n" "$out: $response";
	if [ $bool -eq 1 ];then
		echo $response
		bool=0
	fi
	((j++))
done
printf "\n*** \033[32mend\033[0m *** \n"
rm cookieMonster
printf "\n\033[42mtests succeed\033[0m : $success/$total\n"
if [ $success -ne $total ]; then
	printf "\n\033[41mtests failed\033[0m : $((total-success))/$total\n"
    exit 1
fi
exit 0
