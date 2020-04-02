<HTML>
<HEAD>
<TITLE>PS3Trophies.org Guide Template</TITLE>
<META name=VI60_defaultClientScript content=JavaScript>
<META http-equiv="Content-Type" Content="text/html; charset=UTF-16">
<META name="description" content="ps3trophies.org">
<META name="keywords" content="ps3trophies.org">

<link rel="stylesheet" type="text/css" href="ps3trophies.css">

</HEAD>

<BODY BGCOLOR=white>

<?php
    
    // Include the library
    include('simple_html_dom.php');
    
    // Get the variables from the selection
    $gamealpha = $_GET['alpha'];
    $gamesite = $_GET['site'];
    
    $forumnamecheck = 0;
    
    // Create gametype based on site
    if ($gamesite == 'ps3t') {
        
        $siteurl = 'playstationtrophies.org';
        $linkreplace = '/trophies/';
        $numtypes = 4;
        $gametype[0] = 'ps4';
        $gametype[1] = 'retail';
        $gametype[2] = 'psn';
        $gametype[3] = 'vita';
        $gametype[4] = 'japanese';
    }
    else {
        
        $siteurl = 'xboxachievements.com';
        $linkreplace = '/achievements/';
        $numtypes = 7;
        $gametype[0] = 'xbox-one';
        $gametype[1] = 'arcade';
        $gametype[2] = 'retail';
        $gametype[3] = 'app';
        $gametype[4] = 'japanese';
        $gametype[5] = 'pc';
        $gametype[6] = 'win8';
        $gametype[7] = 'wp7';
    }
    
    echo '<BR>';
    
    if ($gamesite == 'ps3t') {
        echo '<FONT COLOR=darkblue SIZE=3><STRONG>PLAYSTATION TROPHIES</STRONG>'; }
    else {
        echo '<FONT COLOR=darkgreen SIZE=3><STRONG>XBOX ACHIEVEMENTS</STRONG>'; }
    
    echo ' - ';
    
    if ($gamealpha == '-') {
        echo '0-9'; }
    else {
        echo strtoupper($gamealpha); }
    
    echo ' games</FONT><BR><BR>';
    
    // Retrieve the DOM from a given URL
    for ($i = 0; $i <= $numtypes; $i++) {
        
        if (($gametype[$i] == 'retail') && ($gamesite == 'ps3t')) {
            echo '<STRONG>PS3 RETAIL</STRONG><BR>'; }
        else if ($gametype[$i] == 'psn') {
            echo '<STRONG>PS3 DIGITAL</STRONG><BR>'; }
        else if ($gametype[$i] == 'xbox-one') {
            echo '<STRONG>XBOX ONE</STRONG><BR>'; }
        else if ($gametype[$i] == 'app') {
            echo '<STRONG>APPLICATIONS</STRONG><BR>'; }
        else {
            echo '<STRONG>' . str_replace('%20',' ',strtoupper($gametype[$i])) . '</STRONG><BR>'; }
        
        // Set number of pages dynamically
        $init_html = file_get_html('http://www.' . $siteurl . '/browsegames/' . $gametype[$i] . '/' . $gamealpha . '/');
        
        $pagination_obj = $init_html->find('div.pagination a');
        if (count($pagination_obj) == 0) { $page_num = 1; }
        else { $page_num = $pagination_obj[count($pagination_obj)-2]->plaintext; }
        
        $init_html->clear();
        unset($init_html);
        
        for ($j = 1; $j <= $page_num; $j++) {
            
            $html = file_get_html('http://www.' . $siteurl . '/browsegames/' . $gametype[$i] .
                                      '/' . $gamealpha . '/' . $j);
            foreach($html->find('a') as $x) {
            
                if (strncmp($x->href, '/game/', 6) == 0) {
                    
                    if ($x->class == 'linkT') {
                        
                        $y = $x->href;
                        
                        // get the game name
                        $game = str_replace($linkreplace,'',str_replace('/game/','',$y));
                        
                        echo '<A HREF="ps3t_guide_template.php?site=' . $gamesite .
                                    '&game=' . $game . '">';
                        
                        // remove any blank unnecessary spaces
                        $gamename = str_replace('&nbsp;','',$x->plaintext);
                        
                        if ($forumnamecheck) {
                            echo $gamename . '</A>';  }
                        else {
                            echo $gamename . '</A><BR>'; }
                    }
                }
                // FORUM LINK CHECK
                if ((strncmp($x->href, '/forum/', 7) == 0) && ($forumnamecheck)) {
                
                    if ($x->class == 'linkT') {
                    
                        $y = $x->href;
                        
                        // get the game name
                        $forum = str_replace('/forum/','',$y);
                        
                        echo '|<A HREF="http://www.' . $siteurl . $y . '" target="_blank">' . $forum . '</A><BR>';
                        
                    }
                }
            }
        }
        
        echo '<BR>';
        
        $html->clear();
        unset($html);
        
    }
    
?>

<BR><BR>

</BODY>
</HTML>
