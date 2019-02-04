#!/bin/bash

url="/createPic"
pseudo="test"
pass="Test00"
data=$1
datab1="data:image/auie;base64,auiestcaiueSTCIUSTECUIEcisutceasitecaueiusacIST"
datab2="data:image/png;base62,auiestcaiueSTCIUSTECUIEcisutceasitecaueiusacIST"
datab3="data:image/png;base64,auiestcaiueSTCIUSTECUIEcisutceasitecaueiusacIST"
t0="mouton"
t1="flamme"
t2="bambou"
t3="troll"
tbad1="troo"
tbad2="-@-@-+@aecaiu ca=»* «» /ô/- e s ciuea de ieaui aiu"
tbad3="t,iu,aiuc lceciu eacc ianuci uaeae vé dvavopé "

testa="$url'&data=$data&title0=$t0&title1=$t1'403"
testb="/login'&pseudo=$pseudo&password=$pass'200"
test0="$url'&'401"
test1="$url'&data=$data&title0=$t1&title1=$t1'200"
test1="$url'&data=$data&title0=$t1&title1=$t3'200"
test1="$url'&data=$data&title0=$tbad1&title1=$t1'403"
test2="$url'&data=$data&title0=$tbad2&title1=$t1'403"
test3="$url'&data=$data&title0=$tbad3&title1=$t1'403"
test4="$url'&data=$data&title20=$t0&title1=$t1'200"
test5="$url'&data=$data&title20=$t0&title124=$t1'200"
test6="$url'&data=&title0=$t0&title1=$t1'403"
test7="$url'&data='401"
test8="$url'&data=$datab1&title0=$t0&title1=$t1'403"
test9="$url'&data=$datab2&title0=$t2&title1=$t3'403"
test10="$url'&data=$datab3&title0=$t3&title1=$t0'403"
test11="$url'&data=$data&title0=$t0&title1=$t1'403"
test12="$url'&url=$id'200"
test13="/logout'&'200"

tests=( $testa $testb $testc $test0 $test1 $test1a $test1b $test2 $test3 $test3a $test4 $test5 $test6 $test7 $test8 $test9 $test10 $test11 $test12 $test13 $test14 $test15 $test16 $test17 $test18 )
j=0

printf "*** \033[32mtests\033[0m *** \n"
success=0
total=${#tests[@]}
bool=0
for i in ${tests[@]}; do
	array=(${i//\'/ })
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
