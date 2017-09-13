# bbcode_guide_template
BBCode Guide Template for playstationtrophies.org and xboxachievements.com.

The live version of this script can be found here: http://www.vyrastas.com/guide_template.htm

I wrote this script to enable easy creation of trophy / achievement guides in the forums of [playstationtrophies.org](www.playstationtrophies.org) and [xboxachievements.com](www.xboxachievements.com). You select the site and game, copy the resulting BBCode, and fill it in with trophy / achievement explanations. Simples.

Site threads where I originally posted it:

* [PlaystationTrophies](https://www.playstationtrophies.org/forum/guide-central/202570-ultimate-bbcode-trophy-guide-template.html)
* [XboxAchievements](https://www.xboxachievements.com/forum/showthread.php?t=500386)

Here is an example of a guide created with this template: [Sonic Adventure Trophy Guide](https://www.playstationtrophies.org/forum/sonic-adventure/72873-sonic-adventure-trophy-guide.html)

## How it works

Based on the site you choose (PST vs XBA), it first scrapes the HTML of a game letter page. For example, https://www.playstationtrophies.org/browsegames/ps4/h/. It presents that list of games to the user.

When a user selects a game from that list, it scrapes the HTML of the game's trophy / achievement page. For example, https://www.playstationtrophies.org/game/happy-dungeons/trophies/.

In other words, the script is completely reliant on the content of PST and XBA. If content is wrong in the script, it's wrong on the site, and needs to be fixed on the site.

The final output URL that displays in the lower frame can be determined by hacking it: http://www.vyrastas.com/ps3t_guide_template.php?site=ps3t&game=happy-dungeons. Change the `site` and `game` parameters as needed. `game` is based on the site page name for the game.

Platforms (PS4, Vita, etc) are hard-coded and must be added manually to the script.

## Contributing / Requests

If you want me to make an update to the script, and push it to http://www.vyrastas.com/guide_template.htm, create an Issue detailing what you would like done and I'll take care of it.

Otherwise feel free to submit your own pull requests, or even make a copy to host on your own site.

* guide_template.htm is the start page
* Put all files in the same directory
* Requires server-side PHP

## Acknowledgements

This project utilizes **Simple HTML Dom**, courtesy of Jose Solorzano: https://sourceforge.net/projects/php-html/. For more information, visit http://sourceforge.net/projects/simplehtmldom.
