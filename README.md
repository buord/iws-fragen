# myIWS - 

myIWS ist ein Tool, mit dem man leicht eine Übersicht über alle bisherigen Fragen aus allen Spielen bekommt, sodass man als Leiter/in nicht jedes Mal verzweifelt alle Threads durchgehen oder Gefahr laufen muss, eine Frage zu nehmen, die es bereits gab.

Es lässt sich auch einfach auf dem eigenen Rechner einrichten und modifizieren.

## Voraussetzungen
Für das technische Gelingen sind Apache, PHP und MySQL notwendig - [zur Installationsanleitung](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-16-04). Hier wurde beispielhaft der LAMP stack unter Ubuntu 16.04 angeführt, Anleitungen für andere Betriebssystem (z.B. mit MAMP, WAMP oder XAMMP) gibt es im Internet zur Genüge.
Weiterhin sollte beachtet werden, dass `mod_rewrite` aktiviert ist und Apache die `.htaccess` Datei beachtet, da dies für das Routing der Applikation wichtig ist.

## Einrichtung
### Datenbank anlegen und Tabelle importieren
Zunächst solltet ihr eine neue Datenbank anlegen (über die Kommandozeile, mit [MySQL Workbench](https://www.mysql.com/de/products/workbench/) oder einem anderen Programm) und dann die Tabelle `myiws.sql` - die ihr aus `myiws.sql.tar.gz` entpackt haben solltet - in die Datenbank importieren. Der Import geht einfach über den Terminal mit dem Befehl:

```sh
mysql -uroot -p myiws < myiws.sql
```
Falls du einen anderen Benutzernamen hast oder die Datenbank nicht `myiws` heißt, sollten die Werte natürlich entsprechend geändert werden.
Bei geglücktem Import hast du du nun alle Fragen in der Tabelle (Stand: 24 Runden).


### Umgebungsvariablen angeben
Nach dem Downloaden - oder dem Klonen mit git - der Repo ins Hauptverzeichnis des Servers (vermutlich `/var/www/html`), sollte die `.env.example` Datei in `.env` umbenannt werden oder eine neue `.env` Datei erstellt werden, wo dann der Inhalt aus `.env.example` reinkopiert wird.
Die dort vorgegebenen Variablen sollten erst ihre richtigen Werte bekommen.

Beispiel:

```
# local or production
APP_ENV=local
APP_DOMAIN=http://localhost
APP_BASEPATH=/myiws/public

# Database
DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=myiws
DB_USERNAME=root
DB_PASSWORD=meinpasswort
```

### .htpasswd anlegen

Das Formular, womit man neue Runden in die Datenbank speichern kann, ist passwortgeschützt. Um euch selbst ein Passwort zu geben, gebt den folgenden Befehl in den Terminal ein:

```sh
sudo htpasswd /var/www/html/myiws/.htpasswd username
```
`username` ersetzt ihr mit einem Namen eurer Wahl und den Pfad mit eurem eigenen.
Danach sollte der Pfad auch in `public/.htaccess` in der Zeile

```
AuthUserFile /var/www/html/myiws/.htpasswd
```

geändert werden.

Das war auch schon alles. Nun hast du alles lokal und kannst das Tool auch offline benutzen.

## Lizenz
IWS-Fragen steht unter der [GNU General Public License v3.0](https://www.gnu.org/licenses/gpl.html).
