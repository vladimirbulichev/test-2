<?php
	$f = fopen( "ips.txt", "r" );
	$s = time();
	$i = 0;
	while ( $str = trim( fgets( $f ) ) ) {
		$incadrs[$i] = ip2long( $str );
		$i++;
	}

	$incadrs = array_unique( $incadrs,SORT_NUMERIC );
	sort( $incadrs , SORT_NUMERIC );
//	print_r( $incadrs ); exit();
	$adrs = array_map(
		function($a) {
			return [ "adr" => $a, "net" => 32 ];
		}, $incadrs
	);
	for ( $exp = 1; $exp <= 8; $exp++ ){
		$mask = 0xFFFFFF00 | ( 256 - pow( 2, $exp ) ) ;
		$net = 32 - $exp;
/*		echo "Exp: " . $exp . "\n";
		echo "Mask: " . $mask . "\n";
		echo "Net: " . $net . "\n"; */
		$result = []; $ri = 0;
		for ( $i = 0; $i < count( $adrs ); $i++ ) {
			$curIP = $adrs[$i]["adr"];
			$nextIP = $adrs[$i+1]["adr"];
			$curNet = $adrs[$i]["net"];
			$nextNet = $adrs[$i+1]["net"];
			$xor = $curIP ^ $nextIP;
/*			echo "Cur IP:" . $curIP . "\n";
			echo "Next IP:" . $nextIP . "\n";
			echo "XOR: " . $xor ;*/
			$shift = $exp - 1 ;	
			if ( ( $curNet == ( $net + 1 ) && $curNet == $nextNet ) && ( $xor ) == ( 1 << $shift ) ) {
//				echo "NET!\n";
				$result[$ri]["adr"] = $curIP;
				$result[$ri]["net"] = $adrs[$i]["net"] - 1;
				$i++;
			}
			else{
				$result[$ri]["adr"] = $curIP;
				$result[$ri]["net"] = $adrs[$i]["net"];
			}
			$ri++;
//			echo "\n";
		}
//		print_r( $result );
		$adrs = $result;	
	}
	
	$result = array_map( function( $a ) {
		return long2ip( $a["adr"] ) . "/" . $a["net"] ;
	},  $result );
//	print_r( $result );
	$fResult = fopen( "result.txt", "w" );
	foreach ( $result as $k => $v ) {
		$str = $v . "\n";
		echo $str;
		fwrite( $fResult, $str );
	}	
	$e = time();
	echo "exec time: ". ( $e - $s ) ." sec";
?>