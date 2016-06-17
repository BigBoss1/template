#! /bin/bash

for f in `find . -name '*.php' -o -name '*.sql' -o -name '*.html'  -o -name '*.css'`; do 
    cat $f; 
done | wc -l
