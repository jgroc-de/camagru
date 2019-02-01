#!/bin/bash

pseudo="test"
password="Test00"

#manque listbylike ,et reinitget et validation
testa="/camagru/aieuaieaiue;a;404"
testb="/aieaueaue;a;404"
testc="//lol;a;404"
test0="/home;a;200"
test1="/camagru;a;403"
test2="/;a;200"
test3="/picture;a;401"
test4="/picture/1;a;200"
test5="/picture/0;a;404"
test6="/picture/20000;a;404"
test7="/login;&pseudo=test&password=$password;200"
test8="/home;a;200"
test9="/camagru;a;200"
test10="/;a;200"
test11="/picture;a;401"
test12="/picture/1;a;200"
test13="/picture/0;a;404"
test14="/picture/20000;a;404"
test15="/logout;&;200"

tests=( $testa $testb $testc $test1 $test1a $test1b $test2 $test3 $test3a $test4 $test5 $test6 $test7 $test8 $test9 $test10 $test11 $test12 $test13 $test14 $test15 )
j=0

printf "*** \033[32mtests\033[0m *** \n"
success=0
total=${#tests[@]}
bool=0
for i in ${tests[@]}; do
	array=(${i//;/ })
	if [ "${array[0]}" == "/login" ] || [ "${array[0]}" == "/logout" ]; then
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
	else
		response=$(curl -w "%{http_code}\n"\
			-o /dev/null\
			-c cookieMonster\
			-b cookieMonster\
			-s "http://localhost:8080${array[0]}"\
			-H 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:64.0) Gecko/20100101 Firefox/64.0'\
			-H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'\
			-H 'Accept-Language: fr,fr-FR;q=0.8,en-US;q=0.5,en;q=0.3'\
			--compressed\
			-H 'Referer: http://localhost:8080/'\
			-H 'DNT: 1' -H 'Connection: keep-alive'\
			-H 'Upgrade-Insecure-Requests: 1')
	fi
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
