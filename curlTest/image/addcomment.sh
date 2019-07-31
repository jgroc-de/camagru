#!/bin/bash

url="/comment"
pseudo="testRoot"
pass="testRoot0"
pseudo2="other"
pass2="testOther1"
msg="lol"
message="lol2"
msgbad=""
id="1"
idbad1="2000000"
idbad2="-1"
idbad3="aieuaie"

data=(
    "{\"id\":\"$id\",\"comment\":\"$msg\"}"
    "{\"pseudo\":\"$pseudo\",\"password\":\"$pass\"}"
    "{\"id\":\"$id\",\"comment\":\"$msg\"}"
    "{}"
    "{\"id\":\"$id\"}"
    "{\"comment\":\"$msg\"}"
    "{\"id\":\"\",\"comment\":\"$email\"}"
    "{\"id\":\"$id\",\"comment\":\"\"}"
    "{\"id\":\"$idbad1\",\"comment\":\"$msg\"}"
    "{\"id\":\"$idbad2\",\"comment\":\"$msg\"}"
    "{\"id\":\"$idbad3\",\"comment\":\"$msg\"}"
    "{\"id\":\"$id\",\"comment\":\"$msgbad\"}"
    "{\"id\":\"$id\",\"comment\":\"$msg$msg\"}"
    "{\"id\":\"$id\",\"comment\":\"$message\"}"
    "{}"
    "{\"pseudo\":\"$pseudo2\",\"password\":\"$pass2\"}"
    "{\"id\":\"$id\",\"comment\":\"$message\"}"
    "{}"
    "{}"
    "{\"pseudo\":\"$pseudo\",\"password\":\"$pass\"}"
    "{\"id\":\"$id\",\"comment\":\"$message\"}"
    "{\"id\":\"$idbad1\",\"comment\":\"$message\"}"
    "{}"
    "{}"
    "{}"
    "{\"id\":\"$id\",\"comment\":\"$msg\"}"
    )

tests=(
    "$url/$id;403"
    "/login;200;POST"
    "$url/$id;201"
    "$url/;400"
    "$url/$id;400"
    "$url/;400"
    "$url/;400"
    "$url/$id;400"
    "$url/$idbad1;404"
    "$url/$idbad2;400"
    "$url/$idbad3;400"
    "$url/$id;400"
    "$url/$id;201"
    "$url/$id;200;PATCH"
    "/login;200;DELETE"
    "/login;200;POST"
    "$url/$id;403;PATCH"
    "$url/$id;403;DELETE"
    "/login;200;DELETE"
    "/login;200;POST"
    "$url/$idbad1;404;PATCH"
    "$url/$id;200;DELETE"
    "$url/$idbad1;404;DELETE"
    "/login;200;DELETE"
    "$url/$id;403"
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
		#-o /dev/null\
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
