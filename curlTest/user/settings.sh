#!/bin/bash

url="/user"
pseudo="testRoot"
pass="testRoot0"
pseudo2="testtest"
pass2="Test00"
pseudolong="test43aaaaaaaaaaaaaaaaaaaaiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"
email="lol@lol.com"
emailbad="lol@lol.a"

data=(
    "{\"pseudo\":\"$pseudo\",\"email\":\"$email\"}"
	"{\"pseudo\":\"$pseudo\",\"password\":\"$pass\"}"
	"{}"
	"{\"pseudo\":\"$pseudo\"}"
	"{\"email\":\"$email\"}"
	"{\"alert\":\"on\"}"
	"{\"pseudo\":\"\",\"email\":\"$email\"}"
	"{\"pseudo\":\"$pseudolong\",\"email\":\"$email\"}"
	"{\"pseudo\":\"$pseudo\",\"email\":\"\"}"
	"{\"pseudo\":\"$pseudo\",\"email\":\"$emailbad\"}"
	"{\"pseudo\":\"$pseudo\",\"email\":\"$email\",\"lolo\":\"lol\"}"
	"{\"pseudo\":\"$pseudo\",\"email\":\"$email\",\"alert\":\"lol\"}"
	"{\"pseudo\":\"$pseudo\",\"email\":\"$email\",\"alert\":\"troll\"}"
	"{\"pseudo\":\"$pseudo\",\"email\":\"$email\"}"
	"{\"pseudo\":\"$pseudo2\",\"email\":\"$email\"}"
	"{}"
	"{\"pseudo\":\"$pseudo2\",\"password\":\"$pass\"}"
	"{\"pseudo\":\"$pseudo\",\"email\":\"$email\",\"alert\":\"1\"}"
	"{\"pseudo\":\"$pseudo\",\"email\":\"$email\",\"alert\":\"0\"}"
	"{}"
	"{\"pseudo\":\"$pseudo\",\"password\":\"$pass\"}"
	"{}"
)

tests=(
	"$url;403"
	"/login;200;POST"
	"$url;400"
	"$url;400"
	"$url;400"
	"$url;400"
	"$url;400"
	"$url;400"
	"$url;400"
	"$url;400"
	"$url;200"
	"$url;200"
	"$url;200"
	"$url;200"
	"$url;200"
	"/login;200;DELETE"
	"/login;200;POST"
	"$url;200"
	"$url;200"
	"/login;200;DELETE"
	"/login;200;POST"
	"/login;200;DELETE"
)

j=0
printf "*** \033[32mtests\033[0m *** \n"
success=0
total=${#tests[@]}
bool=0
for i in ${tests[@]}; do
	array=(${i//;/ })
	json=${data[$j]}
	method="PATCH"
	if [ -z ${array[2]} ]; then
		method="PATCH"
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
