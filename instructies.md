
Setup Handleiding voor NerdyGadgets
Deze handleiding helpt je bij het instellen en uitvoeren van het Projectnaam op je lokale machine.

Vereisten
XAMPP geïnstalleerd op je machine.
Git geïnstalleerd op je machine.

Stappen
1. Clone de Repository
git clone https://github.com/jouwgebruikersnaam/projectnaam.git

2. Configureer XAMPP
Open XAMPP en start de Apache- en MySQL-services.

3. Importeer de Database
Open phpMyAdmin door naar http://localhost/phpmyadmin/ te gaan.
Maak een nieuwe database met de naam nerdy_gadgets_start.
Importeer het SQL-bestand dat zich bevindt in de database-map van het project.

4. Werk Databaseconfiguratie bij
Ga naar config/database.php.
Werk de databaseverbindinginstellingen bij met jouw lokale MySQL-inloggegevens.

5. Start het Project
Verplaats de projectmap naar de htdocs-map van je XAMPP-installatie.
Open het project in je browser: http://localhost/projectnaam/.

6. Vergeet niet npm install nog te doen, zodat je alle node modules hebt geinstalleerd. 
In dit project wordt namelijk tailwind gebruikt. 

Opmerking
In de xamp/mysql/data map staat ook nog alle gegevens die je nodig hebt, inplaats van stap 3. 
de .git map is hidden. Als je boven in de file explorer in de project map klikt op View - > Show - > Hidden items dan zou je de .git map moeten kunne zien.




