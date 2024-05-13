1. .env fálj létrehozása 
    .env.sample alapján
2. .env fájlban MySQL kapcsolat beállítása 
    Felhasználó név és jelszó
3. Console/Terminal parancsok futtatása sorban
    composer update
    php artisan make:database {databasename} 
    php artisan migrate
    php artisan optimize:clear
4. Adatbázis felötlése adatokkal
    URL meghívása
        .../rickandmorty/init
    vagy Console/Terminal parancs
        php artisan app:init-data-ram
    vagy Gomb megnyomással a böngészőben        
        .../rickandmorty
5. Adatoldal
    .../rickandmorty


A feladat végrhajtása körül belül 11 órát vett igénybe:
- Adatbázis megtervezés, modellek és migrációk elkészítése ~2 óra
- Back-end elkészítése (adat szinkron, feldogozás, formázás és megjelenítés) ~4 óra
- Front-end elkészítése Pluginek beépítése, Front-end elkészítése (design, scriptek, adat manipuláció)  ~4 óra
- Finomítások, refactor ~1 óra
