#!/bin/bash

url="/picture"
pseudo="testRoot"
pass="testRoot0"
pseudo2="other"
pass2="testOther1"
id="1"
idbad1="2000000"
idbad2="-1"
idbad3="aieuaie"
idbad4="=123"
idbad5="123=aui"
idbad6="13=aui"
idbad7="15"
title="lolauie89"
title2="lolauie"
titlebad=""
titlelong="aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"

data=(
    "{\"id\":\"$id\",\"title\":\"$title\"}"
    "{\"pseudo\":\"$pseudo\",\"password\":\"$pass\"}"
    "{\"id\":\"$id\",\"title\":\"$title\"}"
    "{\"\"}"
    "{\"id\":\"$idbad1\",\"title\":\"$title\"}"
    "{\"id\":\"$idbad1\",\"title\":\"$title\"}"
    "{\"id\":\"$idbad2\",\"title\":\"$title\"}"
    "{\"id\":\"$idbad3\",\"title\":\"$title\"}"
    "{\"id\":\"$idbad4\",\"title\":\"$title\"}"
    "{\"id\":\"$idbad5\",\"title\":\"$title\"}"
    "{\"id\":\"$idbad6\",\"title\":\"$title\"}"
    "{\"id\":\"$idbad7\",\"title\":\"$title\"}"
    "{\"id\":\"$id\",\"title\":\"$titlebad\"}"
    "{\"id\":\"$id\",\"title\":\"$titlelong\"}"
    "{\"id\":\"\",\"title\":\"$title\"}"
    "{\"id\":\"$id\",\"title\":\"$title\"}"
    "{\"id\":\"$id\",\"title\":\"$title2\"}"
    "{\"\"}"
    "{\"pseudo\":\"$pseudo2\",\"password\":\"$pass2\"}"
    "{\"id\":\"$id\",\"title\":\"$title\"}"
    "{\"\"}"
    )

tests=(
    "$url/$id;403"
    "/login;200;POST"
    "$url/$id;200"
    "$url;400"
    "$url/$idbad1;404"
    "$url/$idbad2;400"
    "$url/$idbad3;400"
    "$url/$idbad4;400"
    "$url/$idbad5;404"
    "$url/$idbad6;404"
    "$url/$idbad7;404"
    "$url/$id;404"
    "$url/$id;400"
    "$url/$id;400"
    "$url/$id;404"
    "$url/$id;404"
    "$url/$id;200"
    "/login;200;DELETE"
    "/login;200;POST"
    "$url/$id;403"
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

tests=( $testa $testb $testc $test0 $test1 $test1a $test1b $test2 $test3 $test3a $test4 $test5 $test6 $test7 $test8 $test9 $test10 $test11 $test12 $test13 $test14 $test15 $test16 $test17 $test18 )
j=0

printf "*** \033[32mtests\033[0m *** \n"
success=0
total=${#tests[@]}
bool=0
for i in ${tests[@]}; do
	array=(${i//;/ })
	response=$(curl -w "%{http_code}\n\"\
		-o /dev/null\
		-c cookieMonster\
		-b cookieMonster\
		-s "http://localhost:8080${array[0]}\"\
		-H 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:64.0) Gecko/20100101 Firefox/64.0'\
		-H 'Accept: */*'\
		-H 'Accept-Language: fr,fr-FR;q=0.8,en-US;q=0.5,en;q=0.3'\
		--compressed\
		-H 'Referer: http://localhost:8080/'\
		-H 'Content-type: application/x-www-form-urlencoded'\
		-H 'DNT: 1' -H 'Connection: keep-alive'\
		--data ${array[1]})
	printf "test $j: ";
	if [ $response -eq ${array[2]} ]; then
		out="32mOK"
		((success++))
	else
		out="31mFAIL!!!"
		bool=1
	fi
	printf "$i:[\033[%s\033[0m]\n" $out;
	if [ $bool -eq 1 ];then
		echo $response
		bool=0
	fi
	((j++))
done
printf "\n\033[42mtests succeed\033[0m : $success/$total\n"
if [ $success -ne $total ]; then
	printf "\n\033[41mtests failed\033[0m : $((total-success))/$total\n"
fi
printf "\n*** \033[32mend\033[0m *** \n"
rm cookieMonster;
