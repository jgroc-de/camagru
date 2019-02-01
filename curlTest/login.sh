#!/bin/bash

url="login"
pseudo="test"
password="Test00"

testa="logout;&;403"
test0="$url;&;401"
test1="$url;&pseudo=$pseudo&password=aie;401"
test2="$url;&pseudo=$pseudo;401"
test3="$url;&password=$password;401"
test4="$url;&pseudo=&password=$password;401"
test5="$url;&pseudo=$pseudo&password=;401"
test6="$url;&pseudo=$pseudo.1&password=$password;401"
test7="$url;&pseudo=$pseudo&password=$password.1;401"
test8="$url;&pseudo=$pseudo&password=$password&lol=aauieauie;200"
test9="$url;&pseudo=$pseudo&password=$password;401"
test10="logout;&;200"

tests=( $testa $test0 $test1 $test2 $test3 $test4 $test5 $test6 $test7 $test8 $test9 $test10 )
j=0

printf "*** \033[32mtests\033[0m *** \n"
success=0
bool=0
total=${#tests[@]}
for i in ${tests[@]}; do
	array=(${i//;/ })
	response=$(curl -w "%{http_code}\n"\
		-o /dev/null\
		-c cookieMonster\
		-b cookieMonster\
		-s "http://localhost:8080/${array[0]}"\
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
rm cookieMonster;
printf "\n*** \033[32mend\033[0m *** \n"
