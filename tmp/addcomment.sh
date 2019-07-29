#!/bin/bash

url="/addComment"
pseudo="test"
pass="Test00"
msg="lol"
msgbad=""
id="13"
idbad1="2000000"
idbad2="-1"
idbad3="aieuaie"

testa="$url;&id=$id&comment=$msg;403"
testb="/login;&pseudo=$pseudo&password=$pass;200"
testc="$url;&id=$id&comment=$msg;200"
test0="$url;&;401"
test1="$url;&id=$id;401"
test2="$url;&comment=$msg;401"
test4="$url;&id=&comment=$email;401"
test5="$url;&id=$id&comment=;401"
test6="$url;&id=$idbad1&comment=$msg;404"
test7="$url;&id=$idbad2&comment=$msg;401"
test8="$url;&id=$idbad3&comment=$msg;401"
test9="$url;&id=$id&comment=$msgbad;401"
test10="$url;&id=$id&comment=$msg$msg;200"
test11="/logout;&;200"
test12="$url;&id=$id&comment=$msg;403"

testa="$url;&id=$id&comment=$msg;403"
testb="/login;&pseudo=$pseudo&password=$pass;200"
testc="$url;&id=$id&comment=$msg;200"
test0="$url;&;401"
test1="$url;&id=$id;401"
test2="$url;&comment=$msg;401"
test4="$url;&id=&comment=$email;401"
test5="$url;&id=$id&comment=;401"
test6="$url;&id=$idbad1&comment=$msg;404"
test7="$url;&id=$idbad2&comment=$msg;401"
test8="$url;&id=$idbad3&comment=$msg;401"
test9="$url;&id=$id&comment=$msgbad;401"
test10="$url;&id=$id&comment=$msg$msg;200"
test11="/logout;&;200"
test12="$url;&id=$id&comment=$msg;403"

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
