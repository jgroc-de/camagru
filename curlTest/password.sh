#!/bin/bash

url="/password"
pseudo="test"
pass="Test00"
pass2="Test01"
passShort="Te00"
passbad1="test00"
passbad2="TestGG"
passbad3="ai786est00"
passbad4="TEST00"
email="lol@lol.com"
pseudobad="testtest"

testa="$url;&password=$pass;403"
test0="/login;&pseudo=$pseudo&password=$pass;200"
test1="$url;&pseudo=$pseudo;401"
test2="$url;&password=$pass;200"
test3="$url;&pseudo=$pseudo&password=$pass;200"
test4="$url;&pseudo=$pseudo&email=$email;401"
test5="$url;password=$passShort;401"
test6="$url;password=$passbad1;401"
test7="$url;password=$passbad2;401"
test8="$url;password=$passbad3;401"
test3a="$url;password=$passbad4;401"
test9="$url;&password=$pass2;200"
test10="/logout;&;200"
test11="/login;&pseudo=$pseudo&password=$pass2;200"
test12="$url;&pseudo=$pseudo&password=$pass;200"
test13="/logout;&;200"
test14="/login;&pseudo=$pseudo&password=$pass;200"
test15="/logout;&;200"

tests=( $testa $test0 $test1 $test1a $test1b $test2 $test3 $test3a $test4 $test5 $test6 $test7 $test8 $test9 $test10 $test11 $test12 $test13 $test14 $test15 )
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
