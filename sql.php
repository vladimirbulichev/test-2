<?php
    require_once( "dbconf.php" );
    function buildCol( $net ) {
	if ( $net == 32 ) {
	    return "ip32 :: cidr";
	}
	else{
	    return " COALESCE( net". $net ." ::cidr, " . buildCol( $net + 1 ) . " ) ";
	}
    }
    
    function buildJoin( $net ){
	$count = 1 << ( 32 - $net );
	$result = " 
	LEFT JOIN ( 
	SELECT network ( set_masklen(ip, " . $net . ") ) AS net".$net ."  	
    	    from bat.ips
            group by network ( set_masklen(ip, " . $net . ") )
            having count(*) = " . $count . "
            ORDER BY 1	    
	) AS net" . $net . " ON network( set_masklen( ip.ip32, " . $net . " ) )  =  net" . $net. ".net" . $net ;
	return $result;
    }
    
    $startNet = 24; $endNet = 32;
    $cols = "SELECT DISTINCT " . buildCol( $startNet ) . " AS nets ";
    
    $query = $cols . "
FROM (
    select network ( set_masklen(ip, 32) ) AS ip32 -- network ( set_masklen(ip, 32) ) AS ip32  	
    from bat.ips
    order by 1
) AS ip    
    ";
    $leftJoin = "";
    for ( $i = $endNet - 1; $i>=$startNet;$i-- ){
	$leftJoin .= buildJoin( $i );
    }

    $query = $query . $leftJoin . " 
    ORDER BY 1 ";
    
    /*
    
    $f = fopen( "ips.txt", "r" );
    while( $str = trim( fgets( $f ) ) ) {
	$q = "INSERT INTO bat.ips ( ip ) VALUES ( '" . $str . "' ) ";
	pg_query( $conn, $q );
    }*/
    
    $sql=pg_query( $conn, $query);
    while ( $data = pg_fetch_assoc( $sql ) ) {
	echo $data[ "nets" ] . "\n";
    }
