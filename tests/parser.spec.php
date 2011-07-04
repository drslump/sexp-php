<?php

include_once __DIR__ . '/../library/DrSlump/Sexp.php';

describe "Parser"
	before
		$W->sexp = new \DrSlump\Sexp();
	end

	it "should parse empty expressions"
		$arr = $W->sexp->parse('(an expression with () empty expressions () in it)');
		count($arr) should eq 9;
		$arr[3] should be array();
		$arr[6] should be array();
	end
	
	it "should parse quoted strings"
		$arr = $W->sexp->parse('(a "quoted" \'string\' with "escaped\nnew line")');
		count($arr) should eq 5;
		$arr[1] should eq 'quoted';
		$arr[4] should eq "escaped\nnew line";
	end
	
	it "should support comments"
		$arr = $W->sexp->parse('(
			; from start to end of line
			token ; after token
			"string" ; after string			
		)');
		count($arr) should eq 2;
		$arr[0] should be 'token';
		$arr[1] should be 'string';
	end
	
	it "should support base64 strings"
		$b64 = base64_encode('foobarbaz');
		$arr = $W->sexp->parse("(base64 |$b64|)");
		count($arr) should eq 2;
		$arr should eq array('base64', 'foobarbaz');
	end
	
	it "should support hex encoded strings"
		$hex = bin2hex('foobarbaz');
		$arr = $W->sexp->parse("(hex #$hex#)");
		count($arr) should eq 2;
		$arr should eq array('hex', 'foobarbaz');
	end
	
	# throws RuntimeException
	it "should throw exception if malformed"
		$W->sexp->parse('( parens do ( not match )');
	end
end
