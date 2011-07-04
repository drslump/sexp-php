<?php

include_once __DIR__ . '/../library/DrSlump/Sexp.php';

describe "Serializer"
	before
		$W->sexp = new \DrSlump\Sexp();
		// Disable pretty print to ease the assertions
		$W->sexp->setPrettyPrint(false);
	end

	it "should serialize empty expressions"
		$exp = $W->sexp->serialize(array(
			'an', 'expression', 'with', array(), 'empty', 'expressions', array(), 'in', 'it'
		));
		
		$exp should eq '(an expression with () empty expressions () in it)';
	end
	
	it "should serialize quoted strings"
		$exp = $W->sexp->serialize(array(
			"escaped\nnew line", "quote \" char", 'single quote \' char'
		));

		$exp should eq "(\"escaped\nnew line\" \"quote \\\" char\" \"single quote ' char\")";
	end
	
	it "should serialize non printable as base64 strings"
		$exp = $W->sexp->serialize(array('base64', "\000\001\002"));
		$b64 = base64_encode("\000\001\002");
		$exp should eq "(base64 |$b64|)";
	end
	
	# throws RuntimeException
	it "should throw exception if non serializable variable"
		$W->sexp->serialize(array(
			'foo', 'bar', STDIN
		));
	end
end