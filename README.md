# Event Mini-Projekt

Dies ist ein Mini-Projekt mit einem kleinen Event-Kalender in PHP entwickelt und Styling mit Bootstrap. Der Event-Kalender kann hier ausprobiert werden: https://marincomics.com/event-mini-projekt (die Details für einen Testuser-Account werden auf der Login-Seite angeführt).

Ziel dieses Projekts ist die Implementierung einer einfachen Event-Plattform. Events haben folgende Felder:
- ein Titel
- ein Startdatum
- falls notwendig ein Enddatum (z.B. bei mehrtägigen Festivals)
- ein Bundesland
- ein Bild (URL)
- eine Beschreibung
- und eine Kategorie (z.B. Ausstellung, Musikkonzert, Oper, usw.)


## Sitemap
![Sitemap](documentation/sitemap.png)

## Wireframes
![Wireframes](documentation/wireframes.png)

## Konzept
![Konzeptskizze](documentation/skizze.jpg)

## Beispieldaten
Im Verzeichnis `data` befindet sich die exportierte DB-Tabelle `event` mit Beispieldaten und `user` mit der Benutzertabelle. Importieren Sie diese Tabelle in Ihre Datenbank und passen Sie die Einstellungen in der Include-Datei `include_db.php` an.
