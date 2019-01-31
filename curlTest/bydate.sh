#!/bin/bash

url="listPicsByDate"
id="1"
id1="1000000"
id2="-1"
id3="0"
id4="auieuiae"
id5="+"
id6="/"

testa="login;&pseudo=test&password=Test00;200"
testb="$url;&start=$id;200"
testc="logout;&;200"
test0="$url;&start=$id;200"
test1="$url;&start=$id1;404"
test2="$url;&start=$id2;401"
test3="$url;&start=$id3;401"
test4="$url;&start=$id4;401"
test5="$url;&start=$id5;401"
test6="$url;&start=$id6;401"
test7="$url;&startlol=$id6;401"
test8="$url;&start=;401"

tests=( $testa $testb $testc $test0 $test1 $test1a $test1b $test2 $test3 $test3a $test4 $test5 $test6 $test7 $test8 )

printf "*** \033[32mtests\033[0m *** \n"
j=0
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
printf "\n*** \033[32mend\033[0m *** \n"
rm cookieMonster;
