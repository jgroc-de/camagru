#!/bin/bash

url="/getSettings"
pseudo="test"
pass="Test00"
email="lol@lol.com"
pseudobad="testtest"

testa="$url;&;403"
test0="/login;&pseudo=$pseudo&password=$pass;200"
test1="$url;&pseudo=$pseudo;200"
test2="$url;&pseudo=$pseudobad;200"
test3="$url;&email=$email;200"
test4="$url;&pseudo=&email=$email;200"
test5="/login;&pseudo=$pseudo&password=$pass;401"
test6="$url;&pseudo=$pseudo&email=$email;200"
test7="/logout;&;200"
test8="$url;&pseudo=$pseudo&email=$email;403"

tests=( $testa $testb $test0 $test1 $test1a $test1b $test2 $test3 $test3a $test4 $test5 $test6 $test7 $test8 )
j=0

printf "*** \033[32mtests\033[0m *** \n"
success=0
total=${#tests[@]}
bool=0
for i in ${tests[@]}; do
	array=(${i//;/ })
	response=$(curl -w "%{http_code}\n"\
		-o /dev/null\
		-c cookieMonster\
		-b cookieMonster\
		-s "http://localhost:8080${array[0]}"\
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
