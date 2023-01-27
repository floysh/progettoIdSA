# ZonkoShop

ZonkoShop è un ecommerce di articoli per maghi e avventurieri.
Gli articoli nel negozio sono suddivisi in quattro categorie: accessori, armi, magie e oggetti. Ogni articolo è dotato di prezzo, descrizione e disponibilità (limitata).
Ci sono due tipologie di utenti: gli avventurieri e i mercanti. 

Gli avventurieri sono i clienti del negozio, possono acquistare gli articoli pubblicati dai mercanti e consultare il proprio storico ordini.
Ogni cliente è dotato di un carrello per poter acquistare più articoli in un unico ordine.

I mercanti possono mettere in vendita i propri articoli, modificarli e rifornire le scorte. Ogni mercante può controllare lo storico degli ordini che ha ricevuto dai propri clienti.

## Installazione e configurazione

Questo progetto richiede NPM 8.19, PHP 8.1 (o superiore) e il gestore di pacchetti  `composer` installato. 
Per eseguire i test di Laravel Dusk è necessario aver installato Chrome o Chromium.

Clonare il repository:

    git clone https://github.com/floysh/progettoIdSA

Installare le dipendenze:

    composer require
    npm install

Creare un file di configurazione per l'ambiente locale:

    cp .env.example .env
    php artisan key:generate

Compilare SCSS e JS con Laravel Mix:

    npx mix

*Nota: (per lo sviluppo) Si può usare `npx mix --watch` per ricompilare automaticamente tutti gli asset ogni volta che il bundler rivela cambiamenti*

Creare il database per l'ambiente locale:

    php artisan migrate

Popolare il database con dati di esempio: *(facoltativo)*

    `php artisan db:seed`

A questo punto l'app è pronta per essere utilizzata. Avviare il server 

    php artisan serve

### Configurare Laravel Dusk
Questa parte non è necessaria per eseguire l'applicazione. Per eseguire i test di Laravel Dusk sono necessari alcuni passaggi in più:

1. Installare una versione di ChromeDriver compatibile con la propria versione di Chrome. Per installare l'ultima versione disponibile:

    ``` php artisan dusk:chrome-driver ```

    Per installare una versione diversa, fare riferimento alla [guida di Laravel Dusk](https://laravel.com/docs/9.x/dusk#managing-chromedriver-installations)

2. Creare un database di test separato

    ``` touch database/test-dusk.sqlite```

**Nota:** Potrebbe essere necessario modificare il percorso al file di database specificato in `env.dusk.local` inserendo il percorso assoluto al posto di quello relativo.

---

## Requisiti
* ZonkoShop è un e-commerce di prodotti per avventurieri di mondi fantasy.
* I prodotti sono suddivisi in quattro categorie: accessori, armi, magie e oggetti. 
* Ogni prodotto è dotato di nome, prezzo, descrizione e di una disponibilità limitata.
* Il negozio è dotato di una barra di ricerca per trovare i prodotti nel catalogo
    * La barra di ricerca è dotata di autocompletamento
    * Mentre l’utente scrive, sono suggeriti alcuni prodotti che fanno match con la query di ricerca
    * Il match viene fatto sul nome e sulla descrizione del prodotto
    * Cliccando su un suggerimento si viene reindirizzati alla pagina del prodotto
    * Premendo il tasto Invio sono visualizzati tutti i risultati della 
    ricerca

### Utenti
* Ogni utente deve autenticarsi per svolgere operazioni diverse dalla consultazione del catalogo
* Ogni utente ha un nome, un saldo e un ruolo
* Ci sono due ruoli: avventuriero (cliente) e mercante
---
* I mercanti non possono fare acquisti
* Ogni mercante può inserire, modificare, rifornire e rimuovere dal catalogo i propri prodotti
* I prodotti rimossi dal catalogo sono nascosti e non possono essere acquistati
* Un mercante non può modificare o rimuovere dal catalogo prodotti di mercanti concorrenti
---
* Gli avventurieri sono i clienti del negozio. Possono solo acquistare i prodotti messi in vendita dai mercanti
* Ogni avventuriero può acquistare più oggetti contemporaneamente, anche di mercanti diversi
* La procedura di acquisto avviene in due fasi:
    1. Inserimento di uno o più articoli nel carrello
    2. Conferma ordine
* Non è possibile confermare ordini vuoti


### Carrello e procedura d'acquisto
* Il carrello può essere usato solo dagli avventurieri
* Il carrello può essere vuoto o contenere uno o più prodotti
* Nei carrelli non devono esserci prodotti duplicati.
* Gli avventurieri possono inserire e rimuovere i prodotti dal carrello
* Gli avventurieri possono inserire nel carrello più unità dello stesso prodotto
* Gli avventurieri possono modificare il numero di unità desiderate per ogni prodotto nel carrello
* I prodotti nel carrello vengono riservati per l'acquisto da parte dell'avventuriero finchè questi non li rimuove o completa l'ordine
---
* Quando l'avventuriero completa l'acquisto, viene creato un nuovo ordine contenente tutti i prodotti nel suo carrello
* Quando l'avventuriero completa l'acquisto, il carrello viene svuotato
* Quando l'avventuriero completa l'acquisto, parte del suo saldo viene trasferito ai mercanti, in base ai prezzi e alle quantità dei prodotti acquistati
---
* L’avventuriero non può completare l’acquisto:
    * se il suo saldo è inferiore al totale del carrello
    * se nel suo carrello sono presenti eventuali prodotti rimossi dal catalogo


### Ordini
* Un ordine deve contenere almeno un prodotto
* Un ordine può contenere più prodotti, anche di mercanti diversi
* Gli avventurieri possono consultare il proprio storico ordini
* I Mercanti possono consultare lo storico ordini dei propri clienti
* Se nell’ordine sono presenti prodotti di diversi mercanti, al mercante sono mostrati solo i propri prodotti

