Worthy-Stony-Morning
====================

Assignment for webs2

##Architectuur
###Entry point
Het entry point is `./index.php`. Door middel van URL reqriting worden alle request
naar toe doorgestuurd op apache. Hierin wordt `./bootstrapping.inc.php` aangeroepen.

Vervolgens wordt een nieuw klasse `Request` gemaakt welke de URI onderdelen splitst
in een controller gedeelte, actie gedeelte en eventuele paramters.

Vervolgens wordt door de klasse `Router` de `Request` verwerkt. Hierin wordt gekeken
of de aangevraagde controller en action (methode) bestaat. Vervolgens wordt deze
controller gemaakt en de actie aangeroepen. De return waarde van de controller is
de body van de response.

###Bootstrapping
Het bootstrappen gebeurt in `./bootstrapping.inc.php`. Hierin worden een aantal
handige constans gedefineerd. Vervolgens wordt er een autoloader ingeladen welke
het laden van alle vervolg klassen op zich neemt.

###Views
Alle views zijn html en php door elkaar. Deze bevinden zich in de map `views` en
eindigen in `.phtml`. Bij het maken van de klasse `Template` kun je all variabele
toewijzen, deze worden uitgepakt in de daadwerkelijke variabele in het `.phtml`
bestand.
