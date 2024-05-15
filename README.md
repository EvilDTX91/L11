1. HOST beállítások
2. .env fálj létrehozása 
    .env.sample alapján
3. .env fájlban MySQL kapcsolat beállítása: 
    DB_CONNECTION=mysql
    DB_HOST=localhost
    DB_PORT=
    DB_USERNAME=root
    DB_PASSWORD=
4. Console/Terminal parancsok futtatása sorban
    composer update
    php artisan key:generate
    php artisan make:database {databasename} #Létrehozz az adatbázist és beírja .env fájlba
    php artisan migrate
    php artisan optimize:clear
5. Adatbázis felötlése adatokkal
    URL meghívása
        .../rickandmorty/init
    vagy Console/Terminal parancs
        php artisan app:init-data-ram
    vagy Gomb megnyomással a böngészőben        
        .../rickandmorty
6. Adatoldal
    .../rickandmorty


A feladat végrhajtása körül belül 11 órát vett igénybe:
- Adatbázis megtervezés, modellek és migrációk elkészítése ~2 óra
- Back-end elkészítése ~3 óra
- Front-end elkészítése Pluginek beépítése, Front-end elkészítése (design, scriptek, adat manipuláció)  ~5 óra
- Finomítások, refactor ~1 óra
