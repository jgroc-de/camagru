#!/bin/bash

url="contact"
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

testa="login;&pseudo=test&password=Test00;200"
testb="$url;&name=$pseudo&subject=$subject&message=$message&email=$email;200"
testc="logout;&;200"
test1="$url;&name=$pseudo&subject=$subject&message=$message&email=$email;200"
test2="$url;&;401"
test3="$url;&name=$pseudo&subject=$subject&message=$message;401"
test4="$url;&subject=$subject&message=$message&email=$email;401"
test5="$url;&name=$pseudolong&subject=$subject&message=$message&email=$email;401"
test6="$url;&name=$pseudobad1&subject=$subject&message=$message&email=$email;401"
test7="$url;&name=$pseudo&subject=$subject&message=$messagebad&email=$email;401"
test8="$url;&name=$pseudo&subject=$subject&message=$message&email=$emailbad1;401"
test9="$url;&name=$pseudo&subject=$subject&message=$message&email=$emailbad2;401"
test10="$url;&name=$pseudo&subject=$subjectbad&message=$message&email=$email;401"

tests=( $testa $testb $testc $test0 $test1 $test1a $test1b $test2 $test3 $test3a $test4 $test5 $test6 $test7 $test8 $test9 $test10 $test11 $test12 $test13 $test14 $test15 )
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
printf "\n*** \033[32mend\033[0m *** \n"
rm cookieMonster;
