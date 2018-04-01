SELECT DISTINCT  COALESCE( net24 ::cidr,  COALESCE( net25 ::cidr,  COALESCE( net26 ::cidr,  COALESCE( net27 ::cidr,  COALESCE( net28 ::cidr,  COALESCE( net29 ::cidr,  COALESCE( net30 ::cidr,  COALESCE( net31 ::cidr, ip32 :: cidr )  )  )  )  )  )  )  )  AS nets 
FROM (
    select network ( set_masklen(ip, 32) ) AS ip32 -- network ( set_masklen(ip, 32) ) AS ip32  	
    from bat.ips
    order by 1
) AS ip    
     
	LEFT JOIN ( 
	SELECT network ( set_masklen(ip, 31) ) AS net31  	
    	    from bat.ips
            group by network ( set_masklen(ip, 31) )
            having count(*) = 2
            ORDER BY 1	    
	) AS net31 ON network( set_masklen( ip.ip32, 31 ) )  =  net31.net31 
	LEFT JOIN ( 
	SELECT network ( set_masklen(ip, 30) ) AS net30  	
    	    from bat.ips
            group by network ( set_masklen(ip, 30) )
            having count(*) = 4
            ORDER BY 1	    
	) AS net30 ON network( set_masklen( ip.ip32, 30 ) )  =  net30.net30 
	LEFT JOIN ( 
	SELECT network ( set_masklen(ip, 29) ) AS net29  	
    	    from bat.ips
            group by network ( set_masklen(ip, 29) )
            having count(*) = 8
            ORDER BY 1	    
	) AS net29 ON network( set_masklen( ip.ip32, 29 ) )  =  net29.net29 
	LEFT JOIN ( 
	SELECT network ( set_masklen(ip, 28) ) AS net28  	
    	    from bat.ips
            group by network ( set_masklen(ip, 28) )
            having count(*) = 16
            ORDER BY 1	    
	) AS net28 ON network( set_masklen( ip.ip32, 28 ) )  =  net28.net28 
	LEFT JOIN ( 
	SELECT network ( set_masklen(ip, 27) ) AS net27  	
    	    from bat.ips
            group by network ( set_masklen(ip, 27) )
            having count(*) = 32
            ORDER BY 1	    
	) AS net27 ON network( set_masklen( ip.ip32, 27 ) )  =  net27.net27 
	LEFT JOIN ( 
	SELECT network ( set_masklen(ip, 26) ) AS net26  	
    	    from bat.ips
            group by network ( set_masklen(ip, 26) )
            having count(*) = 64
            ORDER BY 1	    
	) AS net26 ON network( set_masklen( ip.ip32, 26 ) )  =  net26.net26 
	LEFT JOIN ( 
	SELECT network ( set_masklen(ip, 25) ) AS net25  	
    	    from bat.ips
            group by network ( set_masklen(ip, 25) )
            having count(*) = 128
            ORDER BY 1	    
	) AS net25 ON network( set_masklen( ip.ip32, 25 ) )  =  net25.net25 
	LEFT JOIN ( 
	SELECT network ( set_masklen(ip, 24) ) AS net24  	
    	    from bat.ips
            group by network ( set_masklen(ip, 24) )
            having count(*) = 256
            ORDER BY 1	    
	) AS net24 ON network( set_masklen( ip.ip32, 24 ) )  =  net24.net24 
    ORDER BY 1 