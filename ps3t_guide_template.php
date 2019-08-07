<HTML>
<HEAD>
<TITLE>Trophy / Achievement Guide Template</TITLE>
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
    
    $gameurl = $_GET['game'];
    $gamesite = $_GET['site'];
    
    // Create stuff based on site
    if ($gamesite == 'ps3t') {
        $siteurl = 'playstationtrophies.org';
        $linkreplace = '/trophies/';
        $typereplace = 'trophy';
        $typereplacec = 'Trophy';
        $typereplaces = 'trophies'; }
    else {
        $siteurl = 'xboxachievements.com';
        $linkreplace = '/achievements/';
        $typereplace = 'achievement';
        $typereplacec = 'Achievement';
        $typereplaces = 'achievements'; }
    
    // Retrived the DOM
    $html = file_get_html('http://www.' . $siteurl . '/game/' . $gameurl . $linkreplace);
    
    // GAME NAME
    foreach($html->find('div') as $d) {
        if ($d->first_child()->class == 'tt') {
            echo $d->first_child()->plaintext . '<BR><BR><BR>';
            break; }
    }
    unset($d);
    
    // GAME FORUM
    foreach($html->find('a') as $d) {
        if ($d->class == 'link_w2') {
            if ($d->target == '_blank') {
                $gameforum = 'http://www.' . $siteurl . $d->href;
                break; }
        }
    }
    unset($d);
    
    // Create more stuff based on site
    if ($gamesite == 'ps3t') {
        
        // TROPHY TOTALS
        $completion = '100%';
        $numbronze = 0;
        $numsilver = 0;
        $numgold = 0;
        $numplat = 0;
        $numhidden = 0;
        foreach($html->find('img') as $p) {
            switch ($p->src) {
                case '/images/site/icons/trophy_bronze.png':
                    $numbronze++;
                    break;
                case '/images/site/icons/trophy_silver.png':
                    $numsilver++;
                    break;
                case '/images/site/icons/trophy_gold.png':
                    $numgold++;
                    break;
                case '/images/site/icons/trophy_platinum.png':
                    $numplat++;
                    $completion = 'platinum';
                    break;
                case '/images/site/icons/trophy_secret.png':
                    $numhidden++;
                    break;
            }
        }
        
        $totaltrophies = $numbronze + $numsilver + $numgold + $numplat + $numhidden;
        $totalscore = 0;
        
    }
    else {
        
        // ACHIEVEMENT TOTALS
        $completion = 0;
        $totaltrophies = 0;
        $totalscore = 0;
        
        foreach($html->find('td') as $p) {
            if ($p->class == 'ac4') {
                $completion += trim($p->first_child()->plaintext);
                $totaltrophies++; }
        }
        
        $totalscore = $completion;
        $completion .= ':1gs:';
        
    }
    
    // ROADMAP
    
    if ($gamesite == 'ps3t') {
        echo '[B][U]Overview:[/U][/B]<br>';
        echo '[LIST]<br>';
        
        // DIFFICULTY RATING / THREAD
        echo '[*][B]Estimated ' . $typereplace . ' difficulty:[/B]';
        
        echo '<br>';
        
        // TROPHY COUNTS
        echo '[*][B]Offline ' . $typereplaces . ':[/B] ';
        echo $totaltrophies;
        echo ' (';
        
        if ($numhidden > 0) {
            $breakdown = $numhidden . '(H)'; }
        
        if ($numbronze > 0) {
            if (strlen($breakdown) > 0) {
                $breakdown .= ', '; }
            $breakdown .= $numbronze . '(B)'; }
        
        if ($numsilver > 0) {
            if (strlen($breakdown) > 0) {
                $breakdown .= ', '; }
            $breakdown .= $numsilver . '(S)'; }
        
        if ($numgold > 0) {
            if (strlen($breakdown) > 0) {
                $breakdown .= ', '; }
            $breakdown .= $numgold . '(G)'; }
        
        if ($numplat > 0) {
            if (strlen($breakdown) > 0) {
                $breakdown .= ', '; }
            $breakdown .= $numplat . '(P)'; }
        
        echo $breakdown . ')<br>';
        echo '[*][B]Online ' . $typereplaces . ':[/B]<br>';
        
        echo '[*][B]Approximate amount of time to ' . $completion . ':[/B]<br>';
        echo '[*][B]Minimum number of playthroughs:[/B]<br>';
        echo '[*][B]Number of missable ' . $typereplaces . ':[/B]<br>';
        echo '[*][B]Glitched ' . $typereplaces . ':[/B]<br>';
        echo '[*][B]Does difficulty affect trophies?:[/B]<br>';
        echo '[*][B]Do ' . $typereplaces . ' stack?:[/B]<br>';
        echo '[*][B]Do cheat codes disable ' . $typereplaces . '?:[/B]<br>';
        echo '[*][B]Additional peripherals required?:[/B]<br>';
        echo '[/LIST]'; }
    
    else {
        echo '[B]Overview:[/B]<br>';
        echo '- Estimated ' . $typereplace . ' difficulty: [B]/10 [[COLOR=Green]Achievement Difficulty Rating[/COLOR]][/B]<br>';
        
        // ACHIEVEMENT COUNTS
        echo '- Offline: [B]';
        echo $totaltrophies . ' [' . $totalscore . ':1gs:][/B]<br>';
        echo '- Online: [B][:1gs:][/B]<br>';
        echo '- Approximate amount of time to ' . $completion . ': [B] [[COLOR=Green]Estimated Time to 100%[/COLOR]][/B]<br>';
        echo '- Minimum number of playthroughs needed: [B][/B]<br>';
        echo '- Missable ' . $typereplaces . ': [B][/B]<br>';
        echo '- Does difficulty affect ' . $typereplaces . ': [B][/B]<br>';
        echo '- Unobtainable/glitched ' . $typereplaces . ': [B][/B]<br>';
        echo '- Extra equipment needed: [B][/B]<br>';
        
        $firstDLC = 0;
        
        // DLC OVERVIEWS
        foreach($html->find('tr') as $x) {
            
            // DLC NAME
            if ($x->first_child()->class == 'newsTitle') {
                
                // Only write the first LIST tag for the first DLC
                if ($firstDLC == 0) {
                    echo '<br>[LIST]<br>'; }
                
                if ($firstDLC > 0) {
                    echo '<br>'; }
                
                echo '[*][B]' . $x->first_child()->plaintext . '[/B]<br>';
                echo '[LIST]<br>[*]Difficulty: [B]/10[/B]<br>';
                
                // DLC TOTALS - pull from end of points header
                $scoreDLC = $x->next_sibling()->first_child()->plaintext;
                $scoreDLC = trim(substr($scoreDLC, -3));
                echo '[*]Time to ' . $scoreDLC . ':1gs:: [B][/B]<br>';
                
                echo '[*]Unobtainable: [B][/B]<br>';
                echo '[/LIST]<br>';
                
                $firstDLC++;
                
            }
            
        }
        
        if ($firstDLC > 0) {
            echo '[/LIST]<br>'; }
        
        echo '<br>[B]Introduction:[/B]<br><br>';
        echo '[B]Abbreviated Walkthrough:[/B]<br><br>';
        echo '[B]Multiplayer:[/B]<br><br>';
        echo '[B]Mop-Up:[/B]<br><br><br>';
        
        // DLC WALKTHROUGHS
        foreach($html->find('tr') as $x) {
            
            // DLC NAME
            if ($x->first_child()->class == 'newsTitle') {
                
                echo '[CENTER][B]' . $x->first_child()->plaintext .
                '[/B][/CENTER]<br><br>';
                echo '[B]Abbreviated Walkthrough:[/B]<br><br><br>';
                
            }
            
        }
        
        echo '[B]Conclusion:[/B]'; }
    
    echo '<BR><BR><BR>';
    echo '[B][U]' . $typereplacec . ' Guide:[/U][/B]<BR><BR>';
    
    // TROPHY GUIDE
    
    foreach($html->find('tr') as $x) {
        
        // DLC NAME
        if ($x->first_child()->class == 'newsTitle') {
            
            echo '[B][SIZE=3]' . $x->first_child()->plaintext . '[/SIZE][/B]<BR><BR>';
            
        }
        
        if ($x->first_child()->class == 'ac1') {
            
            $e = $x->first_child();
            
            // TROPHY IMAGE
            if ($e->first_child()->class == 'link_ach') {
                echo '[IMG]http://www.' . $siteurl .
                $e->first_child()->first_child()->src . 
                '[/IMG]'; }
            elseif (substr($e->first_child()->href, strlen($e->first_child()->href)-4, 4) != 'html') {
                // This is for trophies with double quotes in their name... the links don't end in html
                echo '[IMG]http://www.' . $siteurl .
                $e->first_child()->first_child()->src .
                '[/IMG]'; }
            else {
                // HIDDEN UNKNOWN TROPHY
                echo '[IMG]http://www.' . $siteurl . 
                $e->first_child()->src . '[/IMG]'; }
            echo '&nbsp;';
            
            // TROPHY NAME
            $f = $e->next_sibling();
            if ($f->first_child()->class == 'link_ach') {
                echo '[B]' . $f->first_child()->first_child()->plaintext . 
                '[/B]&nbsp;'; }
            else {
                // HIDDEN UNKNOWN TROPHY
                echo '[B]' . $f->first_child()->plaintext . '[/B]&nbsp;'; }
            
            // TROPHY TYPE
            $g = $f->next_sibling();
            
            if ($gamesite == 'ps3t') {
                
                $g2 = $g->first_child()->first_child()->src;
                
                if ($g2 == '/images/site/icons/trophy_bronze.png') {
                    echo '(B)'; }
                else if ($g2 == '/images/site/icons/trophy_silver.png') {
                    echo '(S)'; }
                else if ($g2 == '/images/site/icons/trophy_gold.png') {
                    echo '(G)'; }
                else if ($g2 == '/images/site/icons/trophy_platinum.png') { 
                    echo '(P)'; }
                else { }
                
                // HIDDEN TROPHY
                if ($x->class == 'secret') {
                    echo '(H)'; }
                
            }
            
            else {
                
                // GAMERSCORE
                echo '&nbsp;' . trim($g->first_child()->plaintext) . ':1gs:';
                
            }
            
            echo '<BR>';
            
        }
        
        if ($x->first_child()->class == 'ac3') {
            
            // TROPHY DESCRIPTION
            if ($x->first_child()->plaintext == '&nbsp;') {
                echo '<BR><BR>'; }
            else {
                echo '[I]' . $x->first_child()->plaintext . 
                '[/I]<BR><BR><BR>'; }
            
        }
        
    }
    
    $html->clear(); 
    unset($html);
    
    ?>   

<BR><BR>

</BODY>
</HTML>
