#!/bin/bash

sed 's/^pseudo="test"$/^pseudo="testRoot"$/' $1
sed 's/^pseudo="Test00"$/^pseudo="testRoot0"$/' $1
sed 's/^pseudo="Test00"$/^pseudo="testRoot0"$/' $1
