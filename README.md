# S-expression parser and serializer for PHP

A simple class to work with [S-expressions](http://en.wikipedia.com/wiki/S-expression) 
(symbolic expressions). From the Wikipedia:

> S-expressions or sexps (for "symbolic expression") are list-based data structures that 
  represent semi-structured data. An S-expression may be a nested list of smaller 
  S-expressions. S-expressions are probably best known for their use in the Lisp family 
  of programming languages.

Note that this parser is not suitable to work with very large files (several megabytes and
above), since the whole file is parsed and stored in a memory structure based on arrays.


## Supported syntax

This implementation supports the following syntax (in BNF format):

	<sexpr>    	:: <string> | <list>
	<string>   	:: <token> | <base64> | <hex> | <quoted> ;
	<token>    	:: <tokenchar>+ ;
	<base64>  	:: "|" ( <alpha> | <digit> | "+" | "/" | "=" )* "|" ;
	<hex>   	:: "#" ( <digit> | "A" ... "F" | "a" ... "f" | <space> )* "#" ;
	<quoted> 	:: "\"" <bytes> "\"" | "'" <bytes> "'" ;
	<list>     	:: "(" ( <sexp> | <space> )* ")" ;
	<tokenchar> :: <alpha> | <digit> | <punc> ;
	<space>		:: ( " " | "\t" | "\r" | "\n" )* ;
	<digit>		:: "0" ... "9" ;
	<alpha>     :: "A" ... "Z" | "a" ... "z" | <digit> ;
	<punc> 		:: "-" | "." | "/" | "_" | ":" | "*" | "+" | "=" ;
	<comment>	:: ";" <bytes> -- until the end of line


## Example s-expression syntax

	(foo
		"this is a \"quoted\" string"
		"also supporting\nnew lines"
		"The following number will be automatically casted to an integer"
		1231
		"unless you call ->setCastNumbers(false)"
		(bar
			; Line comment
			(int 10) ; This is a comment too
			(float 3.1415)
			(string "foobar")
			(string 'single quotes')
			(base64 |YWJj|)     ; "abc" encoded in base64
			(hex #61 62 63#)    ; "abc" encoded as hex octets			
		)
	)
	
## Library usage

	$sexp = new \DrSlump\Sexp();
	
	// Parse an s-expression and return an array with the data
	$arr = $sexp->parse('(foo (bar 10) baz)');
	
	print_r($arr);
	
	// Array
  	// (
	//    [0] => foo
	//    [1] => Array
	//        (
	//            [0] => bar
	//            [1] => 10
	//        )
	//
	//    [2] => baz
	// )
	
	// Serialize an array structure into an s-expression string
	$exp = $sexp->serialize($arr);


## LICENSE

    The MIT License

    Copyright (c) 2011 Iván -DrSlump- Montes

    Permission is hereby granted, free of charge, to any person obtaining
    a copy of this software and associated documentation files (the
    'Software'), to deal in the Software without restriction, including
    without limitation the rights to use, copy, modify, merge, publish,
    distribute, sublicense, and/or sell copies of the Software, and to
    permit persons to whom the Software is furnished to do so, subject to
    the following conditions:

    The above copyright notice and this permission notice shall be
    included in all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED 'AS IS', WITHOUT WARRANTY OF ANY KIND,
    EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
    MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
    IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
    CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
    TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
    SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.



